<?php 
// use App\Model\Course;

function test(){
	return 'hello';
}
function backgroundColor($hour,$minute,$dataArray){ // data array = db start time data row

	// echo ($minute);
	$colorFormat = "";
    if(!empty($dataArray)){
        foreach($dataArray as $val){

        	$aHr1 = Carbon\Carbon::parse($val->time)->format('H')+1;
        	$aHr2 = Carbon\Carbon::parse($val->time)->format('H')+2;

            // when time selection  is 1
        	if(Carbon\Carbon::parse($val->time)->format('H') == 1){
        		$aHr1 = $aHr1 -1;
        		$aHr2 = $aHr2 -1;
        	}

            // when time selection is regular
            
            if( $aHr1 == $hour && Carbon\Carbon::parse($val->time)->format('i') <= $minute ){
        		$colorFormat = '#1b97ef'; // blue
        		if($val->is_occupied == 1){
     
                	$colorFormat = checkNextReserved($dataArray,$val->time);
           		}                
            }

			if( $aHr2 == $hour && Carbon\Carbon::parse($val->time)->format('i') >= $minute ){
				$colorFormat = '#1b97ef'; // blue
				if($val->is_occupied == 1){
                	$colorFormat = checkNextReserved($dataArray,$val->time);
				}                
            }

            // when time selection  is 23
            if( Carbon\Carbon::parse($val->time)->format('H') ==23 ){
            	$aHr2 = 1;

				if( $aHr2 == $hour && Carbon\Carbon::parse($val->time)->format('i') >= $minute ){
					$colorFormat = '#1b97ef'; // blue
					if($val->is_occupied == 1){
                		$colorFormat = checkNextReserved($dataArray,$val->time);
					}                
            	}               
            }


        }
	}

	return $colorFormat; 
}

function checkNextReserved($arr, $time){
	$dataArray=array();
		// return '#f4928e';
	foreach($arr as $key=>$val){
		if($val->is_occupied == 1){
			$dataArray[]=Carbon\Carbon::parse($val->time)->format('H');
		}
	}
	sort($dataArray);

	if(count($dataArray) > 1){
		if($dataArray[0] == Carbon\Carbon::parse($time)->format('H')){
				
				return '#f4928e';
			}else{
				return '#a2ffb7'; //green
			}
	} 
 		
	return '#a2ffb7'; //green
}

function diff($finish){

			$startTime = Carbon\Carbon::now();
			$finish = Carbon\Carbon::parse($finish);
			return $finish->diffInSeconds($startTime);
}
function BMRcalculation($weight){


	$user_id = Session::get('user.id');
	$user = \App\Model\User::where('id',$user_id)->get()->first();
	$setUpData = \App\Model\Setting::get()->first();


	// age of the user 
	$dateOfBirth = $user->dob;
	$today = date("m/d/Y");
	$diff = date_diff(date_create($dateOfBirth), date_create($today));

	$age = (int) $diff->format('%y');
	$weight = $weight;
	$height = $user->length;
	// dd($age);

	$bmr_weight_offset=$user->bmr_weight_offset;
	$bmr_length_offset=$user->bmr_length_offset;
	$bmr_height_offset=$user->bmr_height_offset;
	$bmr_age_offset=$user->bmr_age_offset;

	if($user->sex ==='male'){
		$bmr_gender_offset = $user->bmr_male_offset;
		$bmr_gender_coefficient = $setUpData->bmr_male_coefficient;
	}else{
		$bmr_gender_offset = $user->bmr_female_offset;
		$bmr_gender_coefficient = $setUpData->bmr_female_coefficient;
	}

	$bmr_gender_offset=$user->bmr_gender_offset;
   

	if($user->sex ==='male'){
		$result = ($setUpData->bmr_weight_coefficient*$bmr_weight_offset*$weight)
			+($setUpData->bmr_length_coefficient*$bmr_length_offset*$height)
			-($setUpData->bmr_age_coefficient*$bmr_age_offset*$age)
			+($bmr_gender_coefficient+$bmr_gender_offset);
	}

	if($user->sex ==='female'){
		// dd($setUpData->bmr_age_female_coefficient);
		$result = ($setUpData->bmr_weight_female_coefficient*$bmr_weight_offset*$weight)
			+($setUpData->bmr_length_female_coefficient*$bmr_length_offset*$height)
			-($setUpData->bmr_age_female_coefficient*$bmr_age_offset*$age)
			+($bmr_gender_coefficient+$bmr_gender_offset);
	}


	return $result;
}
function training_calory($weight){

	$user_id = Session::get('user.id');
	$user = \App\Model\User::where('id',$user_id)->get()->first();
	$setUpData = \App\Model\Setting::get()->first();

	$session_time=0.67;
	$mets=6;

	$result= $weight * $setUpData->traininng_calory_coefficient * $user->trainning_calory_offset*$mets*$session_time;
	//dd($result);
	return $result;
		// weight*traininng_calory_coefficient*trainning_calory_offset*METS*session_time
}
function after_burn($weight){
	$user_id = Session::get('user.id');
	$user = \App\Model\User::where('id',$user_id)->get()->first();

	$setUpData = \App\Model\Setting::get()->first();
	$result = BMRcalculation($weight)*$setUpData->adter_burn_coefficient*$user->after_burn_offset;
	// dd($result);
	return $result;
	// BMR*adter_burn_coefficient*after_burn_offset
}

