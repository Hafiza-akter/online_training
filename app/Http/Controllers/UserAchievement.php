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

class UserAchievement extends Controller
{
    public $RECURSIVE=array();
    public $RECURSIVE2=array();
    public $counter=0;

 
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
    
 public function avgVal($start_val,$end_val,$arr,$factor){
            // dd($arr);
            $averageFactor=0;
                for($j=$start_val;$j<$end_val;$j++){
                    $averageFactor =$averageFactor + $arr[$j];
                }
                return $avgVal = $averageFactor/$factor;
            
    }

    public function progress(Request $request){

        // calculation test //
        $user_id = Session::get('user.id');
        $user = \App\Model\User::where('id',$user_id)->get()->first();

        $userPlanData = UserPlanPurchase::where('user_id',$user_id)->get()->first();

        // initial value
        $targetCaloryGain=$userPlanData->target_calory_gained;
        $initialPal=$user->pal;
        $initialWeight=$user->weight;
         $startDay = new \Carbon\Carbon($userPlanData->created_at);
        // finding training type

        $trainingType = PlanPurchase::find($userPlanData->purchase_plan_id)->times_per_week;
        if( $trainingType == 1){
            $trainingType = '1day_per_week';
        }
        if( $trainingType == 2){
            $trainingType = '2day_per_week';
        }
        if( $trainingType == 3){
            $trainingType ='3day_per_week';
        }
        // finding training type


        $setUpData = \App\Model\Setting::get()->first();

        $todayDate=date('Y-m-d');

        // dd($userFirstDay);
       
        $caloryArray=array();
        $tcaloryArray=array();
        $newArr=array();
        $setUpdata=array();
        $setUpdata2=array();
        // 90 days data set up
        $flagForFirstData='false';
        $dataset = array();

        $bmrData = BMRcalculation($user->weight);
        // dd($bmrData);
       
       // initial purchase plan data
        $weight = $user->weight;
        $totalDay=90;
        $start=1;
        $pal=$user->pal;
        $type=1;

        $diff = 0;
        $date = Carbon::parse($userPlanData->created_at);
        $now = Carbon::parse($todayDate);
        $diff = $date->diffInDays($now);



        $dataset[0] = $this->calculation(0,$bmrData,$weight,$pal,$totalDay,$start,$type,$trainingType);

         // finding out actual data //
        $flagForFirstDataHistory = "false";
        if($diff > 0){
            for($d=0;$d<$diff;$d++){
                $day = $startDay->addDays(1)->format('Y-m-d');
                $userDay = UserHistory::where('user_id',$user_id)->whereDate('recorded_at',  $day)->get()->first();

                // calory data calculation //
                if($userDay){

                    $setUpdata['calory'][$d] = $userDay->calory_gained*$user->calory_gained_offset;
                    
                    // weight calculation for inserted value
                    if( $userDay->weight_morning != 0 && $userDay->weight_evening != 0 ) {
                        $setUpdata['weight'][$d] = ( $userDay->weight_morning+$userDay->weight_evening ) / 2;
                    }else{
                        if($userDay->weight_morning == 0){
                            $setUpdata['weight'][$d] = $userDay->weight_evening;
                        }
                         if($userDay->weight_evening == 0){
                            $setUpdata['weight'][$d] = $userDay->weight_morning;
                        }
                    }

                    // pal calculation for inserted value
                    $setUpdata['pal'][$d] = $userDay->pal;
                    $setUpdata['day'][$d] = $day;


                    
                    $flagForFirstDataHistory = 'true';
                }else{

                    //   calory and weight calculation for not inserted value and initial value

                    if($flagForFirstDataHistory == 'false'){
                        $setUpdata['calory'][$d] = $targetCaloryGain*$user->calory_gained_offset;
                        $setUpdata['weight'][$d] = $initialWeight;
                        $setUpdata['pal'][$d] = $initialPal;

                    }else{
                        $setUpdata['calory'][$d] = array_sum($setUpdata['calory'])/ count($setUpdata['calory']);
                        $setUpdata['weight'][$d] = array_sum($setUpdata['weight']) / count ($setUpdata['weight']);
                        $setUpdata['pal'][$d] = array_sum($setUpdata['pal'])/ count($setUpdata['pal']);
                    }
                    
                    $setUpdata['day'][$d] = $day;

                }


                $weightBalance = weight_balance($setUpdata['calory'][$d],$setUpdata['pal'][$d],$setUpdata['weight'][$d],$d+1,$trainingType);
                $weight = $setUpdata['weight'][$d]+$weightBalance;
                if($d == 0){
                       $setUpdata['weight'][$d] =  $initialWeight;
                    }else{
                        $setUpdata['weight'][$d] = $this->number_formate($weight);
                    }

            }


            $actualArray=array();
            
            $ct=0;
            if($diff > 0){
                for($m=0;$m<count($setUpdata['weight']);$m++){
                        $actualArray[$m] =$setUpdata['weight'][$m];
                        $ct++;
                }
                
            }

            for($k=$diff;$k<90;$k++){
                $actualArray[$k] =null;
                
            }
            // dd($actualArray);

            $dataset[1]=array(
                'data' => $actualArray,
                'label'=> "actual",
                'borderColor'=> "red",
                'fill'=> false
            );

        // expected line
          $calory_gained = $setUpdata['calory'][$diff-1];

          $weights = $setUpdata['weight'][$diff-1];
          $pals = $setUpdata['pal'][$diff-1];
          $lastarray = $setUpdata['calory'];

            //avarage calory former seven data
            if( count($setUpdata['calory']) > 6 ){

                $a=array();
                for($k=count($setUpdata2['calory'])-7;$k<count($setUpdata2['calory']);$k++){
                    $a[$k]=$setUpdata2['calory'][$k];
                }
                $average = array_sum($a)/7;
                $setUpdata2['calory'][$i]=$average;
            }else{
                $setUpdata2['calory'][$i]=array_sum($setUpdata2['calory'])/count($setUpdata2['calory']);
            }

        }else{

            $dataset[1]=array(
                'data' => null,
                'label'=> "actual",
                'borderColor'=> "red",
                'fill'=> false
            );

            $calory_gained = $targetCaloryGain;
            $weights = $initialWeight;
            $pals = $initialPal;
            $lastarray=array();
        }
        
        // dd($calory_gained);
        // $this->repeatedFunction2($calory_gained,$weights,$pals,90-$diff,$trainingType,$start,$counter=0,$type,$diff,$lastarray);
        $dataset[2] = $this->calculation($diff,$calory_gained,$weights,$pals,90,$start,$type,$trainingType);

        // // dd( $dataset[2]);
        //  $actualArray2=array();
            
        // $ct=0;
        // if($diff > 0){
        //     for($m=0;$m<$diff;$m++){
        //             $actualArray2[$m] =$setUpdata['weight'][$m];
        //             $ct++;
        //     }
            
        // }

        // for($k=$diff;$k<90;$k++){
        //             $actualArray2[$m] =$dataset[2]['data'][$m];
        // }
        //  $dataset[2] =$actualArray2;
        //  dd($dataset[2]);
        // $weightDatass = $this->RECURSIVE2;

        // // dd($weightDatass);
        //     $ct=0;
        //     if($diff > 0){
        //         for($m=0;$m<$diff-1;$m++){
        //                 $actualArray2[$m] =null;
        //                 $ct++;
        //         }
        //          for($k=0;$k<90-$diff;$k++){
        //         if($k==0){
                    
        //             $actualArray2[$ct] =$weights;
        //         }else{
        //             $actualArray2[$ct] =$weightDatass[$trainingType][$k]['weight'];
        //         }
        //         $ct++;
        //     }
        //     // dd($actualArray2);

        //     $dataset[2]=array(
        //         'data' => $actualArray2,
        //         'label'=> "actual",
        //         'borderColor'=> "green",
        //         'fill'=> false
        //     );
        //     }

           

        // $flagForFirstData2="false";
        // for($i=0;$i<90-$diff;$i++){


        //     $setUpdata2['calory'][$i] = $setUpdata2['calory'][$diff-1]*$user->calory_gained_offset;
        //     $setUpdata2['weight'][$i]= $setUpdata2['weight'][$diff-1];
        //     $setUpdata2['pal'][$i] = $setUpdata2['pal'][$diff-1];


        //     // avarage calory former seven data
        //     // if( count($setUpdata2['calory']) > 6 ){

        //     //     $a=array();
        //     //     for($k=count($setUpdata2['calory'])-7;$k<count($setUpdata2['calory']);$k++){
        //     //         $a[$k]=$setUpdata2['calory'][$k];
        //     //     }
        //     //     $average = array_sum($a)/7;
        //     //     $setUpdata2['calory'][$i]=$average;
        //     // }else{
        //     //     $setUpdata2['calory'][$i]=array_sum($setUpdata2['calory'])/count($setUpdata2['calory']);
        //     // }

        //     // consume calory data calculation //
        //     // $consumeCalory = consumed_calory($pal,$setUpdata2['weight'][$i],$$trainingtype);
        //     // $dataset = $this->calculation($bmrData,$weight,$pal,$totalDay,$start,$type);
        //         // $weightBalance = weight_balance($setUpdata2['calory'][$i],$setUpdata2['pal'][$i],$setUpdata2['weight'][$i],$i+1,$trainingType);

        //         // $weight = $setUpdata2['weight'][$i]+$weightBalance;
                
        //         // $setUpdata2['weight'][$i] = $this->number_formate($weight);

        // }

        // $actualArray2=array();
        // $cnt=0;
        // if($diff > 0){
        //     for($l=0;$l<$diff;$l++){
        //         $actualArray2[$cnt] = null;
        //         $cnt++;
        //     }
            
        // }

        // for($k=0;$k<count($setUpdata2['weight']);$k++){
        //     $actualArray2[$cnt] =$setUpdata2['weight'][$k];
        //     $cnt++;
        // }

        // $dataset[2]=array(
        //     'data' => $actualArray2,
        //     'label'=> "Expected Line",
        //     'borderColor'=> "green",
        //     'fill'=> false
        // );

                // dd($dataset);
        ///

        // dd($dataset[2]);
            
        $userPurchasePlan=UserPlanPurchase::where('user_id',Session::get('user.id'))->first();
        $isactive='progress';
        $purchase=PlanPurchase::where('status',1)->get();
        $plan=PlanPurchase::where('id',1)->get()->first();

        return view('pages.trainee.progress')
        ->with('dataset',json_encode($dataset,true))
        ->with('purchase',$purchase)
        ->with('plan',$plan)
        ->with('isActive',$isactive)
        ->with('userPurchasePlan',$userPurchasePlan)
        ->with('bmrData',$bmrData)
        ->with('user',$user);

    }
    
