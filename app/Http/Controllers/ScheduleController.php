<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;





class ScheduleController extends Controller
{
    public function scheduleView(){
        return view('pages.schedule');
    }
    public function calenderView(){
        return view('pages.calender');
    }
    

}