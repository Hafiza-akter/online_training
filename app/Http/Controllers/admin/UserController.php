<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Hash;

use App\Model\Admin;
use App\Model\User;
use App\Model\TrainerSchedule;
use App\Model\Trainer;



class UserController extends Controller
{
    
    public function userManagement(){
        return view(('admin.user'))
        ->with('page','user');

    }

    public function userManagementDeatil(){
        return view(('admin.user_details'))
        ->with('page','user');

    }
    public function adminList(){
        $data = Admin::Orderby('id','desc')->get();
        // dd($data);
        return view('admin.user.list')->with('userData',$data)
                                    ->with('page','admin_setting');
    }
    public function adminAdd(){
        return view('admin.user.add')->with('page','admin_setting');
    }
    public function adminAddSubmit(Request $request){
        // dd($request);
        $validateData = $request->validate([
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);
        $admin = new Admin();
        $admin->email = $request->input('email');
        $admin->password = Hash::make($request->input('password'));
        $admin->role = $request->input('role');
        if($request->input('status')){
            $admin->status = 1;
        }
        else{
            $admin->status = 0;
        }
        $admin->save();
        return redirect()->route('admin.list')->with('message', 'Added successfully!');


    }
    public function adminEdit($id){
        $data = Admin::Where('id',$id)->first();
        return view('admin.user.edit')->with('user',$data)
        ->with('page','admin_setting');
 
     }

    public function adminEditSubmit(Request $request){
        // dd($request);
        $validateData = $request->validate([
            'email' => 'required',
            'role' => 'required',
        ]);
        $admin =  Admin::Where('id',$request->input('id'))->first();
        $admin->email = $request->input('email');
        if($request->input('password')){
            $admin->password = Hash::make($request->input('password'));
        }
        $admin->role = $request->input('role');
        if($request->input('status')){
            $admin->status = 1;
        }
        else{
            $admin->status = 0;
        }
        $admin->save();
        return redirect()->route('admin.list')->with('message', 'Edited successfully!');

    }

    public function userList(){
        $userList = User::orderBy('id','DESC')->get();
        // dd($trainerList);
        return view('admin.user_manage.list')->with('userList',$userList)
                                            ->with('page','user');
    }
    public function userEdit($id){
        $data = User::Where('id',$id)->first();
        return view('admin.user_manage.edit')->with('user',$data)
        ->with('page','user');
     
    }

    public function userEditSubmit(Request $request){
        // dd($request);
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);
        $id = $request->input('id');
        $data = User::Where('id',$id)->first();
        $data->name = $request->input('name');
        $data->phonetic = $request->input('phonetic');
        $data->email = $request->input('email');
        $data->weight = $request->input('weight');
        $data->length = $request->input('length');
        if($request->input('status')){
            $data->status = 1;
        }
        else{
            $data->status = 0;
        }
        $data->save();
        return redirect()->route('user.list')->with('message', 'Edited successfully!');

    }

    public function trainingHistory($id){
        $user = User::Where('id',$id)->first();
        $trainingHistory = TrainerSchedule::Join('tbl_trainings','tbl_trainings.trainer_schedule_id','=','tbl_trainer_schedules.id')
                                            ->Join('tbl_exercise_data','tbl_exercise_data.training_id','=','tbl_trainings.id')
                                            ->Join('tbl_courses','tbl_courses.id','=','tbl_exercise_data.course_id')
                                            ->Join('tbl_equipments','tbl_equipments.id','=','tbl_courses.equipment_id')
                                            ->where('tbl_trainer_schedules.user_id',$id)
                                            ->where('tbl_trainer_schedules.status','completed')
                                            ->select('tbl_trainings.id as training_id','tbl_trainer_schedules.user_id','tbl_trainer_schedules.date','tbl_trainer_schedules.time','tbl_exercise_data.course_id','tbl_exercise_data.set_1','tbl_exercise_data.set_2','tbl_exercise_data.set_3','tbl_courses.course_name','tbl_equipments.name as item')
                                            ->get();

        // dd($trainingHistory);
        return view('admin.user_manage.training_history')
        ->with('trainings',$trainingHistory)
        ->with('user_id',$id)
        ->with('page','user');
    }

    public function csvDownload($id){
        $user = User::Where('id',$id)->first();
        $trainingHistory = TrainerSchedule::Join('tbl_trainings','tbl_trainings.trainer_schedule_id','=','tbl_trainer_schedules.id')
                                            ->Join('tbl_exercise_data','tbl_exercise_data.training_id','=','tbl_trainings.id')
                                            ->Join('tbl_courses','tbl_courses.id','=','tbl_exercise_data.course_id')
                                            ->Join('tbl_equipments','tbl_equipments.id','=','tbl_courses.equipment_id')
                                            ->where('tbl_trainer_schedules.user_id',$id)
                                            ->where('tbl_trainer_schedules.status','completed')
                                            ->select('tbl_trainings.id as training_id','tbl_trainer_schedules.user_id','tbl_trainer_schedules.date','tbl_trainer_schedules.time','tbl_exercise_data.course_id','tbl_exercise_data.set_1','tbl_exercise_data.set_2','tbl_exercise_data.set_3','tbl_courses.course_name','tbl_equipments.name as item')
                                            ->get();

            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=training_history.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );
        
            $data = $trainingHistory;
            $columns = array('User Id', 'Date', 'Time', 'Course', 'Item', 'Set 1', 'Set 2', 'Set 3');
        
            $callback = function() use ($data, $columns)
            {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
        
                foreach($data as $data) {
                    fputcsv($file, array($data->user_id, $data->date, $data->time, $data->course_name, $data->item, $data->set_1,$data->set_2,$data->set_3));
                }
                fclose($file);
            };
            return Response()->stream($callback, 200, $headers);
                                        
        }

    public function dw()
    {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=user.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
    
        $reviews = User::all();
        $columns = array('name', 'email');
    
        $callback = function() use ($reviews, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
    
            foreach($reviews as $review) {
                fputcsv($file, array($review->name, $review->email));
            }
            fclose($file);
        };
        return Response()->stream($callback, 200, $headers);
    }
   

}