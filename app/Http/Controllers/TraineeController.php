<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Hash;
use Session;

use App\Events\NewUserRegisteredEvent;
use Carbon\Carbon;
use App\Model\Trainer;
use App\Model\Trainee;
use App\Model\Equipment;
use App\Model\UserEquipment;
use App\Model\UserHistory;
use App\Model\TrainerSchedule;
use App\Model\UserPlanPurchase;
use App\Model\PlanPurchase;
use App\Model\TrainerRecurringSchedule;


use DateTime;
use DateInterval;

class TraineeController extends Controller
{
    public $RECURSIVE=array();
    public $counter=0;

    public function traineeView(){
        return view('pages.trainer_details');
    }
    public function physicaldata(Request $request){
            $user = Trainee::find(Session::get('user.id'));

            return view('auth.physical_data')->with('user',$user)->with('equipment',Equipment::get());

    }

    public function physicaldatasubmit(Request $request){

       $validateData = $request->validate([

            'weight' => 'required',
            // 'fat' => 'required',
            'sex' => 'required',
            'birthday' => 'required',
            'height' => 'required',
        ]);

        $date= new DateTime();
        $trainee = Trainee::find($request->user_id);

        $trainee->sex = $request->input('sex');
        $trainee->dob = $request->input('birthday');
        $trainee->length = $request->input('height');
        $trainee->weight = $request->input('weight');
        if($request->input('pal') === 'high'){
             $trainee->pal =2;
        }
        if($request->input('pal') === 'low'){
             $trainee->pal= 1.55;

        }   
        if($request->input('pal') === 'medium'){
             $trainee->pal =1.75;

        }
        


        if($trainee->save()){
            //  EVENT TRIGGERED
            // event(new NewUserRegisteredEvent($trainee,'trainee'));
            // NOW SAVE DATA TO TBL_USER_HISTORY TABLE
            // if($request->input('weight')){
            //     $timing=$this->morningOrEvening();
            //     $history = new UserHistory();

            //     $history->weight_morning = ($timing== 'morning') ? $request->input('weight') : '' ;
            //     $history->weight_evening = ($timing== 'evening') ? $request->input('weight') : '' ;

            //     $history->body_fat_percentage_morning = ($timing== 'morning') ? $request->input('fat') : '' ;
            //     $history->body_fat_percentage_evening = ($timing== 'evening') ? $request->input('fat') : '' ;

            //     // $history->calory_gained = $request->input('weight');
            //     // $history->calory_consumed = $request->input('weight');

            //     $history->recorded_at = date('Y-m-d H:i:s');
            //     $history->user_id = $trainee->id;
            //     $history->save();
            // }
            
        }
                    return redirect()->route('purchaseplan')->with('message','Physical information added successfully');

    }
    public function checkPenalty($schedule_date,$user_id){

        $date = Carbon::parse($schedule_date);

        $start = $date->startOfWeek()->toDateString();
        $end = $date->endOfWeek()->toDateString();
        $count = TrainerSchedule::where('user_id',$user_id)
        ->where('status','cancelled_penalty')
        ->whereBetween('date', [$start, $end])->get()->count();
        // dd($count);
        $purchasePlan = UserPlanPurchase::where('status',1)->where('user_id',$user_id)->orderBy('id','ASC')->get()->first();
        $dayPerWeek = $purchasePlan->getPlan()->get()->first()->times_per_week;
        // 
        // dd($dayPerWeek);
        if($count >= $dayPerWeek){
            return true;

        }
        
        return false;
    }
    public function checkReservation($schedule_date,$user_id){

        $date = Carbon::parse($schedule_date);

        $start = $date->startOfWeek()->toDateString();
        $end = $date->endOfWeek()->toDateString();
        $count = TrainerSchedule::where('user_id',$user_id)->where('status',NULL)->whereBetween('date', [$start, $end])->get()->count();
        
        $purchasePlan = UserPlanPurchase::where('status',1)->where('user_id',$user_id)->orderBy('id','ASC')->get()->first();
        $dayPerWeek = $purchasePlan->getPlan()->get()->first()->times_per_week;
        // 
        if($count >= $dayPerWeek){
            return "count_exceed";

        }


        $planStartDate= Carbon::parse($purchasePlan->created_at)->format('Y-m-d');
        $convertTodate = Carbon::parse($planStartDate);
        $daysToAdd = 30*$purchasePlan->period_month;
        $planEndDate = $convertTodate->addDays($daysToAdd);

        $startDate = Carbon::parse($planStartDate);
        $endDate = Carbon::parse($planEndDate);

        $check = Carbon::parse($schedule_date)->between($startDate,$endDate);
        if(!$check){
            return "past_future";
        }
       return "not_error";
        // dump("plan end ".Session::get('user.expired_at'));
        // dump(" day per week " . $dayPerWeek);

        // dump("Count ".$count);
        
        // dd();
    }
    public function trainerSubmitBytime(Request $request){
        
        // dd($request->all());
        $tinfo = Trainer::find($request->trainer_id);

        // dd($tinfo);
        $rval = $this->checkReservation($request->date,Session::get('user.id'));
        // dd($rval);
        if($rval == 'count_exceed'){
            return redirect()->route('traineeCalendar.view')
            ->with('errors_m','プラン制限を超えました');
        }
        if($rval == 'past_future'){
                return redirect()->route('traineeCalendar.view')
                    ->with('errors_m','選択した日付がプランの開始日と終了日の間にありません');
        } 
        if(checkPastTIme($request->time,$request->date)){
                return redirect()->route('traineeCalendar.view')
                 ->with('errors_m','スケジュール時間が過ぎました');
        }
       

      
        $schedule =TrainerSchedule::whereDate('date',$request->date)
                                    ->where('time',$request->time)
                                    ->where('trainer_id',$request->trainer_id)
                                    ->where('status',NULL)
                                    ->get()->first();
                                    // dd($schedule);
        if(!$schedule){
            // dd('her');
            $newSchedule = new TrainerSchedule();
            $newSchedule->date =$request->date;
            $newSchedule->time =$request->time;
            $newSchedule->trainer_id =$request->trainer_id;
            $newSchedule->user_id =Session::get('user.id');
            $newSchedule->is_occupied =1;
            $newSchedule->save();

        }else{
            $schedule->user_id =Session::get('user.id');
            $schedule->is_occupied =1;
            $schedule->save();
        }

        $details=array();
        $details['user_name'] = Session::get('user.name');
        $details['user_email'] = Session::get('user.email');
        $details['date'] = $request->date;
        $details['month'] = Carbon::parse()->format('F');
        $details['day'] =  Carbon::parse()->format('D');
        $details['time'] = $request->time;
        $details['address'] = route('traineeCalendar.view');
        $details['trainer_name'] = $tinfo->first_name;
        $details['trainer_email'] = $tinfo->email;
        $details['type'] = Session::get('user_type');
        $details['trainer_name'] =getTrainerName($schedule ? $schedule->id : $request->trainer_id)->first_name;
        $details['user_name'] = Trainee::where('id',$schedule->user_id ? $schedule->user_id : $newSchedule->user_id )->get()->first()->name;

        \Mail::to(Session::get('user.email'))->send(new \App\Mail\Reservation($details));
        \Mail::to($tinfo->email)->send(new \App\Mail\Reservation($details));


        return redirect()->route('traineeCalendar.view')->with('message','レッスンの予約が完了しました。');



    }
    public function quickview(){
        return view('pages.trainee.dummyview');
    }
    public function scheduleCalendar(Request $request){ // calendar view
        // return view('auth.branch');

        // dd($request->all());
        $user_id = Session::get('user.id');
        $user = \App\Model\User::where('id',$user_id)->get()->first();
        // branch page 
        if($user->dob == null || $user->weight == null ||  $user->sex == null ||  $user->pal == null){
            return view('auth.branch');
        }
        //
        $puchasePlan = UserPlanPurchase::where('user_id',Session::get('user.id'))->get()->first();
        
        if(!$puchasePlan){
            return redirect()->route('purchaseplan')->with('message','はじめにレッスンを購入してください。');
        }
        
        $datePlan = Carbon::parse(date('Y-m-d',strtotime($puchasePlan->created_at)));
        $now = Carbon::parse(date('Y-m-d'));

        $allTraingingArray = \Config::get('statics.'.$puchasePlan->purchase_plan_id.'day_per_week');
        $startDay = Carbon::parse(date('Y-m-d',strtotime($puchasePlan->created_at)));
        $endDay = Carbon::parse(date('Y-m-d',strtotime($puchasePlan->created_at)))->addDays(90)->format('Y-m-d');;

        $count=0;
        $parsedArray = array();

  
        $isActive = "schedule";
        if($request->trainer_id){

            $schedule =TrainerSchedule::where('trainer_id',$request->trainer_id)->where('status',NULL)->get();
            $recurring =TrainerRecurringSchedule::where('trainer_id',$request->trainer_id)
                    ->where('status',NULL)
                    ->get();

                if($schedule){
                    foreach ($schedule as $key => $value) {

                        $parsedArray[$count]['id'] = "normal_".$value->id;
                        $parsedArray[$count]['start'] = $value->date;
                        $parsedArray[$count]['allDay'] = true;
                        $parsedArray[$count]['display'] = 'background';
                        $parsedArray[$count]['extendedProps']=array(
                                    'type' => 'normal'
                                );
                   

                        $now = Carbon::parse($value->date);

                        $diff = $datePlan->diffInDays($now);

                    
                            if($value->user_id == Session::get('user')->id){
                                $parsedArray[$count]['color'] = 'red';

                            }else{
                                $parsedArray[$count]['color'] = 'blue';

                            }
                        $count++;
                    }
                }

                if($recurring){

                    foreach($recurring as $key=>$value){
                        // dd($value->dow);
                        // $found=$this->filter_array_value(Carbon::parse($value->time)->format('H:i:s'),$compareArray);
                            // $parsedArray[$count]['start'] = $value->date;
                        // $parsedArray[$count]['title']=Carbon::parse($value->time)->format('g:i A')." - ".Carbon::parse($value->time)->addMinutes(60)->format('g:i A');
                        $parsedArray[$count]['id']="recurring_".$value->id;
                        $parsedArray[$count]['daysOfWeek']=array($value->dow);
                        // $parsedArray[$count]['startTime']=Carbon::parse($value->time)->format('H:i:s');
                        // $parsedArray[$count]['endTime']=Carbon::parse($value->time)->addMinutes(60)->format('H:i:s');
                        // $parsedArray[$count]['exclude']=$value->exclude;
                        $parsedArray[$count]['startRecur']=date('Y-m-d',strtotime($puchasePlan->created_at));
                        $parsedArray[$count]['endRecur']=$endDay;

                        $parsedArray[$count]['allDay'] = true;


                        $parsedArray[$count]['extendedProps']=array(
                            'type' => 'recurring',
                            'startTime' => Carbon::parse($value->time)->format('H:i:s'),
                            'exdate' => $value->exclude

                        );
                        if($request->type == 'week' || $request->type == 'week_all'){
                            // $parsedArray[$count]['display'] = 'background';
                        } 
                            
                        $parsedArray[$count]['className'] = 'recurring';
                        $parsedArray[$count]['color'] = 'blue';
                        $parsedArray[$count]['type'] = 'recurring';
                        $parsedArray[$count]['time'] = Carbon::parse($value->time)->format('H:i:s');
                        $parsedArray[$count]['display'] = 'background';
                        $count++;

                        
                    }
                 }


        }else{

              $schedule =TrainerSchedule::where('user_id',Session::get('user')->id)
              ->where('status',NULL)
              ->get();
                if($schedule){
                    foreach ($schedule as $key => $value) {
                    $parsedArray[$count]['start'] = $value->date;
                    $parsedArray[$count]['allDay'] = true;
                    $parsedArray[$count]['display'] = 'background';
                    $parsedArray[$count]['color'] = 'red';
                    $parsedArray[$count]['extendedProps']=array(
                            'type' => 'occupied',
                            'trainer_id' =>   $value->trainer_id,
                            'schedule_id' =>  $value->id,
                            'is_occupied' =>  $value->is_occupied,
                            'startTime' => Carbon::parse($value->time)->format('H:i:s'),
                            'endTime' => Carbon::parse($value->time)->addMinutes(60)->format('H:i:s'),
                        );
                    $count++;
                    }
                }
        }
        
        
        // dd($startDay);
        // for($i=1;$i<=90;$i++){
        //     $day=$startDay->addDays(1)->format('Y-m-d');
        //     if (!in_array($i, $allTraingingArray)) {
        //         $parsedArray[$count]['color'] = 'grey';
        //         $parsedArray[$count]['start'] = $day;
        //         $parsedArray[$count]['allDay'] = true;
        //         $parsedArray[$count]['display'] = 'background';
        //          $parsedArray[$count]['extendedProps']=array(
        //                     'type' => 'disabled'
        //                 );
        //         $count++;
        //     }
        // }
        $listSchedule =TrainerSchedule::where('user_id',Session::get('user')->id)->orderBy('date','DESC')->get();
        $trainingDay= \Config::get('statics.'.$puchasePlan->purchase_plan_id.'day_per_week');
        
        return view('pages.trainee.calendar')
        // ->with('datePlan',$datePlan)
        // ->with('trainingDay',json_encode($trainingDay))
        ->with('isActive',$isActive)
        ->with('schedule',json_encode($parsedArray,true))
        ->with('listSchedule',$listSchedule);
    
    }

