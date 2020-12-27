<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Hash;
use Session;
use Carbon\Carbon;
use App\Model\Trainer;
use App\Model\Trainee;
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

    public function loginTraineeSubmit(Request $request){
        // dd('hjhvghv');
        $validateData = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $email = $request->input('username');
        $input_password = $request->input('password');
        $trainee = Trainee::where('email',$email)
                        ->first();
                        // dd($trainee);
        if(!$trainee){
            return redirect()->back()->with('message','Incorrect username or password!');
        }
        else{
            return redirect()->back()->with('message','login success!');

        }
    }

    public function signupTrainee(){
        return view('auth.signup_trainee');
    }
    public function signupTrainer(){
        return view('auth.signup_trainer');
    }
    public function signupTraineeSubmit(Request $request){
        $validateData = $request->validate([
            'email' => 'required',
            // 'password' => 'required',
        ]);
        $randomNumber = rand(4444,99999);
        $date= new DateTime();
        // dd($date);
        $expire_date = $date->add(new DateInterval('PT24H00S'));
        // dd( $date->format('Y-m-d H:i:s'));
        $trainee = new Trainee();
        $trainee->name = $request->input('name');
        $trainee->phonetic = $request->input('phonetic');
        $trainee->email = $request->input('email');
        // $password = $request->input('password');
        // $trainee->password = Hash::make($password);
        $trainee->address = $request->input('address');
        $trainee->token = $randomNumber;
        $trainee->expired_at = $expire_date;
        $trainee->phone = $request->input('phone');
        $trainee->weight = $request->input('weight');
        // $trainee->photo_path = $request->input('photo_path');
        // $trainee->unit_price = $request->input('unit_price');
        $ab = $trainee->save();
        if($ab){
            dd('save');
        }
        else{
            dd('not save');
        }
    }
    public function signupTrainerSubmit(Request $request){

        $validateData = $request->validate([
            'email' => 'required',
            // 'password' => 'required',
        ]);
        $randomNumber = rand(4444,99999);
        $date= new DateTime();
        // dd($date);
        $expire_date = $date->add(new DateInterval('PT24H00S'));
        // dd( $date->format('Y-m-d H:i:s'));
        $trainer = new Trainer();
        $trainer->name = $request->input('name');
        $trainer->phonetic = $request->input('phonetic');
        $trainer->email = $request->input('email');
        // $password = $request->input('password');
        // $trainer->password = Hash::make($password);
        $trainer->address = $request->input('address');
        $trainer->token = $randomNumber;
        $trainer->expired_at = $expire_date;
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
        $date= new DateTime();
        $new_time =  $date->add(new DateInterval('PT24H00S'));
        // dd($new_time);
        $trainer->expired_at = $new_time;
        $trainer->save();
        return redirect()->back()->with('message','Token expired time reset!');
    }

    public function tokenResetTrainee(){
        return view('auth.token_reset_trainee');
    }
    public function tokenResetSubmitTrainee(Request $request){
        $validateData = $request->validate([
            'email' => 'required',
            // 'password' => 'required',
        ]);
        $email = $request->input('email');
        $trainee = Trainee::where('email',$email)->first();
        $date= new DateTime();
        $new_time =  $date->add(new DateInterval('PT24H00S'));
        $trainee->expired_at = $new_time;
        $trainee->save();
        return redirect()->back()->with('message','Token expired time reset!');
    }

    public function inquery(){
        return view('pages.inquery');
    }

}