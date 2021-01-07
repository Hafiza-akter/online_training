<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class UserController extends Controller
{
    
    public function userManagement(){
        return view(('admin.user'));
    }

    public function userManagementDeatil(){
        return view(('admin.user_details'));
    }

}