    public function scheduleCalendarSubmit(Request $request){ // when calendar date submit
        $checkPenalty = "";

        // date selection conditions //
        // date selection conditions //
        // date selection conditions //
        $isToday=Carbon::parse($request->selected_date)->isToday();
        $isPast=Carbon::parse($request->selected_date)->isPast();
       
        if(!$isToday && $isPast){
            return redirect()->back()
            ->with('errors_m','過去の日付は選択できません。');
        }

        $rval = $this->checkReservation($request->selected_date,Session::get('user.id'));
       
        if($rval == 'past_future'){
               return redirect()->back()
                    ->with('errors_m','選択されえ日付はプランの購入日~終了日の範囲外です。');
        }

        // end date selection conditions //
        // end date selection conditions //

        $puchasePlan = UserPlanPurchase::where('user_id',Session::get('user.id'))->get()->first();
        
        if(!$puchasePlan){
            return redirect()->route('purchaseplan')->with('message','はじめにプランを購入してください。');
        }

        $date = Carbon::parse(date('Y-m-d', strtotime($puchasePlan->created_at)));
        $now = Carbon::parse($request->selected_date);

        $diff = $date->diffInDays($now);

        // dd($diff);
        // $allTraingingArray = \Config::get('statics.'.$puchasePlan->purchase_plan_id.'day_per_week');
        // if (!in_array($diff, $allTraingingArray)) {
        //     return redirect()->back()->with('errors_m','Your purchase plan does not support this day as a training day. ');
        // }
        $parsedArray=array();
        $count = 0;

        if($request->event_type== null){ // when date is clicked first rather then select the trainer
            
            $schedule =TrainerSchedule::whereDate('date',$request->selected_date)
                    ->where('status',NULL)
                    ->get();

            if($schedule){
                foreach ($schedule as $key => $value) {

                        $y=Carbon::parse($value->date)->format('Y-m-d');
                        $t=Carbon::parse($value->time)->format('H:i:s');
                        $tt = Carbon::parse($value->time)->addMinutes(60)->format('H:i:s');

                        $title=Carbon::parse($value->time)->format('H:i')." - ".Carbon::parse($value->time)->addMinutes(60)->format('H:i');
                        // $parsedArray[$count]['title'] = $title;
                        $parsedArray[$count]['id'] = $value->id;
                        $parsedArray[$count]['is_occupied'] = $value->is_occupied;
                        $parsedArray[$count]['date_data'] = Carbon::parse($value->date)->format('Y-m-d');

                        // $parsedArray[$count]['time'] = $title;
                        $parsedArray[$count]['start'] = Carbon::parse($value->date)->format('Y-m-d')."T".$t;
                        $parsedArray[$count]['end'] = Carbon::parse($value->date)->format('Y-m-d')."T".$tt;
                        $parsedArray[$count]['extendedProps']=array(
                            'type' => 'normal',
                            'trainer_id' =>  $value->trainer_id,
                            'schedule_id' =>  $value->id,
                            'is_occupied' =>  $value->is_occupied,
                            'startTime' => Carbon::parse($value->time)->format('H:i:s'),
                            'endTime' => Carbon::parse($value->time)->addMinutes(60)->format('H:i:s'),
                        );
                        $parsedArray[$count]['type'] = 'normal';

                        if($value->is_occupied === 1){
                             $parsedArray[$count]['className'] = 'tred';

                        }else{
                             $parsedArray[$count]['className'] = 'tblue';

                        }
                    
                    $count++;
                }
            }

                // $trainerArray = array_unique(array_merge($trainerList1,$trainerList2),SORT_REGULAR);
            $recurring =TrainerRecurringSchedule::where('dow',Carbon::parse($request->selected_date)->dayOfWeek)
                        ->get();
                                    // dd($recurring);

            if($recurring){
                foreach($recurring as $key=>$value){

                        $fnd=TrainerSchedule::whereDate('date',$request->selected_date)
                        ->where('time',Carbon::parse($value->time)->format('H:i:s'))
                        ->get()->first();

                        if(!$fnd){
                            $parsedArray[$count]['id']=$value->id;
                            $parsedArray[$count]['exclude']=$value->exclude;
                            
                            $parsedArray[$count]['date_data'] = Carbon::parse($request->selected_date)->format('Y-m-d');
                            $parsedArray[$count]['start'] = Carbon::parse($request->selected_date)->format('Y-m-d')."T".Carbon::parse($value->time)->format('H:i:s');
                            $parsedArray[$count]['end'] =Carbon::parse($request->selected_date)->format('Y-m-d')."T".Carbon::parse($value->time)->addMinutes(60)->format('H:i:s');
                            

                           
                            $parsedArray[$count]['extendedProps']=array(
                                'type' => $fnd ? 'normal' :'recurring',
                                'trainer_id' => $value->trainer_id,
                                'startTime' => Carbon::parse($value->time)->format('H:i:s'),
                                'exdate' => $value->exclude,
                                'schedule_id' => $value->id,
                                'is_occupied' => $fnd ? 1 : 0,
                                'endTime' => Carbon::parse($value->time)->addMinutes(60)->format('H:i:s'),

                            );
                            if($fnd){
                                $parsedArray[$count]['className'] = 'tred';

                            }else{
                                $parsedArray[$count]['className'] = 'tblue';

                            }
                            $count++;
                        }
                        
                    
                }

            }


            // dd($parsedArray);
            return view('pages.trainee.trainer_new_time')
            ->with('schedule',json_encode($parsedArray,true))
            ->with('event_type',$request->event_type)
            ->with('selected_date',$request->selected_date);

        }
        if($request->event_type=='occupied'){
            
            $penalty =$this->checkPenalty($request->selected_date,Session::get('user.id'));
            if($penalty){
                $checkPenalty = "found";
            }else{
                $checkPenalty = "not found";
            }
            $schedule =TrainerSchedule::whereDate('date',$request->selected_date)
                    ->where('user_id',Session::get('user.id'))
                    ->where('status',NULL)
                    ->get();
            if($schedule){
                foreach ($schedule as $key => $value) {


        
                    $y=Carbon::parse($value->date)->format('Y-m-d');
                    $t=Carbon::parse($value->time)->format('H:i:s');
                    $tt = Carbon::parse($value->time)->addMinutes(60)->format('H:i:s');

                    $title=Carbon::parse($value->time)->format('H:i')." - ".Carbon::parse($value->time)->addMinutes(60)->format('H:i');
                    // $parsedArray[$count]['title'] = $title;
                    $parsedArray[$count]['id'] = $value->id;
                    $parsedArray[$count]['is_occupied'] = $value->is_occupied;
                    $parsedArray[$count]['date_data'] = Carbon::parse($value->date)->format('Y-m-d');

                    // $parsedArray[$count]['time'] = $title;
                    $parsedArray[$count]['start'] = Carbon::parse($value->date)->format('Y-m-d')."T".$t;
                    $parsedArray[$count]['end'] = Carbon::parse($value->date)->format('Y-m-d')."T".$tt;
                    $parsedArray[$count]['extendedProps']=array(
                        'type' => 'normal',
                        'trainer_id' => $value->trainer_id,
                        'schedule_id' =>  $value->id,
                        'is_occupied' =>  $value->is_occupied,
                        'startTime' => Carbon::parse($value->time)->format('H:i:s'),
                        'endTime' => Carbon::parse($value->time)->addMinutes(60)->format('H:i:s'),
                    );
                    $parsedArray[$count]['type'] = 'normal';

                    if($value->is_occupied === 1){
                         $parsedArray[$count]['className'] = 'tred';

                    }else{
                         $parsedArray[$count]['className'] = 'tblue';

                    }
                       

                    $count++;
                }
            }
        }
        if($request->event_type=='normal'){
             if($rval == 'count_exceed'){
                return redirect()->back()
                ->with('errors_m','プラン制限を超えました');
            }
            $schedule =TrainerSchedule::whereDate('date',$request->selected_date)
                    ->where('trainer_id',$request->trainer_id)
                    ->where('status',NULL)
                    ->get();
            if($schedule){
                foreach ($schedule as $key => $value) {


                //         "title": "12.06 am - 1.06 am",
                // "start": "2021-01-25T00:30:00",
                // "end": "2021-01-25T01:30:00",
                //   'className' : 'tblue',
                //   'textColor' : '#ffffff'

                        $y=Carbon::parse($value->date)->format('Y-m-d');
                        $t=Carbon::parse($value->time)->format('H:i:s');
                        $tt = Carbon::parse($value->time)->addMinutes(60)->format('H:i:s');

                        $title=Carbon::parse($value->time)->format('H:i')." - ".Carbon::parse($value->time)->addMinutes(60)->format('H:i');
                        // $parsedArray[$count]['title'] = $title;
                        $parsedArray[$count]['id'] = $value->id;
                        $parsedArray[$count]['is_occupied'] = $value->is_occupied;
                        $parsedArray[$count]['date_data'] = Carbon::parse($value->date)->format('Y-m-d');

                        // $parsedArray[$count]['time'] = $title;
                        $parsedArray[$count]['start'] = Carbon::parse($value->date)->format('Y-m-d')."T".$t;
                        $parsedArray[$count]['end'] = Carbon::parse($value->date)->format('Y-m-d')."T".$tt;
                        $parsedArray[$count]['extendedProps']=array(
                            'type' => 'normal',
                            'trainer_id' => $request->trainer_id,
                            'schedule_id' =>  $value->id,
                            'is_occupied' =>  $value->is_occupied,
                            'startTime' => Carbon::parse($value->time)->format('H:i:s'),
                            'endTime' => Carbon::parse($value->time)->addMinutes(60)->format('H:i:s'),
                        );
                        $parsedArray[$count]['type'] = 'normal';

                        if($value->is_occupied === 1){
                             $parsedArray[$count]['className'] = 'tred';

                        }else{
                             $parsedArray[$count]['className'] = 'tblue';

                        }
                        // $parsedArray[$count]['display'] = 'background';

                        // if($value->is_occupied === 1){

                        // }else{
                        //     if($request->type == 'week' || $request->type == 'week_all'){
                        //         $parsedArray[$count]['display'] = 'background';
                        //     }
                            
                        // }

                    $count++;
                }
            }
        }
        
        if($request->event_type=='recurring'){
            // $request->selected_date
            // $schedule =TrainerSchedule::where('date',$request->selected_date)
            //         ->where('trainer_id',$request->trainer_id)
            //         ->where('status',NULL)
            //         ->get();

            $recurring =TrainerRecurringSchedule::where('trainer_id',$request->trainer_id)
            ->where('dow',Carbon::parse($request->selected_date)->dayOfWeek)
            ->get();
            // dd($recurring);
            if($recurring){
                // dd(Carbon::parse("2021-2-24")->dayOfWeek);
            foreach($recurring as $key=>$value){
                // dd($value->dow);
                // $found=$this->filter_array_value(Carbon::parse($value->time)->format('H:i:s'),$compareArray);
                    
                    $fnd=TrainerSchedule::whereDate('date',$request->selected_date)
                    ->where('trainer_id',$request->trainer_id)
                    ->where('time',Carbon::parse($value->time)->format('H:i:s'))
                    ->get()->first();

                    // dd(Carbon::parse($value->time)->format('H:i:s'));
                    $parsedArray[$count]['id']=$value->id;
                    // $parsedArray[$count]['daysOfWeek']= Carbon::parse($request->selected_date)->dayOfWeek;
                    // $parsedArray[$count]['startTime']=Carbon::parse($value->time)->format('H:i:s');
                    // $parsedArray[$count]['endTime']=Carbon::parse($value->time)->addMinutes(60)->format('H:i:s');
                    $parsedArray[$count]['exclude']=$value->exclude;
                    
                    $parsedArray[$count]['date_data'] = Carbon::parse($request->selected_date)->format('Y-m-d');

                    // $parsedArray[$count]['time'] = $title;
                    $parsedArray[$count]['start'] = Carbon::parse($request->selected_date)->format('Y-m-d')."T".Carbon::parse($value->time)->format('H:i:s');
                    $parsedArray[$count]['end'] =Carbon::parse($request->selected_date)->format('Y-m-d')."T".Carbon::parse($value->time)->addMinutes(60)->format('H:i:s');
                    

                   
                    $parsedArray[$count]['extendedProps']=array(
                        'type' => $fnd ? 'normal' :'recurring',
                        'trainer_id' => $request->trainer_id,
                        'startTime' => Carbon::parse($value->time)->format('H:i:s'),
                        'exdate' => $value->exclude,
                        'schedule_id' => $value->id,
                        'is_occupied' => $fnd ? 1 : 0,
                        'endTime' => Carbon::parse($value->time)->addMinutes(60)->format('H:i:s'),

                    );
                    if($fnd){
                        $parsedArray[$count]['className'] = 'tred';

                    }else{
                        $parsedArray[$count]['className'] = 'tblue';

                    }
                    // $parsedArray[$count]['className'] = 'tblue';

                    // $parsedArray[$count]['type'] = 'recurring';
                    // $parsedArray[$count]['time'] = Carbon::parse($value->time)->format('H:i:s');
                    // $parsedArray[$count]['display'] = 'background';
                    $count++;
                
            }
         }
        }
            // dd($parsedArray);



        // if($request->trainer_id){
        //     $time =TrainerSchedule::where('date',$request->selected_date)->where('trainer_id',$request->trainer_id)->get();
        // }else{

        //     $time =TrainerSchedule::where('date',$request->selected_date)->where('user_id',Session::get('user.id'))->get();

        //     if(count($time) == 0){

        //         $trainerId = TrainerSchedule::where('date',$request->selected_date)->select('trainer_id')->groupBy('trainer_id')->get();

        //         $trainerList = array();
        //         if(($trainerId)){
        //             foreach($trainerId as $key=>$val){
        //                 $trainerList[$key] = Trainer::find($val->trainer_id);
        //             }
        //         }
        //         // dd($trainerList);
        //         return view('pages.trainee.trainerlist')->with('trainerList',$trainerList);
        //     }
        // }
        
        // dd($parsedArray);
        return view('pages.trainee.new_time')
        ->with('checkPenalty',$checkPenalty)
                ->with('schedule',json_encode($parsedArray,true))
                ->with('event_type',$request->event_type)
                ->with('trainer_id',$request->trainer_id)
        ->with('selected_date',$request->selected_date);
    }
    public function trainerlistviatime(Request $request){

        $trainerList1= TrainerSchedule::whereDate('date',$request->selected_date)
                            ->where('time',$request->start_time)
                            ->where('status',NULL)
                    ->select(['trainer_id as id'])->groupBy('trainer_id')
                    ->get()->toArray();
        $trainerList2= TrainerRecurringSchedule::where('dow',Carbon::parse($request->selected_date)->dayOfWeek)
                        ->where('time',$request->start_time)
                    ->groupBy('trainer_id')
                    ->select(['trainer_id as id'])
                    ->get()->toArray();

        $trainerArray = array_unique(array_merge($trainerList1,$trainerList2),SORT_REGULAR);

        // dd($trainerArray);
        $trainerList = Trainer::whereIn('id',$trainerArray)->get();
        return view('pages.trainee.traineelist_bytime')
        ->with('date',$request->selected_date)
        ->with('time',$request->start_time)
        ->with('trainerList',$trainerList);
    }
    