    // purchase calculation and ajax call
    // purchase calculation and ajax call
    public function purchaseajaxcall(Request $request){
        $bmrData=$request->bmrData;
        $totalDay=$request->totalday;
        $start=$request->startday;
        $pal=$request->pal;
        $type=$request->type;
        $weight=$request->weight;
        return  $this->calculation($bmrData,$weight,$pal,$totalDay,$start,$type);
    }
    public function calculation($diff,$bmrData,$weight,$pal,$totalDay,$start,$type,$trainingType){

        $bmrData=$bmrData;
        $totalDay=$totalDay;
        $start=$start;
        $pal=$pal;
        $type=$type;
        

        $this->repeatedFunction($bmrData,$weight,$pal,$totalDay,$trainingType,$start,$counter=0,$type);
        $weightData = $this->RECURSIVE;
        $dataset=array();

        // for graph in purchae plan
        $dArray=array();
        $cnt=0;
        if($diff > 0){
            for($i=0;$i<$diff;$i++){
                    $dArray[$cnt] = null;
                    $cnt++;
            }
        }

        for($i=$diff;$i<$totalDay;$i++){
            if($i==0){
                $dArray[$cnt] = $weight;

            }else{
                $dArray[$cnt] = $this->number_formate($weightData[$trainingType][$i]['weight']);

            }
            $cnt++;
        }

        return array(
                    'data' => $dArray,
                    'label'=> "Purchase Plan",
                    'borderColor'=> $diff > 0 ? 'green' : "#6d93ff",
                    'fill'=> false
                );


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
    public function repeatedFunction2($bmrData,$weight,$pal,$totalday,$trainingType,$start,$counter,$type,$diff,$lastarray){

        // foreach($i=$counter;$i<count($lastarray);$i++){

        // }
        // dd(array_sum($lastarray)/count($lastarray));
        // if(count($lastarray) != 0){
        //             $bmrData = array_sum($lastarray)/count($lastarray);

        // }

        // dd($bmrData);

        if ($totalday === 0){
            return $this->RECURSIVE2;
        }else{

            $weightBalance = weight_balance($bmrData,$pal,$weight,$start,$trainingType);
            $weight = $weight-$weightBalance;
            $this->RECURSIVE2[$trainingType][$counter]['plan_type']=$trainingType;
            $this->RECURSIVE2[$trainingType][$counter]['weight']=$weight;
            $this->RECURSIVE2[$trainingType][$counter]['weightBalance']=$weightBalance;
            $this->RECURSIVE2[$trainingType][$counter]['bmr']=$bmrData;
            $this->RECURSIVE2[$trainingType][$counter]['pal']=$pal;
        }   
        // $this->counter++;
        $this->repeatedFunction2($bmrData,$weight,$pal,($totalday-1),$trainingType,$start+1,$counter+1,$type,$diff,$lastarray); 
    }


    
   
    
    public function dailydata(Request $request){
         // calculation test //

        $user_id = Session::get('user.id');
        $user = \App\Model\User::where('id',$user_id)->get()->first();
        $isactive='dailydata';
            $today =$request->date;
            $ua = UserHistory::whereDate('recorded_at',$today)->where('user_id',$user_id)->get()->first();
            $list = UserHistory::where('user_id',$user_id)->get();
        return view('pages.trainee.daily_data')
        ->with('ua',$ua)
        ->with('list',$list)
        ->with('isActive',$isactive)
        ->with('user',$user);
    }
    public function dailydataSubmit(Request $request){

            $validateData = $request->validate([

                'pal' => 'required',
                'weight_evening' => 'required',
                'weight_morning' => 'required',
                'calory_gained' => 'required',
            ]);
            $date = $request->input('datepicker_');

            $timing=$this->morningOrEvening();
            $todayData = UserHistory::whereDate('recorded_at',$date)->where('user_id',$request->user_id)->get()->first();

            if($todayData){
                 $history = UserHistory::find($todayData->id);
                 $msg = "Data updated succesfully!";

            }else{
                 $history = new UserHistory();
                 $msg = "Data inserted succesfully!";
            }
           

            $history->weight_morning = $request->input('weight_morning');
            $history->weight_evening = $request->input('weight_evening');

            $history->body_fat_percentage_morning =  $request->input('fat_morning');
            $history->body_fat_percentage_evening = $request->input('fat_evening');

            $history->calory_gained = $request->input('calory_gained');
            // $history->calory_consumed = $request->input('consumed_calory');

            $history->recorded_at = $request->input('datepicker_');
            $history->user_id = $request->user_id;
            if($request->input('pal') === 'high'){
                 $history->pal =2;
            }
            if($request->input('pal') === 'low'){
                 $history->pal= 1.55;

            }   
            if($request->input('pal') === 'medium'){
                 $history->pal =1.75;

            }

            $history->save();

            return redirect()->back()->with('success',$msg);

    }   

    public function number_formate($data){
            return number_format((float)$data, 2, '.', '');  // Outputs -> 105.00
    }

}