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
use Illuminate\Support\Facades\Crypt;

use DateTime;
use DateInterval;



class SignupController extends Controller
{
    public function index(){
        
    }
    public function googleuser(Request $request){

            $data = Crypt::decrypt($request->param);

       if($data['type'] == 'trainee'){
            $user = Trainee::find($data['id']);

            if($user->password != NULL){
                    session(['user' => $user,'user_type'=>'trainee','message'=>'ログインに成功しました。']);
            return redirect()->route('traineeCalendar.view')->with('message','ログインに成功しました。');
            }
           

            return view('auth.update_trainee')->with('user',$user)->with('equipment',Equipment::get())->with('token','1234')->with('type','trainee');            

        }
        if($data['type'] == 'trainer'){
            $user = Trainer::find($data['id']);

            if($user->password != NULL){
              
                 session(['user' => $user,'user_type'=>'trainer','message'=>'ログインに成功しました。']);
            return redirect()->route('calendar.view','month')->with('message','ログインに成功しました。');
            }
           

            return view('auth.update_trainer')->with('user',$user)->with('equipment',Equipment::get())->with('token','1234')->with('type','trainer');
        }
    }
    public function signupTrainee(){
         session(['tp' => 'trainee']);
        return view('auth.signup_trainee')->with('equipment',Equipment::get());
    }
    public function signupTraineeSubmit(Request $request){

        // dd($request->equipment);
        // dd(route('signup.verification',$request->_token));
        $validateData = $request->validate([

            'email' => 'required|email|unique:tbl_users,email',
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

        // $trainee->sex = $request->input('sex');
        // $trainee->dob = $request->input('birthday');
        // $trainee->length = $request->input('height');

        $trainee->phonetic = $request->input('phonetic');
        $trainee->email = $request->input('email');
        // $trainee->address = $request->input('address');
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
        return view('auth.branch')->with('message','ユーザーダッシュボードへようこそ');
    
    }

    public function verificationview(Request $request){
        !$request->token ? $token='' : $token=$request->token;
        return view('auth.verification')->with('token',$token);
    }

    // registration verification link submit 
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
                 dd(' Token expired ');
            }
        }else{
            dd(' User and Token not found ');
        }
        if($request->type === 'trainee'){
            // is verified successfull mail

            $details['url'] =  route('traineeLogin') ;

             // \Mail::to($user->email)->send(new \App\Mail\RegistrationVerificationSuccess($details));

            return view('auth.update_trainee')->with('user',$user)->with('equipment',Equipment::get())->with('token',$token)->with('type',$request->type);

        }
        if($request->type === 'trainer'){

            $details['url'] =  route('trainerLogin') ;

             //\Mail::to($user->email)->send(new \App\Mail\RegistrationVerificationSuccess($details));

            return view('auth.update_trainer')->with('user',$user)->with('equipment',Equipment::get())->with('token',$token)->with('type',$request->type);
        }

    }

    public function signupTrainer(){
                 session(['tp' => 'trainer']);

        return view('auth.signup_trainer')->with('equipment',Equipment::get());
    }
    public function signupTrainerSubmit(Request $request){

        $validateData = $request->validate([
            'email' => 'required|email|unique:tbl_trainers,email',
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
            'first_name' => 'required|max:150',
            'password' => 'required|confirmed|min:6',
            'sex' => 'required',

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
        $trainer->zip_code = $request->input('postcode1')."_".$request->input('postcode2');
        $trainer->city = $request->input('city');
        $trainer->phone = $request->input('phone');
        $trainer->intro = $request->input('intro');
        $trainer->photo_path = $request->input('photo_path');
        $trainer->unit_price = $request->input('unit_price');
        $trainer->certification = $request->input('certification');
        $trainer->interface = $request->input('interface');
         if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = rand(1, 9000).strtotime("now");
                $file->move(public_path() . '/images/', $filename . '_trainer_image' . '.' . $file->getClientOriginalExtension());
                $path = $filename . '_trainer_image' . '.' . $file->getClientOriginalExtension();
                $imgfullPath = $path;
                $trainer->photo_path = $imgfullPath;
            }

        $trainer->token = \Str::random(60).time();
        $trainer->expired_at = $date->add(new DateInterval('PT24H00S'));

        $trainer->sex = $request->input('sex');
        $evaluation = json_decode($request->total,true);
        if(isset($evaluation)){
            $trainer->self_evaluation = $evaluation;
        }

        if(isset($request->instruction)){
                $trainer->instructions=serialize($request->instruction);
        }

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

        
        session(['user' => $trainer,'user_type'=>'trainer','message'=>'ログインに成功しました。']);
            return redirect()->route('calendar.view','month')->with('message','ログインに成功しました。');
    

    }
    
   

    // forget password //
    // forget password //
    // forget password //

    public function tokenReset(Request $request){ // forget password view
        return view('auth.forget_password')->with('type',$request->type);
    }
    public function tokenResetSubmit(Request $request){ // forget password email form submit

        $validateData = $request->validate([
            'email' => 'required',
            // 'password' => 'required',
        ]);


       
        $email = $request->input('email');

        if($request->input('type') === 'trainee'){
            $user = Trainee::where('email',$email)->where('is_verified','!=',0)->first();
        }

         if($request->type == 'trainer'){
            
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

            return redirect()->back()->with('message','パスワードリセットリンクがあなたのメールアドレスに送信されます');
        }
        
    }

    // forget password verification link with new password form view 
     public function tokenVerify(Request $request){
        $token=$request->token;
        $type = $request->type;

        $user = Trainee::where('token',$request->token)->first();
        $end= new Carbon($user->expired_at);
        $start = Carbon::now();
        $totalDuration = $end->diffInHours($start,false); 

        if($totalDuration >= 0){
            return redirect()->route('forgetPassword',$request->type)->with('message','Token expired');
        }
       

        return view('auth.forget_password_submit')->with('type',$type)->with('token',$token);

    }

    // forget password verification link with new password submit
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

            $end= new Carbon($user->expired_at);
            $start = Carbon::now();
            $totalDuration = $end->diffInHours($start,false); 

            if($totalDuration > 0){
                return redirect()->back()->with('message','Token expired');
            }


            $user->password = Hash::make($request->input('password'));
            $user->is_verified = 1;
            $user->save();


            if($request->type == 'trainer'){

                $details['url'] =  route('trainerLogin') ;
                \Mail::to($user->email)->send(new \App\Mail\ForgetPasswordSuccess($details));

                session(['user' => $user,'user_type'=>'trainer']);
                return redirect()->route('calendar.view','month')->with('message','トレーナーダッシュボードへようこそ');
            }


            if($request->type == 'trainee'){

                $details['url'] =  route('traineeLogin') ;
                \Mail::to($user->email)->send(new \App\Mail\ForgetPasswordSuccess($details));

                session(['user' => $user,'user_type'=>'trainee']);
                return redirect()->route('traineeCalendar.view')->with('message','ユーザーダッシュボードへようこそ');
            }
        }
    }

    // public function tokenResetTrainee(){
    //     return view('auth.token_reset_trainee');
    // }
    // public function tokenResetSubmitTrainee(Request $request){
    //     $validateData = $request->validate([
    //         'email' => 'required',
    //         // 'password' => 'required',
    //     ]);
    //     $email = $request->input('email');
    //     $trainee = Trainee::where('email',$email)->first();
    //     $date= new DateTime();
    //     $new_time =  $date->add(new DateInterval('PT24H00S'));
    //     $trainee->expired_at = $new_time;
    //     $trainee->save();
    //     return redirect()->back()->with('message','Token expired time reset!');
    // }

    public function inquery(){
        return view('pages.inquery');
    }

}