    // public function scheduleTime(Request $request){

    //  $time =TrainerSchedule::where('date',$request->selected_date)->get();
    //  return view('pages.trainee.time')
    //     ->with('selected_date',$request->selected_date)
    //  ->with('time',$time);

    // }

    public function scheduleSubmit(Request $request){
    
        if(checkPastDate($request->db_date)){
            return redirect()->route('traineeCalendar.view')
            ->with('errors_m','The schedule date has been passed');
        }
        if(checkPastTIme(Carbon::parse($request->start_time)->format('H:i:s'),$request->db_date)){
                return redirect()->route('traineeCalendar.view')
                 ->with('errors_m','The schedule time has been passed');
        }

        if($request->type == 'reschedule'){

            if(checkLimitValidation($request->db_start_time,$request->db_date)){
                return redirect()->route('traineeCalendar.view')
                ->with('errors_m','You will not able to modify the schedule, because the cacncelation time limit exceed');
            }

            $pval = $this->checkPenalty($request->db_date,Session::get('user.id'));
            
            if($pval){
                return redirect()->route('traineeCalendar.view')
                ->with('errors_m','In this week you got a penalty and you will not able to reschedule this week');
            }

            $time = Carbon::parse($request->start_time)->format('H:i:s');
            $existingTime = Carbon::parse($request->db_start_time)->format('H:i:s');


            if($time == $existingTime){
                return redirect()->route('traineeCalendar.view')
                ->with('message','Your rescheduled time is same as previous one !');
            }
            $id = $request->db_schedule_id;
            $found=TrainerSchedule::whereDate('date',$request->db_date)
                            ->where('status',NULL)
                            ->where('time',Carbon::parse($request->start_time)->format('H:i:s'))
                            ->where('trainer_id',$request->trainer_id)
                            ->get()->first();
            if($found){

                return redirect()->route('traineeCalendar.view')
                ->with('errors_m','Time slot is not avaliable for '.$request->start_time);
            
            }else{
                $scheduleU = TrainerSchedule::where('id',$request->db_schedule_id)
                ->get()->first();
                if($scheduleU){
                    $scheduleU->status ='rescheduled';
                    $scheduleU->save();
                }
                

                $scheduleU = new TrainerSchedule();
                $scheduleU->date =$request->db_date;
                $scheduleU->trainer_id =$request->trainer_id;
                $scheduleU->is_occupied =1;
                $scheduleU->user_id =Session::get('user.id');
                $scheduleU->time =Carbon::parse($request->start_time)->format('H:i:s');
                $scheduleU->save();

                 return redirect()->route('traineeCalendar.view')
                ->with('message','時間の更新を正常にスケジュールする');
            }
            
        }
        if($request->type == 'cancel'){

            // dd($request->all());
            $time = Carbon::parse($request->start_time)->format('H:i:s');
           if(checkLimitValidation($time,$request->db_date)){
                $scheduleU = TrainerSchedule::where('id',$request->db_schedule_id)
                            ->get()
                            ->first();
                if($scheduleU){
                    $scheduleU->status ='cancelled_penalty';
                    $scheduleU->save();
                }
                return redirect()->route('traineeCalendar.view')
                ->with('errors_m','You got a penalty, as you have cancelled the schedule after camcelation limit time is over');
            }

            // ---------------------------------------------------
            // ---------------------------------------------------

            $scheduleU = TrainerSchedule::where('id',$request->db_schedule_id)
                        ->get()
                        ->first();
            if($scheduleU){
                $scheduleU->status ='cancelled';
                $scheduleU->save();
            }
            $scheduleU = new TrainerSchedule();
            $scheduleU->date =$request->db_date;
            $scheduleU->trainer_id =$request->trainer_id;
            $scheduleU->time =Carbon::parse($request->start_time)->format('H:i:s');
            $scheduleU->save();

            return redirect()->route('traineeCalendar.view')
            ->with('message','キャンセルを正常にスケジュールする');
          
        }
        // end *******


        // booked a aschedule //
        if($request->event_type == 'recurring'){
            $schedule = new TrainerSchedule();
            $schedule->user_id=$request->user_id;
            $schedule->date=$request->selected_date;
            $schedule->trainer_id=$request->trainer_id;
            $schedule->time=$request->start_time;
            $schedule->is_occupied=1;
            $schedule->save();
            return response()->json(['success'=>true]);
        }
        if($request->event_type == 'normal'){

            if($request->schedule_id){
                $schedule = TrainerSchedule::find($request->schedule_id);
                $schedule->user_id=$request->user_id;
                $schedule->is_occupied=1;
                $schedule->save();
            }

            return response()->json(['success'=>true]);

        }

    }

