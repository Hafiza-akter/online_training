<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Hash;
use Session;

use App\Events\NewUserRegisteredEvent;
use Carbon\Carbon;
use App\Model\Trainer;
use App\Model\Trainee;
use App\Model\Equipment;
use App\Model\TrainerEquipment;
use App\Model\UserEquipment;
use App\Model\UserHistory;

use DateTime;
use DateInterval;



class SignupController extends Controller
{
    public function index(){
        
    }

    public function signupTrainee(){
         session(['tp' => 'trainee']);
        return view('auth.signup_trainee')->with('equipment',Equipment::get());
    }
    public function signupTraineeSubmit(Request $request){

        // dd($request->equipment);
        // dd(route('signup.verification',$request->_token));
        $validateData = $request->validate([

            'email' => 'email',
            // 'name' => 'required',
            // 'password' => 'required|confirmed|min:6',
            // 'weight' => 'required',
            // 'fat' => 'required',
        ]);

        $date= new DateTime();
        $trainee = new Trainee();
        
        $trainee->email = $request->input('email');
        $trainee->token = \Str::random(60).time();
        $trainee->expired_at = $date->add(new DateInterval('PT24H00S'));

        if($trainee->save()){
            //  EVENT TRIGGERED
            event(new NewUserRegisteredEvent($trainee,'trainee'));
        }
        session(['tp' => '']);
        return redirect()->route('signup.verificationview');
    }

    public function signupTraineeUpdate(Request $request){

        // dd($request->equipment);
        // dd(route('signup.verification',$request->_token));
        $validateData = $request->validate([

            'email' => 'email',
            // 'name' => 'required',
            'password' => 'required|confirmed|min:6',
            // 'weight' => 'required',
            // 'fat' => 'required',
        ]);

        $date= new DateTime();
        $trainee = Trainee::find($request->user_id);
        $trainee->name = $request->input('name');

        $trainee->sex = $request->input('sex');
        $trainee->birthday = $request->input('birthday');
        $trainee->height = $request->input('height');

        $trainee->phonetic = $request->input('phonetic');
        $trainee->email = $request->input('email');
        $trainee->address = $request->input('address');
        $trainee->phone = $request->input('phone');
        $trainee->password = Hash::make($request->input('password'));
        $trainee->token = \Str::random(60).time();
        $trainee->expired_at = $date->add(new DateInterval('PT24H00S'));

        if($trainee->save()){
            //  EVENT TRIGGERED
            // event(new NewUserRegisteredEvent($trainee,'trainee'));
            // NOW SAVE DATA TO TBL_USER_HISTORY TABLE
            if($request->input('weight')){
                $history = new UserHistory();
                $history->weight = $request->input('weight');
                $history->body_fat_percentage = $request->input('fat');
                $history->user_id = $trainee->id;
                $history->save();
            }
            

            // NOW SAVE DATA TO TBLE_USER_EQUIPMENT TABLE
            if($request->equipment){
                $arr = $request->equipment;
                foreach($arr as $val){
                    if($val['is_available'] == 1){
                        $equipment = new UserEquipment();
                        $equipment->user_id = $trainee->id;
                        $equipment->equipment_id = $val['id'];
                        // $equipment->is_available = $val['is_available'];
                        $equipment->save();
                    }
                    
                }
            }
        }
        session(['user' => $trainee,'user_type'=>'trainee']);
        return redirect()->route('traineeCalendar.view')->with('message','Welcome to trainee dashboard');
    
    }

    public function verificationview(Request $request){
        !$request->token ? $token='' : $token=$request->token;
        return view('auth.verification')->with('token',$token);
    }

    public function verification(Request $request){

        !$request->token ? $token='' : $token=$request->token;

        // FIND OUT THE VALIDATE USER
        // FIND OUT THE TOKEN AND EXPIRATION DATE
        // IF FOUND UPDATE THE VERIFIED STATUS

        if($request->type === 'trainee'){
            $user = Trainee::where('token',$request->token)->first();
        }

        if($request->type === 'trainer'){
            $user = Trainer::where('token',$request->token)->first();
        }

        if($user){
            $end= new Carbon($user->expired_at);
            $start = Carbon::now();
            $totalDuration = $end->diffInHours($start,false); 

            if($totalDuration < 0){
                $user->is_verified = 1;
                $user->updated_at = date('Y-m-d H:i:s');
                $user->save();
            }else{
                // token expired 
                 dd(' Token expiredß ');
            }
        }else{
            dd(' User and Token not found ');
        }
        if($request->type === 'trainee'){
            return view('auth.update_trainee')->with('user',$user)->with('equipment',Equipment::get())->with('token',$token)->with('type',$request->type);

        }
        if($request->type === 'trainer'){
            return view('auth.update_trainer')->with('user',$user)->with('equipment',Equipment::get())->with('token',$token)->with('type',$request->type);
        }

    }

