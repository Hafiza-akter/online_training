<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class LoginController extends Controller
{
    
    public function index(){
        return view('admin.auth.login');
    }

}