    public function trainerlist(){
        $trainerList = Trainer::get();
        return view('pages.trainee.trainerlist')->with('trainerList',$trainerList);
    }

    public function logout(){
        session()->flush();
        return redirect()->route('traineeLogin');
    }
    public function purchaseplan(Request $request){

        // calculation test //
        $user_id = Session::get('user.id');
        $user = \App\Model\User::where('id',$user_id)->get()->first();

        if($user->phone === null || $user->address === null){
            return redirect()->route('traininginfo')->with('success','最初にトレーニングを入力してください');
        }

        if($user->dob == null || $user->weight == null ||  $user->sex == null ||  $user->pal == null){
            return redirect()->route('physicaldata')->with('success','最初に物理情報を入力してください');

            // return view('auth.branch');
        }

        $bmrData = BMRcalculation($user->weight);
       
        // dd($bmrData);
        $weight = $user->weight;

        $totalDay=90;
        $start=1;
        $pal=$user->pal;
        $type=1;
        $dataset = $this->calculation($bmrData*$pal,$weight,$pal,$totalDay,$start,$type);
            // dd($dataset);
        $userPurchasePlan=UserPlanPurchase::where('status',1)->where('user_id',Session::get('user.id'))->orderBy('id','ASC')->first();
        $isactive='purchase';
        $purchase=PlanPurchase::where('status',1)->get();
        $plan=PlanPurchase::where('id',1)->get()->first();
        $purchasePlaneList=UserPlanPurchase::where('user_id',Session::get('user.id'))->get();

        return view('pages.trainee.purchase_details')
        ->with('dataset',$dataset)
        ->with('purchase',$purchase)
        ->with('plan',$plan)
        ->with('isActive',$isactive)
        ->with('userPurchasePlan',$userPurchasePlan)
        ->with('bmrData',$bmrData)
        ->with('purchasePlaneList',$purchasePlaneList)
        ->with('user',$user);

    }
    public function number_formate($data){
            return number_format((float)$data, 2, '.', '');  // Outputs -> 105.00
    }

