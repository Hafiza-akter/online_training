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

class TrainerController extends Controller
{
    public function trainerView(){
        return view('pages.trainer_details');
    }
    public function scheduleCalendar(Request $request){
        $isActive = "schedule";
    	$schedule =TrainerSchedule::where('trainer_id',Session::get('user')->id)->select('id','date as start_date','is_occupied','trainer_id','time','user_id')->groupBy('date')->get();
    	$parsedArray = array();
    	if($schedule){
    		foreach ($schedule as $key => $value) {

    			if($value->trainer_id == Session::get('user')->id){
    				$parsedArray[$key]['start'] = $value->start_date;
		    		$parsedArray[$key]['allDay'] = true;
		    		$parsedArray[$key]['display'] = 'background';
		    		if($value->is_occupied === 1){
		    			$parsedArray[$key]['color'] = 'red';

		    		}else{
		    			 $parsedArray[$key]['color'] = '#007bff';


		    		}
    			}
	    		

    		}
    	}
        $listSchedule =TrainerSchedule::where('trainer_id',Session::get('user')->id)->select('id','date as start_date','is_occupied','trainer_id','time','user_id')->get();
    	return view('pages.trainer.calendar')->with('isActive',$isActive)->with('schedule',json_encode($parsedArray,true))->with('listSchedule',$listSchedule);
    }
    public function scheduleCalendarSubmit(Request $request){
    	// time 
    	$time =TrainerSchedule::where('date',$request->selected_date)->where('trainer_id',Session::get('user')->id)->get();

    	return view('pages.trainer.time')
    	->with('selected_date',$request->selected_date)
    	->with('time',$time);
    }
    
    public function scheduleTime(Request $request){
    	$time =TrainerSchedule::where('date',$request->selected_date)->get();
    	return view('pages.trainer.time')
    	->with('selected_date',$request->selected_date)
    	->with('time',$time);
    }

    public function scheduleSubmit(Request $request){

    	// $arrT=explode('-',$request->start_time);
     //    $time= new Carbon($arrT[0]);
    	// $ftime = $time->format('H:i:s');
    	// $ftime = $arrT[0];


        // validation for unique time set up 

        $allDateSchedule = TrainerSchedule::where('date',$request->date)->get();

        if($allDateSchedule){
            foreach($allDateSchedule as $val){


                $start =strtotime($val->time);

                $timestamp = strtotime($val->time) + 60*60;
                $end = strtotime(date('H:i:s', $timestamp));

                $ctime=  strtotime($request->start_time.':00') + 60*60; 
               
                if ( $ctime > $start && $ctime < $end ) {
                    return redirect()->back()->with('errors_m','Time slot is not avaliable');

                }


            }

        }


    	$schedule = new TrainerSchedule();
    	$schedule->date =$request->date;
    	$schedule->trainer_id =$request->trainer_id;
    	$schedule->time =$request->start_time.':00';
    	$schedule->save();

    	return redirect()->route('trainerTime.view',$request->date)
    	->with('message','Schedule time set succesfully')
    	->with('selected_date',$request->date);

    }
     public function logout(){
        session()->flush();
        return redirect()->route('trainerLogin');
    }
    public function trainerDetails(Request $request){
    	$trainerData = Trainer::find($request->id);
    	return view('pages.trainee.trainer_details')->with('trainerData',$trainerData);
    }

    public function trainerScheduleDelete($id){
        TrainerSchedule::Where('id',$id)->delete();
        return redirect()->back()->with('message','Schedule delete successful');


    }
  

}