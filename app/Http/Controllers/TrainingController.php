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
use App\Model\TrainerRecurringSchedule;
use App\Model\Course;
use App\Model\Training;
use App\Model\Exercise;


use DateTime;
use DateInterval;

class TrainingController extends Controller
{

    public function trainingDetails(Request $request){

        $course = Course::where('status',1)->get();
        $main=Course::where('status',1)->groupBy('main')->get();

        $schedule = TrainerSchedule::find($request->id);
        $exerciseData = Training::where('trainer_schedule_id',$request->id)->first();
        // dd($exerciseData);
        // dd($exerciseData->getExerciseData);
    	return view('pages.trainer.training_details')
    	->with('course',$course)
    	->with('main',$main)
    	->with('exerciseData',$exerciseData)
    	->with('schedule',$schedule);
    }
    public function training_performance(Request $request){
    	// dd($request->all());
    	$course = $request->course;

    	$scheduleIdexist=Training::where('trainer_schedule_id',$request->schedule_id)->first();
    	if(!$scheduleIdexist){
    		$training = new Training();
    		$training->trainer_schedule_id=$request->schedule_id;
    		$training->save();

    		$training_id = $training->id;
    	}else{
    		$training_id = $scheduleIdexist->id;
    	}

    	exercise::where('training_id',$training_id)->delete();
    	foreach($course as $key=>$val){

    		$exercise = new Exercise();
    		$exercise->training_id = $training_id;
    		$exercise->course_id = $val;
    		$exercise->set_1 = $request->set1_kg[$key]."_".$request->set1_times[$key];
    		$exercise->set_2 = $request->set2_kg[$key]."_".$request->set2_times[$key];
    		$exercise->set_3 = $request->set3_kg[$key]."_".$request->set3_times[$key];
    		$exercise->save();

    	}

    	return redirect()->back()->with('message','Training performance added successfully! ');


    }
    public function getcourse(Request $request){

       
    	 $course = Course::Leftjoin('tbl_equipments', 'tbl_equipments.id', '=', 'tbl_courses.equipment_id')
        		->where('tbl_courses.main',$request->main)
        ->select('tbl_equipments.id as equipment_id','tbl_equipments.name as equipment_name','tbl_courses.id','tbl_courses.course_name')->get();

        return response()->json($course); 

    }
    public function getcoursedetails(Request $request){

       
    	 $course = Course::Leftjoin('tbl_equipments', 'tbl_equipments.id', '=', 'tbl_courses.equipment_id')
        		->where('tbl_courses.id',$request->course)
        ->select('tbl_equipments.id as equipment_id','tbl_equipments.name as equipment_name','tbl_courses.*')->get();

        return response()->json($course); 

    }
    
    
}