    // purchase calculation and ajax call
    // purchase calculation and ajax call
    public function purchaseajaxcall(Request $request){
        $bmrData=$request->bmrData;
        $totalDay=$request->totalday;
        $start=$request->startday;
        $pal=$request->pal;
        $type=1;
        $weight=$request->weight;
        return  $this->calculation($bmrData,$weight,$pal,$totalDay,$start,$type);
    }
    public function calculation($bmrData,$weight,$pal,$totalDay,$start,$type){

        $bmrData=$bmrData;
        $totalDay=$totalDay;
        $start=$start;
        $pal=$pal;
        $type=$type;
        

        $this->repeatedFunction($bmrData,$weight,$pal,$totalDay,'1day_per_week',$start,$counter=0,$type);
        $this->repeatedFunction($bmrData,$weight,$pal,$totalDay,'2day_per_week',$start,$counter=0,$type);
        $this->repeatedFunction($bmrData,$weight,$pal,$totalDay,'3day_per_week',$start,$counter=0,$type);
        $weightData = $this->RECURSIVE;
        // dd($weightData);
        $dataset=array();

        // for graph in purchae plan
        $dataset[0]=array(
                    'data' => array($weight,
                                    $this->number_formate($weightData['1day_per_week'][29]['weight']),
                                    $this->number_formate($weightData['1day_per_week'][59]['weight']),
                                    $this->number_formate($weightData['1day_per_week'][89]['weight'])
                                ),
                        'label'=> "1 day per week",
                        'borderColor'=> "#6d93ff",
                        'fill'=> false
                    );

        $dataset[1]=array(
                        'data' => array($weight,
                                    $this->number_formate($weightData['2day_per_week'][29]['weight']),
                                    $this->number_formate($weightData['2day_per_week'][59]['weight']),
                                    $this->number_formate($weightData['2day_per_week'][89]['weight'])
                                ),
                        'label'=> "2 day per week",
                        'borderColor'=> "green",
                        'fill'=> false
                    );

        $dataset[2]=array(
                        'data' => array($weight,
                                    $this->number_formate($weightData['3day_per_week'][29]['weight']),
                                    $this->number_formate($weightData['3day_per_week'][59]['weight']),
                                    $this->number_formate($weightData['3day_per_week'][89]['weight'])
                                ),
                        'label'=> "3 day per week",
                        'borderColor'=> "yellow",
                        'fill'=> false
                    );
            return json_encode($dataset,true);


    }

