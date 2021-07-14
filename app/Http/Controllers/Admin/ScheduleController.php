<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Model\Setting;
use App\Model\Equipment;
use App\Model\TrainerSchedule;
use App\Model\User;
use App\Model\Trainer;
use App\Model\Course;
use App\Model\Training;
use App\Model\Exercise;

use session;



class ScheduleController extends Controller
{

    public function index()
    {
        session()->forget('date');
        session()->forget('time');
        $list = TrainerSchedule::orderBy('id', 'desc')->get();
        return view('admin.trainer_schedule.list')->with('trainerSchedule', $list)
            ->with('page', 'schedule_management');
    }
    public function edit($id)
    {
        $scheduleData = TrainerSchedule::Where('id', $id)->first();
        $trainingData = Training::where('trainer_schedule_id', $scheduleData->id)->first();
        if($trainingData){
            $courseData = Exercise::join('tbl_courses', 'tbl_courses.id', '=', 'tbl_exercise_data.course_id')
                                    ->where('training_id', $trainingData->id)->pluck('tbl_courses.id')->toArray();
        }else{
            $courseData = [];
        }
        // dd($courseData);

        $users = User::orderBy('id', 'desc')->get();
        $trainers = Trainer::orderBy('id', 'desc')->get();
        $course = Course::Where('id', '!=', null)->get();

        return view('admin.trainer_schedule.edit')->with('schedule', $scheduleData)
            ->with('users', $users)
            ->with('trainers', $trainers)
            ->with('courses', $course)
            ->with('prev_courses', $courseData)
            ->with('page', 'schedule_management');
    }
    public function editSubmit(Request $request)
    {
        // dd($request);
        $validateData = $request->validate([
            'date' => 'required',
            'time' => 'required',
            'user' => 'required',
            'trainer' => 'required',
        ]);
        $id = $request->input('id');
        $schedule = TrainerSchedule::Where('id', $id)->first();
        $schedule->date = $request->input('date');
        $schedule->time = $request->input('time');
        $schedule->user_id = $request->input('user');
        $schedule->trainer_id = $request->input('trainer');
        $schedule->save();

        
            $trainingData = Training::Where('trainer_schedule_id', $id)->first();
            if($trainingData){
                $trainingId = $trainingData->id;
                // dd($trainingId);
            }else{
                $trainingData = new Training();
                $trainingData->trainer_schedule_id = $id;
                $trainingData->save();
                $trainingId = $trainingData->id;
                // dd($newTainingId);
            }
            Exercise::where('training_id',$trainingId)->delete();

            $courses = $request->input('course');
            if(isset($courses)){
                foreach($courses as $course){
                    $exercise = new Exercise();
                    $exercise->training_id = $trainingId;
                    $exercise->course_id = $course;
                    $courseData = Course::Where('id', $course)->first();
                    $exercise->set_1 = $courseData->set_1;
                    $exercise->set_2 = $courseData->set_2;
                    $exercise->set_3 = $courseData->set_3;
                    $exercise->save();
                }
            }
            
        return redirect()->route('admin.schedule.management.view')->with('message', 'Edited successfully!');
    }

    public function searchSubmit(Request $request)
    {
        //dd($time = $request->input('time'));
        $date = $time = null;
        if ($request->input('date')) {
            $date = $request->input('date');
        }
        if ($request->input('time')) {
            $time = $request->input('time');
        }

        if ($date != null && $time != null) {
            $list = TrainerSchedule::Where('time', $time)
                ->where('date', $date)
                ->get();
                session(['date' => $date, 'time' => $time]);
            return view('admin.trainer_schedule.list')->with('trainerSchedule', $list)
                ->with('page', 'schedule_management');
        } elseif ($date != null && $time == null) {
            $list = TrainerSchedule::where('date', $date)->get();
            session(['date' => $date]);
            return view('admin.trainer_schedule.list')->with('trainerSchedule', $list)
                ->with('page', 'schedule_management');
        } elseif ($date == null && $time != null) {
            session(['time' => $time]);
            $list = TrainerSchedule::where('time', $time)->get();
            return view('admin.trainer_schedule.list')->with('trainerSchedule', $list)
                ->with('page', 'schedule_management');
        } elseif ($date == null && $time == null) {
            session()->forget('date');
            session()->forget('time');
            return redirect()->route('admin.schedule.management.view');
        }
    }
}
