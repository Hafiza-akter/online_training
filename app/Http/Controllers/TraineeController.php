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
use App\Model\UserEquipment;
use App\Model\UserHistory;
use App\Model\TrainerSchedule;
use App\Model\UserPlanPurchase;
use App\Model\PlanPurchase;


use DateTime;
use DateInterval;

class TraineeController extends Controller
{
    public $RECURSIVE=array();
    public $counter=0;

    public function traineeView(){
        return view('pages.trainer_details');
    }
    public function physicaldata(Request $request){
            $user = Trainee::find(Session::get('user.id'));

            return view('auth.physical_data')->with('user',$user)->with('equipment',Equipment::get());

    }

    public function physicaldatasubmit(Request $request){

       $validateData = $request->validate([

            'weight' => 'required',
            // 'fat' => 'required',
            'sex' => 'required',
            'birthday' => 'required',
            'height' => 'required',
        ]);

        $date= new DateTime();
        $trainee = Trainee::find($request->user_id);

        $trainee->sex = $request->input('sex');
        $trainee->dob = $request->input('birthday');
        $trainee->length = $request->input('height');
        $trainee->weight = $request->input('weight');
        if($request->input('pal') === 'high'){
             $trainee->pal =2;
        }
        if($request->input('pal') === 'low'){
             $trainee->pal= 1.55;

        }   
        if($request->input('pal') === 'medium'){
             $trainee->pal =1.75;

        }
        


        if($trainee->save()){
            //  EVENT TRIGGERED
            // event(new NewUserRegisteredEvent($trainee,'trainee'));
            // NOW SAVE DATA TO TBL_USER_HISTORY TABLE
            // if($request->input('weight')){
            //     $timing=$this->morningOrEvening();
            //     $history = new UserHistory();

            //     $history->weight_morning = ($timing== 'morning') ? $request->input('weight') : '' ;
            //     $history->weight_evening = ($timing== 'evening') ? $request->input('weight') : '' ;

            //     $history->body_fat_percentage_morning = ($timing== 'morning') ? $request->input('fat') : '' ;
            //     $history->body_fat_percentage_evening = ($timing== 'evening') ? $request->input('fat') : '' ;

            //     // $history->calory_gained = $request->input('weight');
            //     // $history->calory_consumed = $request->input('weight');

            //     $history->recorded_at = date('Y-m-d H:i:s');
            //     $history->user_id = $trainee->id;
            //     $history->save();
            // }
            
        }
                    return redirect()->route('purchaseplan')->with('message','Physical information added successfully');

    }
    public function morningOrEvening(){
            /* This sets the $time variable to the current hour in the 24 hour clock format */
        $time = date("H");
        /* Set the $timezone variable to become the current timezone */
        $timezone = date("e");
        /* If the time is less than 1200 hours, show good morning */
        if ($time < "12") {
            return "morning";
        } else
        /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
        if ($time >= "12" && $time < "17") {
            return "evening";
        } else
        /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
        if ($time >= "17" && $time < "19") {
            return "evening";
        } else
        /* Finally, show good night if the time is greater than or equal to 1900 hours */
        if ($time >= "19") {
            return "evening";
        }
    }
    public function scheduleCalendar(Request $request){ // calendar view
        // return view('auth.branch');
        $user_id = Session::get('user.id');
        $user = \App\Model\User::where('id',$user_id)->get()->first();
        // branch page 
        if($user->dob == null){
            return view('auth.branch');
        }
        //
        $puchasePlan = UserPlanPurchase::where('user_id',Session::get('user.id'))->get()->first();
        
        $datePlan = Carbon::parse($puchasePlan->created_at);
       

        $isActive = "schedule";
        if($request->trainer_id){

            $schedule =TrainerSchedule::where('trainer_id',$request->trainer_id)->get();
                $parsedArray = array();
                if($schedule){
                    foreach ($schedule as $key => $value) {
                    $parsedArray[$key]['start'] = $value->date;
                    $parsedArray[$key]['allDay'] = true;
                    $parsedArray[$key]['display'] = 'background';

                   

                        $now = Carbon::parse($value->date);

                        $diff = $datePlan->diffInDays($now);

                        $allTraingingArray = \Config::get('statics.'.$puchasePlan->purchase_plan_id.'day_per_week');
                        if (!in_array($diff, $allTraingingArray)) {
                            $parsedArray[$key]['color'] = 'grey';
                        }else{
                            if($value->user_id == Session::get('user')->id){
                                $parsedArray[$key]['color'] = 'red';

                            }else{
                                $parsedArray[$key]['color'] = 'blue';

                            }
                        }

                    }
                }
        }else{

              $schedule =TrainerSchedule::where('user_id',Session::get('user')->id)->select('date as start_date')->get();
                $parsedArray = array();
                if($schedule){
                    foreach ($schedule as $key => $value) {
                    $parsedArray[$key]['start'] = $value->start_date;
                    $parsedArray[$key]['allDay'] = true;
                    $parsedArray[$key]['display'] = 'background';
                    $parsedArray[$key]['color'] = 'red';

                    }
                }
        }
    	

        $listSchedule =TrainerSchedule::where('user_id',Session::get('user')->id)->select('id','date as start_date','is_occupied','trainer_id','time','user_id')->get();
    	return view('pages.trainee.calendar')->with('isActive',$isActive)->with('schedule',json_encode($parsedArray,true))->with('listSchedule',$listSchedule);
    
    }
    public function scheduleCalendarSubmit(Request $request){ // when calendar date submit
        
        // dd($request->all());
    	// time 
        $puchasePlan = UserPlanPurchase::where('user_id',Session::get('user.id'))->get()->first();
        
        if(!$puchasePlan){
            return redirect()->route('purchaseplan')->with('message','Please purchase your plan first !');
        }

        $date = Carbon::parse(date('Y-m-d', strtotime($puchasePlan->created_at)));
        $now = Carbon::parse($request->selected_date);

        $diff = $date->diffInDays($now);

        // dd($diff);
        $allTraingingArray = \Config::get('statics.'.$puchasePlan->purchase_plan_id.'day_per_week');
        if (!in_array($diff, $allTraingingArray)) {
            return redirect()->back()->with('errors_m','Your purchase plan does not support this day as a training day. ');
        }

        if($request->trainer_id){
            $time =TrainerSchedule::where('date',$request->selected_date)->where('trainer_id',$request->trainer_id)->get();
        }else{

            $time =TrainerSchedule::where('date',$request->selected_date)->where('user_id',Session::get('user.id'))->get();

            if(count($time) == 0){

                $trainerId = TrainerSchedule::where('date',$request->selected_date)->select('trainer_id')->groupBy('trainer_id')->get();

                $trainerList = array();
                if(($trainerId)){
                    foreach($trainerId as $key=>$val){
                        $trainerList[$key] = Trainer::find($val->trainer_id);
                    }
                }
                // dd($trainerList);
                return view('pages.trainee.trainerlist')->with('trainerList',$trainerList);
            }
        }
    	

    	return view('pages.trainee.time')
    	->with('selected_date',$request->selected_date)
    	->with('time',$time);
    }
    