    public function repeatedFunction($bmrData,$weight,$pal,$totalday,$trainingType,$start,$counter,$type){

    
        if ($totalday === 0){
            return $this->RECURSIVE;
        }else{

            $weightBalance = weight_balance($bmrData,$pal,$weight,$start,$trainingType);
            $weight = $weight+$type*$weightBalance;
            $this->RECURSIVE[$trainingType][$counter]['plan_type']=$trainingType;
            $this->RECURSIVE[$trainingType][$counter]['weight']=$weight;
            $this->RECURSIVE[$trainingType][$counter]['weightBalance']=$weightBalance;
            $this->RECURSIVE[$trainingType][$counter]['bmr']=$bmrData;
            $this->RECURSIVE[$trainingType][$counter]['pal']=$pal;
        }   
        $this->counter++;
        $this->repeatedFunction($bmrData,$weight,$pal,($totalday-1),$trainingType,$start+1,$counter+1,$type); 
    }


    // public function dayKg($weight,$pal){

        // $rt = $this->repeatedFunction($weight,$pal,13);
        // return $rt;
        // dd($this->RECURSIVE);

        // $returnArray=array();

        // for($i=1;$i<30;$i++){
        //     $returnArray[$i] = $this->repeatedFunction($weight,$pal);
        // }

