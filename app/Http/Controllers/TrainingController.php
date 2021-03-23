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
use Illuminate\Support\Facades\Crypt;
use App\Model\User;


use DateTime;
use DateInterval;

class TrainingController extends Controller
{

    public function trainingDetails(Request $request){
            $data = Crypt::decrypt($request->id);

        $course = Course::where('status',1)->get();
        $main=Course::where('status',1)->groupBy('main')->get();

        $schedule = TrainerSchedule::where('id',$data['id'])->whereDate('date',Carbon::now()->format('Y-m-d'))->get()->first();
        $exerciseData = Training::where('trainer_schedule_id',$data['id'])->first();
        
        // dd($exerciseData);
        // dd($exerciseData->getExerciseData);

        // check training time and date //
    	// errors_m

        if($schedule){
        	$startTime = Carbon::parse($schedule->time)->format("H:i:s");
        	$endTime = Carbon::parse($schedule->time)->addMinutes(60)->format("H:i:s");

            if($endTime = "00:00:00"){
                $endTime ="24:00:00";
            }
        	// dd($endTime);
        	$start = $startTime;
			$end   = $endTime;
			$now   = Carbon::now();
			$time  = $now->format('H:i:s');

            // dd($end);
			if ($time >= $start && $time <= $endTime) {
			  // meeting  time
				// dd('meeting time');
			}else{
        		return redirect()->back()->with('errors_m','選択されたトレーニングは  '.Carbon::parse($schedule->date)->format('Y-m-d')." の ".Carbon::parse($schedule->time)->format('H:i')." - ".Carbon::parse($schedule->time)->addMinutes(60)->format('H:i')."までの時間で開始可能です。" );
			}
        }
        // dd('here');

        if(!$schedule){
   			$schedule = TrainerSchedule::find($data['id']);
        		return redirect()->back()->with('errors_m','選択されたトレーニングは  '.Carbon::parse($schedule->date)->format('Y-m-d')." の ".Carbon::parse($schedule->time)->format('H:i')." - ".Carbon::parse($schedule->time)->addMinutes(60)->format('H:i')."までの時間で開始可能です。" );
        }

         if(Session::get('user_type') == 'trainee'){
            $view = 'pages.trainee.training_details';
         }else{
            $view = 'pages.trainer.training_details';
         }


        // dd('dd');
    	return view($view)
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

    	return response()->json(array('success' => true));


    }
    public function ajax_training_performance(Request $request){
        // dd($data['id']);
        $id = $request->id;
        $course = Course::where('status',1)->get();
        $main=Course::where('status',1)->groupBy('main')->get();

        $schedule = TrainerSchedule::where('id',$id)->get()->first();
        $exerciseData = Training::where('trainer_schedule_id',$id)->first();

        $returnHTML = view('pages.trainee.ajax_modal')
        ->with('course',$course)
        ->with('main',$main)
        ->with('exerciseData',$exerciseData)
        ->with('schedule',$schedule)->render();


        return response()->json(array('success' => true, 'html'=>$returnHTML));
        
        
    }
    public function ajax_training_get_comment(Request $request){
         // dd($request->id);
        $id = $request->id;
        $course = Course::where('status',1)->get();
        $main=Course::where('status',1)->groupBy('main')->get();

        $schedule = TrainerSchedule::where('id',$id)->get()->first();
        $exerciseData = Training::where('trainer_schedule_id',$id)->first();

        $returnHTML = view('pages.trainee.ajax_modal_comment')
        ->with('course',$course)
        ->with('main',$main)
        ->with('exerciseData',$exerciseData)
        ->with('schedule',$schedule)->render();


        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }
    public function training_feedback(Request $request){

    	$scheduleIdexist=Training::where('trainer_schedule_id',$request->schedule_id)->first();
    	if(!$scheduleIdexist){
    		$training = new Training();
    		$training->trainer_schedule_id=$request->schedule_id;
    		if(Session::get('user_type') == 'trainee'){
    			$training->comment=$request->user_feedback;
    		}else{
    			$training->comment=$request->user_feedback;
    		}

    		$training->save();

    		$training_id = $training->id;
    	}else{

    		if(Session::get('user_type') == 'trainee'){
    			$scheduleIdexist->comment=$request->user_feedback;
    		}else{
    			$scheduleIdexist->comment=$request->user_feedback;
    		}

    		$scheduleIdexist->save();
    	}
         
        return response()->json(array('success' => true));

    }

    public function trainingfinished(Request $request){
 
    	$course = Course::where('status',1)->get();
        $main=Course::where('status',1)->groupBy('main')->get();

        $schedule = TrainerSchedule::find($request->id);
        $exerciseData = Training::where('trainer_schedule_id',$request->id)->first();
        // dd($request->id);
        // dd($exerciseData->getExerciseData);
    	return view('pages.trainer.trainingfinished')
    	->with('course',$course)
    	->with('main',$main)
    	->with('exerciseData',$exerciseData)
    	->with('schedule',$schedule);
    }
    public function traineefinished(Request $request){
 
        $course = Course::where('status',1)->get();
        $main=Course::where('status',1)->groupBy('main')->get();

        $schedule = TrainerSchedule::find($request->id);
        $exerciseData = Training::where('trainer_schedule_id',$request->id)->first();
        // dd($request->id);
        // dd($exerciseData->getExerciseData);
        return view('pages.trainee.traineefinished')
        ->with('course',$course)
        ->with('main',$main)
        ->with('exerciseData',$exerciseData)
        ->with('schedule',$schedule);
    }