    public function scheduleTime(Request $request){

    	$time =TrainerSchedule::where('date',$request->selected_date)->get();
    	return view('pages.trainee.time')
    	->with('selected_date',$request->selected_date)
    	->with('time',$time);

    }

    public function scheduleSubmit(Request $request){

    	// $arrT=explode('-',$request->start_time);
     //    $time= new Carbon($arrT[0]);
    	// $ftime = $time->format('H:i:s');
    	// $ftime = $arrT[0];

        if($request->schedule_id){
            $schedule = TrainerSchedule::find($request->schedule_id);
            $schedule->user_id=$request->user_id;
            $schedule->is_occupied=1;
            $schedule->save();
        }else{
            $schedule = new TrainerSchedule();
            $schedule->date =$request->date;
            $schedule->trainer_id =$request->trainer_id;
            $schedule->time =$request->start_time.':00:00';
            $schedule->save(); 
        }
    	
    	return redirect()->route('traineeTime.view',$request->date)
    	->with('message','Schedule time set succesfully')
    	->with('selected_date',$request->date);

    }

    public function trainerlist(){
        $trainerList = Trainer::get();
        return view('pages.trainee.trainerlist')->with('trainerList',$trainerList);
    }

    public function logout(){
        session()->flush();
        return redirect()->route('traineeLogin');
    }
    public function purchaseplan(Request $request){

        // calculation test //
        $user_id = Session::get('user.id');
        $user = \App\Model\User::where('id',$user_id)->get()->first();

        if($user->phone === null || $user->address === null){
            return redirect()->route('traininginfo')->with('success','Please input traininginfo first');
        }
        $bmrData = BMRcalculation($user->weight);
       
        $weight = $user->weight;

        $totalDay=90;
        $start=1;
        $pal=$user->pal;
        $type=1;
        $dataset = $this->calculation($bmrData,$weight,$pal,$totalDay,$start,$type);
            // dd($dataset);
        $userPurchasePlan=UserPlanPurchase::where('user_id',Session::get('user.id'))->first();
        $isactive='purchase';
        $purchase=PlanPurchase::where('status',1)->get();
        $plan=PlanPurchase::where('id',1)->get()->first();
        $purchasePlaneList=UserPlanPurchase::where('user_id',Session::get('user.id'))->get();

        return view('pages.trainee.purchase_details')
        ->with('dataset',$dataset)
        ->with('purchase',$purchase)
        ->with('plan',$plan)
        ->with('isActive',$isactive)
        ->with('userPurchasePlan',$userPurchasePlan)
        ->with('bmrData',$bmrData)
        ->with('purchasePlaneList',$purchasePlaneList)
        ->with('user',$user);

    }
    public function number_formate($data){
            return number_format((float)$data, 2, '.', '');  // Outputs -> 105.00
    }

