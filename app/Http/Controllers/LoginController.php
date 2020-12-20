<?php
namespace App\Http\Controllers;

class LoginController extends Controller
{
    public function index(){
        return view('home');
    }
    public function login(){
        return view('auth.login');
    }
    public function loginTrainee(){
        return view('auth.login_trainee');
        // return dd('asdas');
    }
    public function loginTrainer(){
        return view('auth.login_trainer');
    }
}