// function traingDay($n,$day,$type){
// 	if($n == 1){
// 		$trainingDay=1;
// 	}
// 	// 1 day per week 
// 	if($type == '1_day_per_week'){
// 		$trainingDay=7*$n-6;
// 	}


// 	// 2 day per week 
// 	if($type == '2_day_per_week'){
// 		if($n%2 == 0){
// 			$trainingDay=7*($n-$n/2);
// 		}
// 		if($n%2 != 0){
// 			$trainingDay=7*($n - floar($n/2) )-6;
// 		}
// 	}

// 	// 3 day per week 
// 	if($type == '3_day_per_week'){
// 		if($n%2 == 0){
// 			$trainingDay=7*($n-$n/2);
// 		}
// 		if($n%2 != 0){
// 			$trainingDay=7*($n - floar($n/2) )-6;
// 		}
// 	}


// }
function consumed_calory($pal,$weight,$daynumber,$trainingtype){
	$trainingDay='FALSE';
	$training_cal=0;
	$after_burn =0;

	if($trainingtype === '1day_per_week'){
		$allTraingingArray = Config::get('statics.1day_per_week');
		if (in_array($daynumber, $allTraingingArray)) {
		    $trainingDay="TRUE";
		    $training_cal = training_calory($weight);
		    $after_burn = after_burn($weight);
		}
	}
	if($trainingtype === '2day_per_week'){
		$allTraingingArray = Config::get('statics.2day_per_week');
		if (in_array($daynumber, $allTraingingArray)) {
		    $trainingDay="TRUE";
		    $training_cal = training_calory($weight);
		    $after_burn = after_burn($weight);
		}
	}
	if($trainingtype === '3day_per_week'){
		$allTraingingArray = Config::get('statics.3day_per_week');
		if (in_array($daynumber, $allTraingingArray)) {
		    $trainingDay="TRUE";
		    $training_cal = training_calory($weight);
		    $after_burn = after_burn($weight);
		}
	}

	if($trainingDay === 'FALSE'){
		// finding out after_burn() for next 2 days after training day
		if($trainingtype === '1day_per_week'){
			$allBurnDayArray = Config::get('statics.after_burn_1day_per_week');
			if (in_array($daynumber, $allBurnDayArray)) {
			    $after_burn = after_burn($weight);
			}
		}

		if($trainingtype === '2day_per_week'){
			$allBurnDayArray = Config::get('statics.after_burn_2day_per_week');
			if (in_array($daynumber, $allBurnDayArray)) {
			    $after_burn = after_burn($weight);
			}
		}

		if($trainingtype === '3day_per_week'){
		    $after_burn = after_burn($weight);
		}
	}

	$result= (BMRcalculation($weight)*$pal)+$training_cal+$after_burn;
	return $result;
}
//BMR*physicalactive level+training calory+after burn
function calory_balance($calory_gained,$pal,$weight,$daynumber,$trainingtype){

	$result = $calory_gained - consumed_calory($pal,$weight,$daynumber,$trainingtype);
	return $result;

	//calory_gained-consumed calor
}

function weight_balance($calory_gained,$pal,$weight,$daynumber,$trainingtype){

	$user_id = Session::get('user.id');
	$user = \App\Model\User::where('id',$user_id)->get()->first();
		$setUpData = \App\Model\Setting::get()->first();

		$result=calory_balance($calory_gained,$pal,$weight,$daynumber,$trainingtype)*$setUpData->weight_balance_coefficient1*$user->weight_balance_offset
			/$setUpData->weight_balance_coefficient2/1000;

	return $result;
}

function dit($calory_gained){ //Diet Induced Thermogenesis
	$user_id = Session::get('user.id');
	$user = \App\Model\User::where('id',$user_id)->get()->first();
	$setUpData = \App\Model\Setting::get()->first();

	$result = $calory_gained*$setUpData->ditcoefficient*$user->ditoffset;
	return $result;
	// calory_gained*uDITcoefficient*DIToffset
}
function checkEquipment($user_id,$id){
	  return \App\Model\UserEquipment::where('user_id',$user_id)->where('equipment_id',$id)->get()->first();

}
function number_formate($data){
            return number_format((float)$data, 2, '.', '');  // Outputs -> 105.00
 }
 function getCourseData($id){
        return \App\Model\Course::find($id);
 }
 function getCourseDataMain($main){
        return \App\Model\Course::where('main',$main)->get();
 }
 function getEquipment($id){
        return \App\Model\Equipment::find($id);
 }
 

?>