    // purchase calculation and ajax call
    // purchase calculation and ajax call
    public function purchaseajaxcall(Request $request){
        $bmrData=$request->bmrData;
        $totalDay=$request->totalday;
        $start=$request->startday;
        $pal=$request->pal;
        $type=1;
        $weight=$request->weight;
        return  $this->calculation($bmrData,$weight,$pal,$totalDay,$start,$type);
    }
    public function calculation($bmrData,$weight,$pal,$totalDay,$start,$type){

        $bmrData=$bmrData;
        $totalDay=$totalDay;
        $start=$start;
        $pal=$pal;
        $type=$type;
        

        $this->repeatedFunction($bmrData,$weight,$pal,$totalDay,'1day_per_week',$start,$counter=0,$type);
        $this->repeatedFunction($bmrData,$weight,$pal,$totalDay,'2day_per_week',$start,$counter=0,$type);
        $this->repeatedFunction($bmrData,$weight,$pal,$totalDay,'3day_per_week',$start,$counter=0,$type);
        $weightData = $this->RECURSIVE;
        // dd($weightData);
        $dataset=array();

        // for graph in purchae plan
        $dataset[0]=array(
                    'data' => array($weight,
                                    $this->number_formate($weightData['1day_per_week'][29]['weight']),
                                    $this->number_formate($weightData['1day_per_week'][59]['weight']),
                                    $this->number_formate($weightData['1day_per_week'][89]['weight'])
                                ),
                        'label'=> "1 day per week",
                        'borderColor'=> "#6d93ff",
                        'fill'=> false
                    );

        $dataset[1]=array(
                        'data' => array($weight,
                                    $this->number_formate($weightData['2day_per_week'][29]['weight']),
                                    $this->number_formate($weightData['2day_per_week'][59]['weight']),
                                    $this->number_formate($weightData['2day_per_week'][89]['weight'])
                                ),
                        'label'=> "2 day per week",
                        'borderColor'=> "green",
                        'fill'=> false
                    );

        $dataset[2]=array(
                        'data' => array($weight,
                                    $this->number_formate($weightData['3day_per_week'][29]['weight']),
                                    $this->number_formate($weightData['3day_per_week'][59]['weight']),
                                    $this->number_formate($weightData['3day_per_week'][89]['weight'])
                                ),
                        'label'=> "3 day per week",
                        'borderColor'=> "yellow",
                        'fill'=> false
                    );
            return json_encode($dataset,true);


    }

