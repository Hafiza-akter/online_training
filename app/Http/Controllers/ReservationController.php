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

use DB;
use DateTime;
use DateInterval;

class ReservationController extends Controller
{
    public $RECURSIVE=array();
    public $counter=0;

    public function index(){
        $isActive = "schedule";
        
        $returnVal = getTrainerList();
        

        return view('pages.trainee.reservation')

        ->with('isActive',$isActive)
        ->with('schedule',json_encode($returnVal,true));
    }

    public function sorting(Request $request){

        // dd($request->sorting);
        $isActive = "schedule";
        // $param = dycryptionValue($request->sorting);
        // dd($param);
        // $sorting = $param['sorting'];
        $sorting=$request->sorting;
        $sorting2=$request->sorting2;

        $returnVal = getSortedTrainerList($sorting,$sorting2);

        return view('pages.trainee.reservation')
            ->with('sorting',$sorting)
            ->with('sorting2',$sorting2)
            ->with('isActive',$isActive)
            ->with('schedule',json_encode($returnVal,true));
    }
    
    
    public function reservationBydate(Request $request){

        $isActive = "schedule";
        $data = getTrainerListByDate($request->date,$request);
        $date=$request->date;
        $sorting=$request->sorting;
        $sorting2=$request->sorting2;

        $returnVal = getSortedTrainerList($sorting,$sorting2);

        return view('pages.trainee.reservationbydate')

            ->with('sorting',$sorting)
            ->with('sorting2',$sorting2)
            ->with('data',$data)
            ->with('schedule',json_encode($returnVal,true))
            ->with('date',$date)
            ->with('isActive',$isActive);

    }
    public function ajaxReservationBydate(Request $request){

       
        $isActive = "schedule";
        dd(Session::get('user.id'));
        $data = getTrainerListByDate($request->selected_date,$request);
        dd($data);
        $date=$request->selected_date;
        
        // dd($data);
        $returnHTML = view('pages.trainee.ajax_time_list')
            ->with('data',$data)
            ->with('date',$date)
            ->with('isActive',$isActive)->render();

        return response()->json(array('success' => true, 'html'=>$returnHTML));

    }
    public function getTime(Request $request){
        $data=getTime($request->trainer_id,$request->date);
        $user_id= $request->user_id;
        $returnHTML = view('pages.ajax.ajax_jitsi_time_list')
            ->with('data',$data)
            ->with('user_id',$user_id)
            ->with('date',$request->date)
            ->render();

        return response()->json(array('success' => true, 'html'=>$returnHTML));
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
        $start = $date->startOfWeek(Carbon::SUNDAY)->toDateString();
        $end = $date->endOfWeek(Carbon::SATURDAY)->toDateString();
        
        $count1 = TrainerSchedule::where('user_id',$user_id)
        ->where('status',NULL)
        ->where('is_occupied',1)
        // ->orwhere('status','cancelled_penalty')
        ->whereBetween('date', [$start." 00:00:00", $end." 00:00:00"])->get()->count();
        
        $count2 = TrainerSchedule::where('user_id',$user_id)
        ->where('is_occupied',1)
        ->where('status','cancelled_penalty')
        ->whereBetween('date', [$start." 00:00:00", $end." 00:00:00"])->get()->count();
     
        $count = $count1 + $count2;
        $purchasePlan = activePurchasePlan($user_id);
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
        $details['month'] = Carbon::parse($request->date)->format('F j');
        $details['day'] =  Carbon::parse($request->date)->format('l');
        $details['time'] = $request->time;
        $details['address'] = route('traineeCalendar.view');
        $details['trainer_name'] = $tinfo->first_name;
        $details['trainer_email'] = $tinfo->email;
        $details['type'] = Session::get('user_type');
        $details['trainer_name'] = Trainer::find($request->trainer_id)->first_name;
        $details['user_name'] = Session::get('user.name');

        \Mail::to(Session::get('user.email'))->send(new \App\Mail\Reservation($details));
        \Mail::to($tinfo->email)->send(new \App\Mail\Reservation($details));


        return redirect()->route('traineeCalendar.view')->with('message','レッスンの予約が完了しました。');



    }
    public function jitsiUserSubmitTime(Request $request){
        
        // dd($request->all());
        $tinfo = Trainer::find($request->trainer_id);
        $userInfo = Trainee::find($request->user_id);
        // dd($tinfo);
        if(checkMultipleScheduleSamedate($request->date,$request->user_id)){
             $returnHTML='<p  class="alert alert-danger">この日にすでに設定されているスケジュール</p>';

            return response()->json(array('success' => false, 'html'=>$returnHTML));
        }
        $rval = $this->checkReservation($request->date,$request->user_id);
        // dd($rval);
        if($rval == 'count_exceed'){

            $returnHTML='<p  class="alert alert-danger"> 
            プラン制限を超えました</p>';

            return response()->json(array('success' => false, 'html'=>$returnHTML));

            
        }
        if($rval == 'past_future'){
            $returnHTML='<p  class="alert alert-danger"> 
            選択した日付がプランの開始日と終了日の間にありません</p>';

            return response()->json(array('success' => false, 'html'=>$returnHTML));

        } 
        if(checkPastTIme($request->time,$request->date)){
             $returnHTML='<p  class="alert alert-danger"> 
            スケジュール時間が過ぎました</p>';

            return response()->json(array('success' => false, 'html'=>$returnHTML));

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
            $newSchedule->user_id =$request->user_id;
            $newSchedule->is_occupied =1;
            $newSchedule->save();

        }else{
            $schedule->user_id =$request->user_id;
            $schedule->is_occupied =1;
            $schedule->save();
        }

        $details=array();
        $details['user_name'] = $userInfo->name;
        $details['user_email'] = $userInfo->email;
        $details['date'] = $request->date;
        $details['month'] = Carbon::parse($request->date)->format('F j');
        $details['day'] =  Carbon::parse($request->date)->format('l');
        $details['time'] = $request->time;
        $details['address'] = route('traineeCalendar.view');
        $details['trainer_name'] = $tinfo->first_name;
        $details['trainer_email'] = $tinfo->email;
        $details['type'] = 'trainee';
        $details['trainer_name'] = Trainer::find($request->trainer_id)->first_name;
        $details['user_name'] = $userInfo->name;;

        \Mail::to($userInfo->email)->send(new \App\Mail\Reservation($details));
        \Mail::to($tinfo->email)->send(new \App\Mail\Reservation($details));

          $returnHTML='<p  class="alert alert-success"> 
            レッスンの予約が完了しました。</p>';

        $y=Carbon::parse($request->date)->format('Y-m-d');
        $t=Carbon::parse($request->time)->format('H:i:s');
        $tt = Carbon::parse($request->time)->addMinutes(60)->format('g:i A');

        $title=Carbon::parse($request->time)->format('H:i')." - ".Carbon::parse($request->time)->addMinutes(60)->format('H:i');
        $event['title'] = $title;
        $event['is_occupied'] = 1;
        $event['date_data'] = Carbon::parse($request->date)->format('Y-m-d');

        $event['time'] = $t;
        $event['start'] = Carbon::parse($request->date)->format('Y-m-d')."T".$t;
        $event['end'] = Carbon::parse($request->date)->format('Y-m-d')."T".$tt;
        $event['extendedProps']=array(
            'type' => 'normal',
            'startTime' =>  $t,
            'date' =>  Carbon::parse($request->date)->format('Y-m-d')
        );
        $event['type'] = 'normal';
        $event['textColor'] = '#ffffff';
        $event['className'] = 'tred';


        return response()->json(array('success' => true, 'event'=>$event,'html'=>$returnHTML));

    }
    
    

}
