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


use DateTime;
use DateInterval;

class TraineeController extends Controller
{
    public function traineeView(){
        return view('pages.trainer_details');
    }
    public function scheduleCalendar(Request $request){ // calendar view
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
        $isactive='purchase';
        return view('pages.trainee.purchase_plan')->with('isactive',$isactive);

    }
  

}