    public function repeatedFunction($bmrData,$weight,$pal,$totalday,$trainingType,$start,$counter,$type){

    
        if ($totalday === 0){
            return $this->RECURSIVE;
        }else{

            $weightBalance = weight_balance($bmrData,$pal,$weight,$start,$trainingType);
            $weight = $weight+$type*$weightBalance;
            $this->RECURSIVE[$trainingType][$counter]['plan_type']=$trainingType;
            $this->RECURSIVE[$trainingType][$counter]['weight']=$weight;
            $this->RECURSIVE[$trainingType][$counter]['weightBalance']=$weightBalance;
            $this->RECURSIVE[$trainingType][$counter]['bmr']=$bmrData;
            $this->RECURSIVE[$trainingType][$counter]['pal']=$pal;
        }   
        $this->counter++;
        $this->repeatedFunction($bmrData,$weight,$pal,($totalday-1),$trainingType,$start+1,$counter+1,$type); 
    }


    // public function dayKg($weight,$pal){

        // $rt = $this->repeatedFunction($weight,$pal,13);
        // return $rt;
        // dd($this->RECURSIVE);

        // $returnArray=array();

        // for($i=1;$i<30;$i++){
        //     $returnArray[$i] = $this->repeatedFunction($weight,$pal);
        // }

        // dd($returnArray);
        // $factor=1;
        // $monthCounter=1;
        // for($i=0;$i<3;$i++){
        //     $returnArray[$i]['label']='';
        //     $returnArray[$i]['borderColor']='#6d93ff';
        //     $returnArray[$i]['fill']=false;

        //     for($j=0;$j<=3;$j++){
                
        //         if($j==0){
        //             $returnArray[$i]['data'][$j]=$weight;
        //         }else{

        //             $returnArray[$i]['data'][$j]=($weight+($weightBalance*30*$j*$factor));
        //             $monthCounter++;
        //         }
        //     }
        //     $factor++;

        //     // $weight 
        //     // $weight 
        //     // $weight 

        //     // $weight + $weightBalance*30*1;
        //     // $weight + $weightBalance*60*1;
        //     // $weight + $weightBalance*90*1;

        //     // $weight + $weightBalance*30*2;
        //     // $weight + $weightBalance*60*2;
        //     // $weight + $weightBalance*90*2;

        //     // $weight + $weightBalance*30*3;
        //     // $weight + $weightBalance*60*3;
        //     // $weight + $weightBalance*90*3;
        // }
        // return ($returnArray);
        // // one times a week 
        // $oneMonth = ($weight + (30*$weightBalance)) * 1;
        // $twoMonth = ($weight + (2*30*$weightBalance)) * 1;
        // $threeMonth = ($weight + (3*30*$weightBalance)) * 1;

        // // two times a week
        // $oneMonth = ($weight + (30*$weightBalance)) * 2;
        // $twoMonth = ($weight + (2*30*$weightBalance)) * 2;
        // $threeMonth = ($weight + (3*30*$weightBalance)) * 2;
        // // three times a week
        // $oneMonth = ($weight + (30*$weightBalance)) * 3;
        // $twoMonth = ($weight + (2*30*$weightBalance)) * 3;
        // $threeMonth = ($weight + (3*30*$weightBalance)) * 3;

    //     [
    //   { 
    //     data: [70,68,60,50],
    //     label: "",
    //     borderColor: "#6d93ff",
    //     fill: false
    //   }, 
    //   { 
    //     data: [70,67,59,55],
    //     label: "",
    //     borderColor: "green",
    //     fill: false
    //   },
    //   { 
    //     data: [70,60,55,50],
    //     label: "",
    //     borderColor: "yellow",
    //     fill: false
    //   }, 
    
    // ]