        // dd($returnArray);
        // $factor=1;
        // $monthCounter=1;
        // for($i=0;$i<3;$i++){
        //     $returnArray[$i]['label']='';
        //     $returnArray[$i]['borderColor']='#6d93ff';
        //     $returnArray[$i]['fill']=false;

        //     for($j=0;$j<=3;$j++){
                
        //         if($j==0){
        //             $returnArray[$i]['data'][$j]=$weight;
        //         }else{

        //             $returnArray[$i]['data'][$j]=($weight+($weightBalance*30*$j*$factor));
        //             $monthCounter++;
        //         }
        //     }
        //     $factor++;

        //     // $weight 
        //     // $weight 
        //     // $weight 

        //     // $weight + $weightBalance*30*1;
        //     // $weight + $weightBalance*60*1;
        //     // $weight + $weightBalance*90*1;

        //     // $weight + $weightBalance*30*2;
        //     // $weight + $weightBalance*60*2;
        //     // $weight + $weightBalance*90*2;

        //     // $weight + $weightBalance*30*3;
        //     // $weight + $weightBalance*60*3;
        //     // $weight + $weightBalance*90*3;
        // }
        // return ($returnArray);
        // // one times a week 
        // $oneMonth = ($weight + (30*$weightBalance)) * 1;
        // $twoMonth = ($weight + (2*30*$weightBalance)) * 1;
        // $threeMonth = ($weight + (3*30*$weightBalance)) * 1;

        // // two times a week
        // $oneMonth = ($weight + (30*$weightBalance)) * 2;
        // $twoMonth = ($weight + (2*30*$weightBalance)) * 2;
        // $threeMonth = ($weight + (3*30*$weightBalance)) * 2;
        // // three times a week
        // $oneMonth = ($weight + (30*$weightBalance)) * 3;
        // $twoMonth = ($weight + (2*30*$weightBalance)) * 3;
        // $threeMonth = ($weight + (3*30*$weightBalance)) * 3;

    //     [
    //   { 
    //     data: [70,68,60,50],
    //     label: "",
    //     borderColor: "#6d93ff",
    //     fill: false
    //   }, 
    //   { 
    //     data: [70,67,59,55],
    //     label: "",
    //     borderColor: "green",
    //     fill: false
    //   },
    //   { 
    //     data: [70,60,55,50],
    //     label: "",
    //     borderColor: "yellow",
    //     fill: false
    //   }, 
    
    // ]

