<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Hash;

use App\Model\Admin;



class UserController extends Controller
{
    
    public function userManagement(){
        return view(('admin.user'));
    }

    public function userManagementDeatil(){
        return view(('admin.user_details'));
    }
    public function adminList(){
        $data = Admin::Orderby('id','desc')->get();
        // dd($data);
        return view('admin.user.list')->with('userData',$data);
    }
    public function adminAdd(){
        return view('admin.user.add');
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
        return view('admin.user.edit')->with('user',$data);   
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
   

}