    public function purchasedetails(Request $request){
        $userPurchasePlan=UserPlanPurchase::where('user_id',Session::get('user.id'))->first();
        $isactive='purchase';
        $purchase=PlanPurchase::where('status',1)->get();
        $plan=PlanPurchase::where('id',$request->id)->get()->first();
        return view('pages.trainee.purchase_details')->with('purchase',$purchase)->with('plan',$plan)->with('isActive',$isactive)->with('userPurchasePlan',$userPurchasePlan);

    }
    public function psettings(Request $request){

        $user = Trainee::where('id',Session::get('user.id'))->first();

        return view('pages.trainee.p-settings')
        ->with('user',$user)
        ->with('equipment',Equipment::get())->with('isActive','p-settings');

    }
    public function psettingsSubmit(Request $request){



        if($request->action_type == 'password_update'){

        $validateData = $request->validate([

            // 'name' => 'required',
            'password' => 'required|confirmed|min:6',
            // 'weight' => 'required',
            // 'fat' => 'required',
        ]);

            $trainee = Trainee::find($request->user_id);
            if( (!Hash::check($request->input('oldpassword'),$trainee->password))){
                return redirect()->back()->with('message','Your Previous Password did not match');
            }

            $trainee->password = Hash::make($request->input('password'));

            $trainee->save();
            return redirect()->back()
            ->with('success','Password update succesfully');
        }
        if($request->action_type == 'info_update'){

            $trainee = Trainee::find($request->user_id);
            $trainee->name = $request->input('name');

            $trainee->sex = $request->input('sex');
            $trainee->dob = $request->input('birthday');
            $trainee->length = $request->input('height');

            $trainee->phonetic = $request->input('phonetic');
            $trainee->address = $request->input('address');
            $trainee->phone = $request->input('phone');

            if($trainee->save()){
                //  EVENT TRIGGERED
                // event(new NewUserRegisteredEvent($trainee,'trainee'));
                // NOW SAVE DATA TO TBL_USER_HISTORY TABLE

                

                // NOW SAVE DATA TO TBLE_USER_EQUIPMENT TABLE
                        if($request->equipment){
                $arr = $request->equipment;
                foreach($arr as $val){
                    if($val['is_available'] == 1){

                       $dataExist= UserEquipment::where('user_id',$trainee->id)
                            ->where('equipment_id',$val['id'])->get()->first();

                        if(!$dataExist){
                            $equipment = new UserEquipment();
                            $equipment->user_id = $trainee->id;
                            $equipment->equipment_id = $val['id'];
                            // $equipment->is_available = $val['is_available'];
                            $equipment->save();
                        }    
                        
                    }else{

                        $dataExist= UserEquipment::where('user_id',$trainee->id)
                            ->where('equipment_id',$val['id'])->delete();
                    }
                    
                }
            }
            }
            return redirect()->back()
            ->with('success','Profile update succesfully');
        }
        

    }
    public function traininginfo(Request $request){
            $user = Trainee::find(Session::get('user.id'));
            $equipment = Equipment::get();
          
            $userEquipment = UserEquipment::where('user_id',$user->id)->get();
            return view('auth.traininginfo')->with('user',$user)->with('equipment',$equipment)->with('userEquipment',$userEquipment);
    }
    public function traininginfosubmit(Request $request){
        $validateData = $request->validate([

            'phone' => 'required',
            'address' => 'required',
          
        ]);

        $date= new DateTime();
        $trainee = Trainee::find($request->user_id);

        $trainee->address = $request->input('address');
        $trainee->phone = $request->input('phone');

        if($trainee->save()){
             // NOW SAVE DATA TO TBLE_USER_EQUIPMENT TABLE
            if($request->equipment){
                $arr = $request->equipment;
                foreach($arr as $val){
                    if($val['is_available'] == 1){

                       $dataExist= UserEquipment::where('user_id',$trainee->id)
                            ->where('equipment_id',$val['id'])->get()->first();

                        if(!$dataExist){
                            $equipment = new UserEquipment();
                            $equipment->user_id = $trainee->id;
                            $equipment->equipment_id = $val['id'];
                            // $equipment->is_available = $val['is_available'];
                            $equipment->save();
                        }    
                        
                    }else{

                        $dataExist= UserEquipment::where('user_id',$trainee->id)
                            ->where('equipment_id',$val['id'])->delete();
                    }
                    
                }
            }
        }
                    return redirect()->route('purchaseplan')->with('success','Training information added successfully');
    }
    
