<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Hash;
use Session;
use Carbon\Carbon;
use App\Model\Admin;




class LoginController extends Controller
{

    public function index()
    {
        return view('admin.auth.login');
    }
    public function adminLoginSubmit(Request $request)
    {
        $validateData = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $email = $request->input('username');
        // dd($email);
        $input_password = $request->input('password');
        $admin = Admin::where('email', $email)
            ->first();
        // dd($admin);
        if (!$admin || (!Hash::check($input_password, $admin->password))) {

            return redirect()->back()->with('message', 'Incorrect username or password!');
        } else {

            session(['user' => $admin, 'user_type' => 'admin', 'message' => 'Login Success']);
            return redirect()->route('admin.dashboard')->with('message', 'login success!');
        }
    }
    public function logout(){
        session()->flush();
        return redirect()->route('admin.login');
    }
}
