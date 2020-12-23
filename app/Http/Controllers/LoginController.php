<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Hash;
use Session;
use Carbon\Carbon;
use App\Model\Trainer;
use DateTime;
use DateInterval;



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
    public function loginTrainerSubmit(Request $request){
        $validateData = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $email = $request->input('username');
        $input_password = $request->input('password');
        $trainer = Trainer::where('email',$email)
                        ->first();
                        // dd($trainer);
        if(!$trainer || (!Hash::check($input_password,$trainer->password))){
            return redirect()->back()->with('message','Incorrect username or password!');
        }
        else{
            return redirect()->back()->with('message','login success!');

        }

        
    }

    public function signupTrainer(){
        return view('auth.signup_trainer');
    }
    public function signupTrainerSubmit(Request $request){

        $validateData = $request->validate([
            'email' => 'required',
            // 'password' => 'required',
        ]);
        $randomNumber = rand(4444,99999);
        $date= new DateTime();
        // dd($date);
        // $expire_date = $date->add(new DateInterval('PT24H10S'));
        // dd( $date->format('Y-m-d H:i:s'));
        $trainer = new Trainer();
        $trainer->name = $request->input('name');
        $trainer->phonetic = $request->input('phonetic');
        $trainer->email = $request->input('email');
        // $password = $request->input('password');
        // $trainer->password = Hash::make($password);
        $trainer->address = $request->input('address');
        $trainer->token = $randomNumber;
        $trainer->expired_at = $date;
        $trainer->phone = $request->input('phone');
        $trainer->intro = $request->input('intro');
        $trainer->photo_path = $request->input('photo_path');
        $trainer->unit_price = $request->input('unit_price');
        $ab = $trainer->save();
        if($ab){
            dd('save');
        }
        else{
            dd('not save');
        }



    }
    public function tokenVerify(){
        dd('hello world');
    }
    public function tokenReset(){
        return view('auth.token_reset');
    }
    public function tokenResetSubmit(Request $request){
        $validateData = $request->validate([
            'email' => 'required',
            // 'password' => 'required',
        ]);
        $email = $request->input('email');
        $trainer = Trainer::where('email',$email)->first();
        $current_time = $trainer->expired_at; 
        // echo $current_time;
        $date = new DateTime($current_time);
        $new_time =  $date->add(new DateInterval('PT24H00S'));
        // dd($new_time);
        $trainer->expired_at = $new_time;
        $trainer->save();
        return redirect()->back()->with('message','Password reset!');


    }

}