    public function dailydata(Request $request){
         // calculation test //

        $user_id = Session::get('user.id');
        $user = \App\Model\User::where('id',$user_id)->get()->first();
        $isactive='dailydata';

        return view('pages.trainee.daily_data')
        ->with('isActive',$isactive)
        ->with('user',$user);
    }
    public function dailydataSubmit(Request $request){
            $validateData = $request->validate([

                'weight' => 'required',
                'fat' => 'required',
                'calory_gained' => 'required',
                'consumed_calory' => 'required',
            ]);
            $date = date('Y-m-d');

            $timing=$this->morningOrEvening();
            $todayData = UserHistory::whereDate('created_at',$date)->where('user_id',$request->user_id)->get()->first();

            if($todayData){
                 $history = UserHistory::find($todayData->id);
                 $msg = "Data updated succesfully!";

            }else{
                 $history = new UserHistory();
                 $msg = "Data inserted succesfully!";
            }
           

            $history->weight_morning = ($timing== 'morning') ? $request->input('weight') : '' ;
            $history->weight_evening = ($timing== 'evening') ? $request->input('weight') : '' ;

            $history->body_fat_percentage_morning = ($timing== 'morning') ? $request->input('fat') : '' ;
            $history->body_fat_percentage_evening = ($timing== 'evening') ? $request->input('fat') : '' ;

            $history->calory_gained = $request->input('calory_gained');
            $history->calory_consumed = $request->input('consumed_calory');

            $history->recorded_at = date('Y-m-d H:i:s');
            $history->user_id = $request->user_id;
            $history->save();

            return redirect()->back()->with('success',$msg);

    }   

public function progress(){
         // calculation test //
        $user_id = Session::get('user.id');
        $user = \App\Model\User::where('id',$user_id)->get()->first();

        $bmrData = BMRcalculation($user->weight);
        // dd($bmrData);
       
        $weight = $user->weight;

        $totalDay=7;
        $start=1;
        $pal=1.75;
        $type=1;
        $dataset = $this->calculation2($bmrData,$weight,$pal,$totalDay,$start,$type);


        $userPurchasePlan=UserPlanPurchase::where('user_id',Session::get('user.id'))->first();
        $isactive='progress';
        $purchase=PlanPurchase::where('status',1)->get();
        $plan=PlanPurchase::where('id',1)->get()->first();
        return view('pages.trainee.progress')
        ->with('dataset',$dataset)
        ->with('purchase',$purchase)
        ->with('plan',$plan)
        ->with('isActive',$isactive)
        ->with('userPurchasePlan',$userPurchasePlan)
        ->with('bmrData',$bmrData)
        ->with('user',$user);
    }
    // user acheivement calculation and ajax call
    // user acheivement calculation and ajax call

    public function acheivementjaxcall(Request $request){
        $bmrData=$request->bmrData;
        $totalDay=$request->totalday;
        $start=$request->startday;
        $pal=$request->pal;
        $type=$request->type;
        $weight=$request->weight;
        return  $this->calculation($bmrData,$weight,$pal,$totalDay,$start,$type);
    }
    public function calculation2($bmrData,$weight,$pal,$totalDay,$start,$type){

        $bmrData=$bmrData;
        $totalDay=$totalDay;
        $start=$start;
        $pal=$pal;
        $type=$type;
        

        $this->repeatedFunction2($bmrData,$weight,$pal,$totalDay,$type,$start,$counter=0,$type);
        $weightData = $this->RECURSIVE;
        // dd($weightData);
        $dataset=array();

        // for graph in purchae plan

        $datasetArray = array();
        $lebel = array();
        for($i=0;$i<$totalDay;$i++){
            
            if($i == 0){
                $datasetArray[$i] =$weight;
            }else{
                $datasetArray[$i]=$this->number_formate($weightData[$type][$i]['weight']);
            }
          
            
        }

        $dataset[0]=array(
                    'lebel' => $datasetArray,
                    'data' => $datasetArray,
                    'label'=> "1 day per week",
                    'borderColor'=> "#6d93ff",
                    'fill'=> false
                );

    
        return json_encode($dataset,true);


    }

    public function repeatedFunction2($bmrData,$weight,$pal,$totalday,$trainingType,$start,$counter,$type){

    
        if ($totalday === 0){
            return $this->RECURSIVE;
        }else{

            $weightBalance = weight_balance($bmrData,$pal,$weight,$start,$trainingType);
            $weight = $weight+$type*$weightBalance;
            $this->RECURSIVE[$trainingType][$counter]['plan_type']=$trainingType;
            $this->RECURSIVE[$trainingType][$counter]['weight']=$weight;
            $this->RECURSIVE[$trainingType][$counter]['weightBalance']=$weightBalance;
            $this->RECURSIVE[$trainingType][$counter]['bmr']=$bmrData;
            $this->RECURSIVE[$trainingType][$counter]['pal']=$pal;
        }   
        $this->counter++;
        $this->repeatedFunction2($bmrData,$weight,$pal,($totalday-1),$trainingType,$start+1,$counter+1,$type); 
    }
    

}