    public function signupTrainer(){
                 session(['tp' => 'trainer']);

        return view('auth.signup_trainer')->with('equipment',Equipment::get());
    }
    public function signupTrainerSubmit(Request $request){

        $validateData = $request->validate([
            'email' => 'required',
            // 'password' => 'required',
        ]);

        $date= new DateTime();
        $trainer = new Trainer();

        $trainer->email = $request->input('email');
        
        $trainer->token = \Str::random(60).time();
        $trainer->expired_at = $date->add(new DateInterval('PT24H00S'));
        
        if($trainer->save()){
            //  EVENT TRIGGERED
            event(new NewUserRegisteredEvent($trainer,'trainer'));
           
        }
                 session(['tp' => '']);

        return redirect()->route('signup.verificationview');

    }

    public function signupTrainerUpdate(Request $request){

        $validateData = $request->validate([
            'email' => 'required',
            // 'password' => 'required',
        ]);

        $date= new DateTime();
        $trainer = Trainer::find($request->user_id);

        $trainer->first_name = $request->input('first_name');
        $trainer->first_phonetic = $request->input('first_phonetic');

        $trainer->family_name = $request->input('family_name');
        $trainer->family_phonetic = $request->input('family_phonetic');
        
        $trainer->email = $request->input('email');
        $trainer->prefecture = $request->input('prefecture');

        $trainer->password = Hash::make($request->input('password'));
        $trainer->address_line = $request->input('address');
        $trainer->zip_code = $request->input('zip_code');
        $trainer->city = $request->input('city');
        $trainer->phone = $request->input('phone');
        $trainer->intro = $request->input('intro');
        $trainer->photo_path = $request->input('photo_path');
        $trainer->unit_price = $request->input('unit_price');
        $trainer->certification = $request->input('certification');
        $trainer->interface = $request->input('interface');


        $trainer->token = \Str::random(60).time();
        $trainer->expired_at = $date->add(new DateInterval('PT24H00S'));
        
        if($trainer->save()){
            //  EVENT TRIGGERED
            // NOW SAVE DATA TO TBL_USER_HISTORY TABLE
            // if($request->input('weight')){
            //     $history = new UserHistory();
            //     $history->weight = $request->input('weight');
            //     $history->body_fat_percentage = $request->input('fat');
            //     $history->user_id = $trainer->id;
            //     $history->save();
            // }
            

            // NOW SAVE DATA TO TBLE_USER_EQUIPMENT TABLE
            if($request->equipment){
                $arr = $request->equipment;
                foreach($arr as $val){
                    if($val['is_available'] == 1){
                        $equipment = new TrainerEquipment();
                        $equipment->trainer_id = $trainer->id;
                        $equipment->equipment_id = $val['id'];
                        $equipment->save();
                    }
                    
                }
            }
        }

        session(['user' => $trainer,'user_type'=>'trainee']);
        return redirect()->route('trainerCalendar.view')->with('message','Welcome to trainer dashboard');
    

    }
    public function tokenVerifySubmit(Request $request ){

        $validateData = $request->validate([

            'email' => 'email',
            // 'name' => 'required',
            'password' => 'required|confirmed|min:6',
            // 'weight' => 'required',
            // 'fat' => 'required',
        ]);

        if($request->type == 'trainee'){
            $user = Trainee::where('token',$request->token)->first();
        }
        if($request->type == 'trainer'){
            $user = Trainer::where('token',$request->token)->first();
        }

        if(!$user){
                    return redirect()->back()->with('message','Token or user not found');
        }else{

        $user->password = Hash::make($request->input('password'));
        $user->is_verified = 1;
        $user->save();

        if($request->type == 'trainer'){

         session(['user' => $user,'user_type'=>'trainer']);
        return redirect()->route('trainerCalendar.view')->with('message','Welcome to trainer dashboard');
        }


       if($request->type == 'trainee'){
         session(['user' => $user,'user_type'=>'trainee']);
        return redirect()->route('traineeCalendar.view')->with('message','Welcome to trainer dashboard');
        }
    }


    }
    public function tokenVerify(Request $request){

        $token=$request->token;
        $type = $request->type;

        return view('auth.token_password_set')->with('type',$type)->with('token',$token);

    }
    public function tokenReset(Request $request){
        return view('auth.token_reset')->with('type',$request->type);
    }
    public function tokenResetSubmit(Request $request){

        $validateData = $request->validate([
            'email' => 'required',
            // 'password' => 'required',
        ]);


       
        $email = $request->input('email');

        if($request->input('type') === 'trainee'){
            $user = Trainee::where('email',$email)->where('is_verified',1)->first();
        }

         if($request->type == 'trainer '){
            $user = Trainer::where('email',$email)->where('is_verified',1)->first();
        }

        
        if(!$user){
                    return redirect()->back()->with('message','User email address is not verified');

        }else{

            $date= new DateTime();
            $new_time =  $date->add(new DateInterval('PT24H00S'));
            // dd($new_time);
            $user->is_verified = 2;
            $user->token = \Str::random(60).time();
            $user->expired_at = $new_time;
            $user->save();

            $details['name'] =  $user->name;
            $details['token'] =  $user->token;
            $details['type'] =  $request->type ;

            \Mail::to($user->email)->send(new \App\Mail\ForgetEmailController($details));

            return redirect()->back()->with('message','A password link is set to your email address');
        }
        
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