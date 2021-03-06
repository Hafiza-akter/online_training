<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Model\Setting;
use App\Model\Equipment;
use App\Model\TrainerSchedule;



class ScheduleController extends Controller
{
    
    public function index(){
        $list = TrainerSchedule::all();
        return view('admin.trainer_schedule.list')->with('trainerSchedule',$list);
    }
}