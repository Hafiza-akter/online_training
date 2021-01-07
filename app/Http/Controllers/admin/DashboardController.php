<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class DashboardController extends Controller
{
    public function index(){
        return view(('admin.dashboard'));
    }

    
    public function scheduleManagement(){
        return view(('admin.schedule'));
    }
    

}