    public function purchasedetails(Request $request){
        $userPurchasePlan=UserPlanPurchase::where('user_id',Session::get('user.id'))->first();
        $isactive='purchase';
        $purchase=PlanPurchase::where('status',1)->get();
        $plan=PlanPurchase::where('id',$request->id)->get()->first();
        return view('pages.trainee.purchase_details')->with('purchase',$purchase)->with('plan',$plan)->with('isActive',$isactive)->with('userPurchasePlan',$userPurchasePlan);

    }
    public function psettings(Request $request){

        $user = Trainee::where('id',Session::get('user.id'))->first();

        return view('pages.trainee.p-settings')
        ->with('user',$user)
        ->with('equipment',Equipment::get())->with('isActive','p-settings');

    }
    public function psettingsSubmit(Request $request){



        if($request->action_type == 'password_update'){

        $validateData = $request->validate([

            // 'name' => 'required',
            // 'email' => 'unique:users,email,'.$request->user_id,
            'password' => 'required|confirmed|min:6',
            // 'weight' => 'required',
            // 'fat' => 'required',
        ]);

            $trainee = Trainee::find($request->user_id);
            if( (!Hash::check($request->input('oldpassword'),$trainee->password))){
                return redirect()->back()->with('message','過去のパスワードが一致しません。');
            }

            $trainee->password = Hash::make($request->input('password'));

            $trainee->save();
            return redirect()->back()
            ->with('success','パスワードが更新されました');
        }
        if($request->action_type == 'info_update'){

                 $validateData = $request->validate([

            'name' => 'required',
            'birthday' => 'required',
            'email1' => 'unique:tbl_users,email,'.$request->user_id,
            // 'password' => 'required|confirmed|min:6',
            'weight' => 'required',
            // 'fat' => 'required',
            'phone' => 'numeric'

        ]);

            $trainee = Trainee::find($request->user_id);
            $trainee->name = $request->input('name');

            $trainee->sex = $request->input('sex');
            $trainee->dob = date('m/d/Y', strtotime($request->input('birthday')));
            $trainee->length = $request->input('height');
            $trainee->weight = $request->input('weight');
            $trainee->email = $request->input('email1');

            $trainee->phonetic = $request->input('phonetic');
            $trainee->address = $request->input('address');
            $trainee->phone = $request->input('phone');

            if($trainee->save()){
                //  EVENT TRIGGERED
                // event(new NewUserRegisteredEvent($trainee,'trainee'));
                // NOW SAVE DATA TO TBL_USER_HISTORY TABLE

                

                // NOW SAVE DATA TO TBLE_USER_EQUIPMENT TABLE
                        if($request->equipment){
                $arr = $request->equipment;
                foreach($arr as $val){
                    if($val['is_available'] == 1){

                       $dataExist= UserEquipment::where('user_id',$trainee->id)
                            ->where('equipment_id',$val['id'])->get()->first();

                        if(!$dataExist){
                            $equipment = new UserEquipment();
                            $equipment->user_id = $trainee->id;
                            $equipment->equipment_id = $val['id'];
                            // $equipment->is_available = $val['is_available'];
                            $equipment->save();
                        }    
                        
                    }else{

                        $dataExist= UserEquipment::where('user_id',$trainee->id)
                            ->where('equipment_id',$val['id'])->delete();
                    }
                    
                }
            }
            }
            return redirect()->back()
            ->with('success','Profile update succesfully');
        }
        

    }
    public function traininginfo(Request $request){
            $user = Trainee::find(Session::get('user.id'));
            $equipment = Equipment::get();
          
            $userEquipment = UserEquipment::where('user_id',$user->id)->get();
            return view('auth.traininginfo')->with('user',$user)->with('equipment',$equipment)->with('userEquipment',$userEquipment);
    }
    public function traininginfosubmit(Request $request){
        $validateData = $request->validate([

            'phone' => 'required',
            'address' => 'required',
          
        ]);

        $date= new DateTime();
        $trainee = Trainee::find($request->user_id);

        $trainee->address = $request->input('address');
        $trainee->phone = $request->input('phone');

        if($trainee->save()){
             // NOW SAVE DATA TO TBLE_USER_EQUIPMENT TABLE
            if($request->equipment){
                $arr = $request->equipment;
                foreach($arr as $val){
                    if($val['is_available'] == 1){

                       $dataExist= UserEquipment::where('user_id',$trainee->id)
                            ->where('equipment_id',$val['id'])->get()->first();

                        if(!$dataExist){
                            $equipment = new UserEquipment();
                            $equipment->user_id = $trainee->id;
                            $equipment->equipment_id = $val['id'];
                            // $equipment->is_available = $val['is_available'];
                            $equipment->save();
                        }    
                        
                    }else{

                        $dataExist= UserEquipment::where('user_id',$trainee->id)
                            ->where('equipment_id',$val['id'])->delete();
                    }
                    
                }
            }
        }
                    return redirect()->route('purchaseplan')->with('success','Training information added successfully');
    }
    
    public function dailydata(Request $request){
         // calculation test //

        $user_id = Session::get('user.id');
        $user = \App\Model\User::where('id',$user_id)->get()->first();
        $isactive='dailydata';

        return view('pages.trainee.daily_data')
        ->with('isActive',$isactive)
        ->with('user',$user);
    }
    public function dailydataSubmit(Request $request){
            $validateData = $request->validate([

                'weight' => 'required',
                'fat' => 'required',
                'calory_gained' => 'required',
                'consumed_calory' => 'required',
            ]);
            $date = date('Y-m-d');

            $timing=$this->morningOrEvening();
            $todayData = UserHistory::whereDate('created_at',$date)->where('user_id',$request->user_id)->get()->first();

            if($todayData){
                 $history = UserHistory::find($todayData->id);
                 $msg = "Data updated succesfully!";

            }else{
                 $history = new UserHistory();
                 $msg = "Data inserted succesfully!";
            }
           

            $history->weight_morning = ($timing== 'morning') ? $request->input('weight') : '' ;
            $history->weight_evening = ($timing== 'evening') ? $request->input('weight') : '' ;

            $history->body_fat_percentage_morning = ($timing== 'morning') ? $request->input('fat') : '' ;
            $history->body_fat_percentage_evening = ($timing== 'evening') ? $request->input('fat') : '' ;

            $history->calory_gained = $request->input('calory_gained');
            $history->calory_consumed = $request->input('consumed_calory');

            $history->recorded_at = date('Y-m-d H:i:s');
            $history->user_id = $request->user_id;
            $history->save();

            return redirect()->back()->with('success',$msg);

    }   

public function progress(){
         // calculation test //
        $user_id = Session::get('user.id');
        $user = \App\Model\User::where('id',$user_id)->get()->first();

        $bmrData = BMRcalculation($user->weight);
        // dd($bmrData);
       
        $weight = $user->weight;

        $totalDay=7;
        $start=1;
        $pal=1.75;
        $type=1;
        $dataset = $this->calculation2($bmrData,$weight,$pal,$totalDay,$start,$type);


        $userPurchasePlan=UserPlanPurchase::where('user_id',Session::get('user.id'))->first();
        $isactive='progress';
        $purchase=PlanPurchase::where('status',1)->get();
        $plan=PlanPurchase::where('id',1)->get()->first();
        return view('pages.trainee.progress')
        ->with('dataset',$dataset)
        ->with('purchase',$purchase)
        ->with('plan',$plan)
        ->with('isActive',$isactive)
        ->with('userPurchasePlan',$userPurchasePlan)
        ->with('bmrData',$bmrData)
        ->with('user',$user);
    }
    // user acheivement calculation and ajax call
    // user acheivement calculation and ajax call

    public function acheivementjaxcall(Request $request){
        $bmrData=$request->bmrData;
        $totalDay=$request->totalday;
        $start=$request->startday;
        $pal=$request->pal;
        $type=$request->type;
        $weight=$request->weight;
        return  $this->calculation($bmrData,$weight,$pal,$totalDay,$start,$type);
    }

    // public function recurringData(){

    // }
    // public function scheduleData(){

    // }
    // public function trainingdayData(){

    // }
   

    

}