    public function success(Request $request){
    	$course = $request->course;
    	$schedule = TrainerSchedule::find($request->schedule_id);
    	// dd($schedule);
    	$schedule->status = "completed";
    	$schedule->save();

    	$scheduleIdexist=Training::where('trainer_schedule_id',$request->schedule_id)->first();
    	if(!$scheduleIdexist){
    		$training = new Training();
    		$training->trainer_schedule_id=$request->schedule_id;
    		if(Session::get('user_type') == 'trainee'){
    			$training->comment=$request->user_feedback;
    		}else{
    			$training->trainer_feedback=$request->user_feedback;
    		}
    		$training->save();

    		$training_id = $training->id;
    	}else{
    		$training_id = $scheduleIdexist->id;
    		if(Session::get('user_type') == 'trainee'){
    			$scheduleIdexist->comment=$request->user_feedback;
    		}else{
    			$scheduleIdexist->trainer_feedback=$request->user_feedback;
    		}

    		$scheduleIdexist->save();
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
        
        if(Session::get('user_type') == 'trainee'){
                return redirect()->route('traineelist')->with('message','Training information added successfully! ');
            }else{
                return redirect()->route('traininglist')->with('message','Training information added successfully! ');
            }
    	
    }
    public function userhistory(Request $request){
        $course = Course::where('status',1)->get();
        $main=Course::where('status',1)->groupBy('main')->get();
        $user=Trainee::find($request->id);
        if(!$user){
            return redirect()->route('calendar.view','month')->with('errors_m','ユーザーは存在しません');
        }
        // $schedule = TrainerSchedule::find($request->id);
        if($request->birthday){
            $date = Carbon::createFromFormat('Y-m', $request->birthday);
            // dd($date->year);
            $list = Training::whereMonth('created_at',$date->month)
                            ->whereYear('created_at',$date->year)
                            ->orderBy('id','DESC')->get();
        }else{
            $date = '';
            $list = Training::orderBy('id','DESC')->get();
        }
        // dd($request->id);
        // dd($exerciseData->getExerciseData);
        return view('pages.trainer.user_history')
        ->with('course',$course)
        ->with('userId',$request->id)
        ->with('user',$user)
        ->with('isActive','traininglist')
        ->with('list',$list)
        ->with('date',$date)
        ->with('main',$main);
    }
    public function trainerhistory(Request $request){
        $course = Course::where('status',1)->get();
        $main=Course::where('status',1)->groupBy('main')->get();
        $user=Trainer::find($request->id);
        if(!$user){
            return redirect()->route('calendar.view','month')->with('errors_m','ユーザーは存在しません');
        }
        // $schedule = TrainerSchedule::find($request->id);
        if($request->birthday){
            $date = Carbon::createFromFormat('Y-m', $request->birthday);
            // dd($date->year);
            $list = Training::whereMonth('created_at',$date->month)
                            ->whereYear('created_at',$date->year)
                            ->orderBy('id','DESC')->get();
        }else{
            $date = '';
            $list = Training::orderBy('id','DESC')->get();
        }
        // dd($list);
        // dd($request->id);
        // dd($exerciseData->getExerciseData);
        return view('pages.trainee.trainer_history')
        ->with('course',$course)
        ->with('userId',$request->id)
        ->with('user',$user)
        ->with('list',$list)
        ->with('date',$date)
        ->with('main',$main);
    }
    public function list(Request $request){
    	$course = Course::where('status',1)->get();
        $main=Course::where('status',1)->groupBy('main')->get();

        // $schedule = TrainerSchedule::find($request->id);
        if($request->birthday){
            $date = Carbon::createFromFormat('Y-m', $request->birthday);
            // dd($date->year);
            $list = Training::whereMonth('created_at',$date->month)
                            ->whereYear('created_at',$date->year)
                            ->orderBy('id','DESC')->get();
        }else{
            $date = '';
            $list = Training::orderBy('id','DESC')->get();
        }
        // dd($list);
        // dd($exerciseData->getExerciseData);
    	return view('pages.trainer.traininglist')
    	->with('course',$course)
        ->with('isActive','traininglist')
    	->with('list',$list)
        ->with('date',$date)
    	->with('main',$main);
    }
    public function traineelist(Request $request){
        $course = Course::where('status',1)->get();
        $main=Course::where('status',1)->groupBy('main')->get();

        // $schedule = TrainerSchedule::find($request->id);
        $list = Training::orderBy('id','DESC')->get();
        // dd($request->id);
        // dd($exerciseData->getExerciseData);
        return view('pages.trainee.traininglist')
        ->with('course',$course)
        ->with('isActive','traininglist')
        ->with('list',$list)
        ->with('main',$main);
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