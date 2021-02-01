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


use DateTime;
use DateInterval;

class TraineeController extends Controller
{
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
            'fat' => 'required',
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
        $pal = $request->input('pal');
        $weight = $request->input('weight');


        if($trainee->save()){
            //  EVENT TRIGGERED
            // event(new NewUserRegisteredEvent($trainee,'trainee'));
            // NOW SAVE DATA TO TBL_USER_HISTORY TABLE
            if($request->input('weight')){
                $timing=$this->morningOrEvening();
                $history = new UserHistory();

                $history->weight_morning = ($timing== 'morning') ? $request->input('weight') : '' ;
                $history->weight_evening = ($timing== 'evening') ? $request->input('weight') : '' ;

                $history->body_fat_percentage_morning = ($timing== 'morning') ? $request->input('fat') : '' ;
                $history->body_fat_percentage_evening = ($timing== 'evening') ? $request->input('fat') : '' ;

                // $history->calory_gained = $request->input('weight');
                // $history->calory_consumed = $request->input('weight');

                $history->recorded_at = date('Y-m-d H:i:s');
                $history->user_id = $trainee->id;
                $history->save();
            }
            
        }
                    return redirect()->route('purchaseplan')->with('message','Physical information added successfully');

    }
    public function morningOrEvening(){
            /* This sets the $time variable to the current hour in the 24 hour clock format */
        $time = date("H");
        /* Set the $timezone variable to become the current timezone */
        $timezone = date("e");
        /* If the time is less than 1200 hours, show good morning */
        if ($time < "12") {
            return "morning";
        } else
        /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
        if ($time >= "12" && $time < "17") {
            return "evening";
        } else
        /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
        if ($time >= "17" && $time < "19") {
            return "evening";
        } else
        /* Finally, show good night if the time is greater than or equal to 1900 hours */
        if ($time >= "19") {
            return "evening";
        }
    }
    public function scheduleCalendar(Request $request){ // calendar view

        // branch page 
               return view('auth.branch');

        //

        $isActive = "schedule";
        if($request->trainer_id){

            $schedule =TrainerSchedule::where('trainer_id',$request->trainer_id)->select('date as start_date','is_occupied','trainer_id','time','user_id')->get();
                $parsedArray = array();
                if($schedule){
                    foreach ($schedule as $key => $value) {
                    $parsedArray[$key]['start'] = $value->start_date;
                    $parsedArray[$key]['allDay'] = true;
                    $parsedArray[$key]['display'] = 'background';

                    if($value->user_id == Session::get('user')->id){
                        $parsedArray[$key]['color'] = 'red';

                    }else{
                        $parsedArray[$key]['color'] = '#007bff';

                    }

                    }
                }
        }else{

              $schedule =TrainerSchedule::where('user_id',Session::get('user')->id)->select('date as start_date')->get();
                $parsedArray = array();
                if($schedule){
                    foreach ($schedule as $key => $value) {
                    $parsedArray[$key]['start'] = $value->start_date;
                    $parsedArray[$key]['allDay'] = true;
                    $parsedArray[$key]['display'] = 'background';
                    $parsedArray[$key]['color'] = 'red';

                    }
                }
        }
    	

        $listSchedule =TrainerSchedule::where('user_id',Session::get('user')->id)->select('id','date as start_date','is_occupied','trainer_id','time','user_id')->get();
    	return view('pages.trainee.calendar')->with('isActive',$isActive)->with('schedule',json_encode($parsedArray,true))->with('listSchedule',$listSchedule);
    
    }
    public function scheduleCalendarSubmit(Request $request){ // when calendar date submit
        
    	// time 

        if($request->trainer_id){
            $time =TrainerSchedule::where('date',$request->selected_date)->where('trainer_id',$request->trainer_id)->get();
        }else{

            $time =TrainerSchedule::where('date',$request->selected_date)->where('user_id',Session::get('user')->id)->get();

            if(count($time) == 0){

                $trainerId = TrainerSchedule::where('date',$request->selected_date)->select('trainer_id')->groupBy('trainer_id')->get();

                $trainerList = array();
                if(($trainerId)){
                    foreach($trainerId as $key=>$val){
                        $trainerList[$key] = Trainer::find($val->trainer_id);
                    }
                }
                // dd($trainerList);
                return view('pages.trainee.trainerlist')->with('trainerList',$trainerList);
            }
        }
    	

    	return view('pages.trainee.time')
    	->with('selected_date',$request->selected_date)
    	->with('time',$time);
    }
    
    public function scheduleTime(Request $request){

    	$time =TrainerSchedule::where('date',$request->selected_date)->get();
    	return view('pages.trainee.time')
    	->with('selected_date',$request->selected_date)
    	->with('time',$time);

    }

    public function scheduleSubmit(Request $request){

    	// $arrT=explode('-',$request->start_time);
     //    $time= new Carbon($arrT[0]);
    	// $ftime = $time->format('H:i:s');
    	// $ftime = $arrT[0];

        if($request->schedule_id){
            $schedule = TrainerSchedule::find($request->schedule_id);
            $schedule->user_id=$request->user_id;
            $schedule->is_occupied=1;
            $schedule->save();
        }else{
            $schedule = new TrainerSchedule();
            $schedule->date =$request->date;
            $schedule->trainer_id =$request->trainer_id;
            $schedule->time =$request->start_time.':00:00';
            $schedule->save(); 
        }
    	
    	return redirect()->route('traineeTime.view',$request->date)
    	->with('message','Schedule time set succesfully')
    	->with('selected_date',$request->date);

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

        $bmrData = BMRcalculation("male","70","161","30");
        dd($bmrData);
        // $isactive='purchase';
        // $purchase=PlanPurchase::where('status',1)->get();
        // $userPurchasePlan=UserPlanPurchase::where('user_id',Session::get('user.id'))->first();
        // // dd($userPurchasePlan);
        // return view('pages.trainee.purchase_plan')->with('purchase',$purchase)->with('isActive',$isactive)->with('userPurchasePlan',$userPurchasePlan);
         $userPurchasePlan=UserPlanPurchase::where('user_id',Session::get('user.id'))->first();
        $isactive='purchase';
        $purchase=PlanPurchase::where('status',1)->get();
        $plan=PlanPurchase::where('id',1)->get()->first();
        return view('pages.trainee.purchase_details')->with('purchase',$purchase)->with('plan',$plan)->with('isActive',$isactive)->with('userPurchasePlan',$userPurchasePlan);

    }
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
            'password' => 'required|confirmed|min:6',
            // 'weight' => 'required',
            // 'fat' => 'required',
        ]);

            $trainee = Trainee::find($request->user_id);
            if( (!Hash::check($request->input('oldpassword'),$trainee->password))){
                return redirect()->back()->with('message','Your Previous Password did not match');
            }

            $trainee->password = Hash::make($request->input('password'));

            $trainee->save();
            return redirect()->back()
            ->with('success','Password update succesfully');
        }
        if($request->action_type == 'info_update'){

            $trainee = Trainee::find($request->user_id);
            $trainee->name = $request->input('name');

            $trainee->sex = $request->input('sex');
            $trainee->dob = $request->input('birthday');
            $trainee->length = $request->input('height');

            $trainee->phonetic = $request->input('phonetic');
            $trainee->address = $request->input('address');
            $trainee->phone = $request->input('phone');

            if($trainee->save()){
                //  EVENT TRIGGERED
                // event(new NewUserRegisteredEvent($trainee,'trainee'));
                // NOW SAVE DATA TO TBL_USER_HISTORY TABLE
                if($request->input('weight')){
                    $history = new UserHistory();
                    $history->weight = $request->input('weight');
                    $history->body_fat_percentage = $request->input('fat');
                    $history->user_id = $trainee->id;
                    $history->save();
                }
                

                // NOW SAVE DATA TO TBLE_USER_EQUIPMENT TABLE
                if($request->equipment){
                    $arr = $request->equipment;
                    foreach($arr as $val){
                        if($val['is_available'] == 1){
                            $equipment = new UserEquipment();
                            $equipment->user_id = $trainee->id;
                            $equipment->equipment_id = $val['id'];
                            // $equipment->is_available = $val['is_available'];
                            $equipment->save();
                        }
                        
                    }
                }
            }
            return redirect()->back()
            ->with('success','Profile update succesfully');
        }
        

    }
  

}
