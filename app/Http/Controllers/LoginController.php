<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Hash;
use Session;
use Carbon\Carbon;
use App\Model\Trainer;
use App\Model\Trainee;
use App\Model\Equipment;
use Illuminate\Support\Facades\Crypt;

use DateTime;
use DateInterval;
use Redirect,Response,File;
use Socialite;


class LoginController extends Controller
{
    public function index(){
        return view('pages.index');
    }
    public function loginTest(){
        return view('pages.test');
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
    public function dashboard(){
        return view('pages.trainer.dashboard');
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
            return redirect()->back()->with('message','ユーザー名もしくはパスワードが正しくありません。');
        }
        else{
            session(['user' => $trainer,'user_type'=>'trainer','message'=>'ログインに成功しました。']);
            return redirect()->route('calendar.view','month')->with('message','ログインに成功しました。');

        }

        
    }

    public function loginTraineeSubmit(Request $request){
        $validateData = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $email = $request->input('username');
        // dd($email);
        $input_password = $request->input('password');
        $trainee = Trainee::where('email',$email)
                        ->first();
        // dd($trainee);
        if(!$trainee || (!Hash::check($input_password,$trainee->password))){

            return redirect()->back()->with('message','ユーザー名もしくはパスワードが正しくありません。');
        
        }
        else{

            session(['user' => $trainee,'user_type'=>'trainee','message'=>'ログインに成功しました。']);
            return redirect()->route('traineeCalendar.view')->with('message','ログインに成功しました。');

        }


    }

    public function signupTrainee(){
        return view('auth.signup_trainee');
    }
    public function signupTrainer(){
        return view('auth.signup_trainer');
    }
    // public function signupTraineeSubmit(Request $request){
    //     $validateData = $request->validate([
    //         'email' => 'required',
    //         // 'password' => 'required',
    //     ]);
    //     $randomNumber = rand(4444,99999);
    //     $date= new DateTime();
    //     // dd($date);
    //     $expire_date = $date->add(new DateInterval('PT24H00S'));
    //     // dd( $date->format('Y-m-d H:i:s'));
    //     $trainee = new Trainee();
    //     $trainee->name = $request->input('name');
    //     $trainee->phonetic = $request->input('phonetic');
    //     $trainee->email = $request->input('email');
    //     // $password = $request->input('password');
    //     // $trainee->password = Hash::make($password);
    //     $trainee->address = $request->input('address');
    //     $trainee->token = $randomNumber;
    //     $trainee->expired_at = $expire_date;
    //     $trainee->phone = $request->input('phone');
    //     $trainee->weight = $request->input('weight');
    //     // $trainee->photo_path = $request->input('photo_path');
    //     // $trainee->unit_price = $request->input('unit_price');
    //     $ab = $trainee->save();
    //     if($ab){
    //         dd('save');
    //     }
    //     else{
    //         dd('not save');
    //     }
    // }
    // public function signupTrainerSubmit(Request $request){

    //     $validateData = $request->validate([
    //         'email' => 'required',
    //         // 'password' => 'required',
    //     ]);
    //     $randomNumber = rand(4444,99999);
    //     $date= new DateTime();
    //     // dd($date);
    //     $expire_date = $date->add(new DateInterval('PT24H00S'));
    //     // dd( $date->format('Y-m-d H:i:s'));
    //     $trainer = new Trainer();
    //     $trainer->name = $request->input('name');
    //     $trainer->phonetic = $request->input('phonetic');
    //     $trainer->email = $request->input('email');
    //     // $password = $request->input('password');
    //     // $trainer->password = Hash::make($password);
    //     $trainer->address = $request->input('address');
    //     $trainer->token = $randomNumber;
    //     $trainer->expired_at = $expire_date;
    //     $trainer->phone = $request->input('phone');
    //     $trainer->intro = $request->input('intro');
    //     $trainer->photo_path = $request->input('photo_path');
    //     $trainer->unit_price = $request->input('unit_price');
    //     $ab = $trainer->save();
    //     if($ab){
    //         dd('save');
    //     }
    //     else{
    //         dd('not save');
    //     }



    // }
    public function tokenVerify(){
        dd('hello world');
    }
    public function tokenReset(){
        return view('auth.forget_password');
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
        return redirect()->back()->with('message','トークンの期限が切れています。');
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
        return redirect()->back()->with('message','トークンの期限が切れています。');
    }

    public function inquery(){
        return view('pages.inquery');
    }
    public function logout(){
        session()->flush();
        return redirect()->route('toppage');
    }
    public function googleRedirect($provider)
    {
        
        return Socialite::driver($provider)->redirect();
    }
     
    public function googleCallback($provider)
    {

        $getInfo = Socialite::driver($provider)->stateless()->user();
         
        $user = $this->createUser($getInfo,$provider);
        
        if(Session::get('tp') == 'trainee'){
            $parameter =[
                'type'=>'trainee',
                'id'=>$user->id
            ];
            $parameter= Crypt::encrypt($parameter);
            return redirect()->route('googleuser',$parameter);
        }
        if(Session::get('tp') == 'trainer'){
            $parameter =[
                'type'=>'trainer',
                'id'=>$user->id
            ];
            $parameter= Crypt::encrypt($parameter);
            return redirect()->route('googleuser',$parameter);
        }

    }
    function createUser($getInfo,$provider){
     
     if(Session::get('tp') == 'trainer'){
        $user = Trainer::where('email', $getInfo->email)->first();

     }
    if(Session::get('tp') == 'trainee'){
        $user = Trainee::where('email', $getInfo->email)->first();
     }
     
     if (!$user) {
          if(Session::get('tp') == 'trainer'){
            $user = new Trainer();
            $user->first_name =  $getInfo->name;
    
         }
        if(Session::get('tp') == 'trainee'){
            $user = new Trainee();
            $user->name =  $getInfo->name;

         }
        $user->email =  $getInfo->email;
        $user->is_verified =  1;
        $user->is_google =  1;
        $user->save();
        
      }
     
        
      return $user;
    }
    

}