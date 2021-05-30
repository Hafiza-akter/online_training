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
   
	 $result=0;
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
        return \App\Model\Course::where('body_part',$main)->get();
 }
 function getEquipment($id){
        return \App\Model\Equipment::find($id);
 }
 function getUserName($schedule_id){
 	$schedule = \App\Model\TrainerSchedule::find($schedule_id);
	return \App\Model\User::where('id',$schedule->user_id)->get()->first();
 }
 function getTrainerName($schedule_id){
 	$schedule = \App\Model\TrainerSchedule::find($schedule_id);
	return \App\Model\Trainer::where('id',$schedule->trainer_id)->get()->first();
 }
 function getTrainerImage($trainer_id){
	$data= \App\Model\Trainer::find($trainer_id);
	if(isset($data) && $data->icon_image ){
		return  url('storage/icons/'.$data->icon_image);
	}else{
		return  asset('images/default.png');
	}
 }
 function getTrainer($trainer_id){
	$data= \App\Model\Trainer::find($trainer_id);
	return $data;
 }

 function getCourseName($id){
	//$schedule = \App\Model\TrainerSchedule::where('id',$id)->get()->first();
	$trainingData = \App\Model\Training::where('trainer_schedule_id',$id)->first();
	if($trainingData){
		$exerciseData = \App\Model\Exercise::where('training_id',$trainingData->id)->get();
		$str = '';
		
		foreach($exerciseData as $exercise){
			$courseData = \App\Model\Course::where('id',$exercise->course_id)->first();
			$str = $str.$courseData->course_name.', ';
		}

		$str = rtrim($str, ", ");
		return $str;
	}else{
		return 'N/A';
	}
 }
 function checkPastDate($date){
 	$isToday=\Carbon\Carbon::parse($date)->isToday();
    $isPast=\Carbon\Carbon::parse($date)->isPast();

    if(!$isToday && $isPast){
       return true;
    }
    return false;
 }
 function checkMultipleSchedule($date,$time){
 	 	$schedule = \App\Model\TrainerSchedule::whereDate('date',$date)
 	 				->where('time',$time)
 	 				// ->where('user_id',Session::get('user.id'))
 	 				->where('is_occupied',1)->first();

 	 	if($schedule ){
 	 		return true ; 
 	 	}
 	 	return false;
 }
 function checkPastTIme($time,$date){

    $end= new \Carbon\Carbon($date." ".$time);
    $start = \Carbon\Carbon::now();
    $totalDuration = $start->diffInMinutes($end,false); 
    // dump($start);
    // dump($end);
    // dd($totalDuration);
    if($totalDuration <= 0){
        return true ; 
    }
    return false;
 }
 function checkPastTIme1($time,$date){

    $end= new \Carbon\Carbon($date." ".$time);
    $start = \Carbon\Carbon::now();
    $totalDuration = $start->diffInMinutes($end,false); 
    // dump($start);
    // dump($end);
    // dd($totalDuration);
    if($totalDuration <= -60){
        return true ; 
    }
    return false;
 }
 function checkLimitValidation($time,$date){
    $setUpData = \App\Model\Setting::get()->first();
  // not to modify the past date and if limit time exceed
    // not to modify the past date and if limit time exceed
    $end= new \Carbon\Carbon($date." ".$time);
    $start = \Carbon\Carbon::now();
  
    $totalDuration = $start->diffInMinutes($end,false); 
    if($totalDuration < $setUpData->cancellation_time){
        return true ; 
    }
    return false;
    // ---------------------------------------------------
    // ---------------------------------------------------
}
function encryptionValue($parameter){
	// data like array('id' => $id )
	return  \Crypt::encrypt($parameter);

}
function dycryptionValue($object){
	// $request->id
	 return \Crypt::decrypt($object);
}
function activePurchasePlan($user_id){

	$list = \App\Model\UserPlanPurchase::where('status',1)->where('user_id',$user_id)->orderBy('id','ASC')->get();
	
	if($list){
		foreach($list as $val){

			$expiredDate = \Carbon\Carbon::parse($val->created_at)->addMonths($val->period_month);

			$nowDate = \Carbon\Carbon::now();

			$totalDuration = $expiredDate->diffInDays($nowDate,false); 

			if($totalDuration < 0 ){
				return $val;
			}
		}
	}	
	// dd($list);
	return null;
}
function radarLabel($trainer_id){

// 	{
//   labels: Label,
//   datasets: [ {
//     data: dataset,
//     fill: true,
//     backgroundColor: 'rgba(54, 162, 235, 0.2)',
//     borderColor: 'rgb(54, 162, 235)',
//     pointBackgroundColor: 'rgb(54, 162, 235)',
//     pointBorderColor: '#fff',
//     pointHoverBackgroundColor: '#fff',
//     pointHoverBorderColor: 'rgb(54, 162, 235)'
//   }]
// }
	$returnArray=array();
	$data = \App\Model\RatingsSetup::where('status',1)->get();
	if(isset($data)){
		foreach ($data as $key => $value) {
			$returnArray['labels'][]=$value->name;
			$returnArray['dataset'][]=getAvgValue($trainer_id,$value->id);


		}
	}
	$array = array(
		  'labels'=> $returnArray['labels'],
		  'datasets'=> [ array(
			    'data'=> $returnArray['dataset'],
				    'fill'=> true,
				    'backgroundColor'=> '#056fb8a6',
				    'borderColor'=> 'rgb(54, 162, 235)',
				    'pointBackgroundColor'=> 'rgb(54, 162, 235)',
				    'pointBorderColor'=> '#fff',
				    'pointHoverBackgroundColor'=> '#fff',
				    'pointHoverBorderColor'=> 'rgb(54, 162, 235)'
	 	 		)
 	 		]
		);
// )
	return json_encode($array,true);
}
function getAvgValue($trainer_id,$input_id){
	$count=0;
	$find_trainer = \App\Model\TrainerEvaluationRatings::where('trainer_id',$trainer_id)->first();
	if(isset($find_trainer)){

		$data = \App\Model\TrainerEvaluationRatings::where('trainer_id',$trainer_id)
		   		->where('input_ratings_id',$input_id)
		   		->groupBy('input_ratings_id')
		    	->avg('input_ratings_value');

		if($data > 1){
			return $data;  	
		}else{
				$return_arr=array();
		    	$data = \App\Model\Trainer::find($trainer_id);

		    	$arr =  json_decode( $data->self_evaluation,true);
		    	
		    	if(!empty($arr)){
		    		foreach($arr as $key=>$val){
			    		if($key == $input_id){
			    			return $val;
			    		}
			    	}
		    	}
		    	// dd($return_arr);
		    	return $return_arr;

		}

    	return $data;

	}else{

    	$return_arr=array();
    	$data = \App\Model\Trainer::find($trainer_id);

    	$arr =  json_decode( $data->self_evaluation,true);
    	
    	if(!empty($arr)){
    		foreach($arr as $key=>$val){
	    		if($key == $input_id){
	    			$return_arr[$count] = $val;
	    			$count++;
	    		}
	    	}
    	}
    	
    	return $return_arr;
    }

}
function radarData($trainer_id){
	$returnArray=array();
	$data = \App\Model\RatingsSetup::where('status',1)->get();
	if(isset($data)){
		foreach ($data as $key => $value) {
			$returnArray[]=$value->name;
		}
	}
}
function avgStarValue($trainer_id){

	$data = \App\Model\Ratings::where('trainer_id',$trainer_id)
   		->groupBy('trainer_id')
    	->avg('star_ratings');

    	return $data;
}
function totalStar($trainer_id){

	$data = \App\Model\Ratings::where('trainer_id',$trainer_id)
   		->groupBy('trainer_id')
    	->sum('star_ratings');

    	return (int) $data;
}

function evaluationValue($ratings_id,$input_ratings_id){
   return \App\Model\TrainerEvaluationRatings::where('trainer_ratings_id',$ratings_id)
   		->where('input_ratings_id',$input_ratings_id)->first();

}
function evalInitial($array,$id){
	if($array){
      foreach ($array as $key => $value) {
        # code...
        if($key == $id){
            return $value;
        }
      }
    }
   return "0";
}

function dateIsnotPast($date){
	$isToday=\Carbon\Carbon::parse($date)->isToday();
    $isPast=\Carbon\Carbon::parse($date)->isPast();
	
	if(!$isToday && $isPast) {
		return false;
	}
	return true;
}

function getTrainerList(){
	


	$purchasePlan = activePurchasePlan(Session::get('user.id'));
	$count = 0;
	$periodArray=array();

	if(isset($purchasePlan)){


		$schedule = \DB::table('tbl_trainer_schedules as w')
                    ->select(
                        array(
                            'time',
                            'id',
                            'user_id',
                            'is_occupied',
                            'is_favourite',
                            'status',
                            'trainer_id',
                            DB::raw("DAYOFWEEK(date) dow"), 
                            DB::Raw('DATE(w.date) day'))
                        )
                    ->where('status',NULL)
                    ->whereDate('date', '>=',  \Carbon\Carbon::now())
                    ->groupBy('day','trainer_id')
                    ->take(4)
                    ->get();

    	if(isset($schedule)){
	            	foreach($schedule as $key=>$vals){

	            		$periodArray[$count] = array(
	            			// 'display' => 'background',
	            			'allDay' => true,
	            			'color' => $vals->user_id === Session::get('user.id') && $vals->is_occupied == 1 ? 'red' : 'transparent',
							'start' =>  $vals->day, // purchase plan start day
							'extendedProps' => array(
								// 'type' =>  'normal',
								'imageurl'=> getTrainerImage($vals->trainer_id),
	                            // 'type' => 'recurring',
								'trainer_id' =>  $vals->trainer_id
	                            
							)
	            		);
						$count++;
	            	}
	            }


		$expiredDate = \Carbon\Carbon::parse($purchasePlan->created_at)
						->addMonths($purchasePlan->period_month)
						->Format('y-m-d');

		$startDate = \Carbon\Carbon::parse($purchasePlan->created_at)
						->Format('y-m-d');

		$dateRange = \Carbon\CarbonPeriod::create($startDate, $expiredDate);
		
		foreach ($dateRange as $keys=>$date) {

		 	
			if(dateIsnotPast($date->format('Y-m-d'))){


				$recurring = \App\Model\TrainerRecurringSchedule::where('status',NULL)
	                    ->where('dow',$date->dayOfWeek)
	                    ->groupBy('dow','trainer_id')
	                    ->take(4)
	                    ->get();
	             // dd($recurring);
	            if(isset($recurring)){
	            	foreach($recurring as $key=>$vals){

	            		$periodArray[$count] = array(
	            			// 'display' => 'list-item',
	            			'allDay' => true,
	            			'color' => 'transparent',
							'start' =>  $date->format('Y-m-d'), // purchase plan start day
							'extendedProps' => array(
								// 'type' =>  'recurring',
								'imageurl'=> getTrainerImage($vals->trainer_id),
								'trainer_id' =>  $vals->trainer_id
	                            
							)
	            		);
						$count++;
	            	}
	            }
            }

		}
	}

	
		// return $periodArray;
		$data = null;
	        
        $data = array_values(array_intersect_key( $periodArray , array_unique( array_map('serialize' , $periodArray ) ) ));

         return $data;
        
}

function getSortedTrainerList($param,$param2){	


	$purchasePlan = activePurchasePlan(Session::get('user.id'));
	$count = 0;
	$periodArray=array();
	$trainerSorted=array();

	if(isset($purchasePlan)){


		$query = \DB::table('tbl_trainer_schedules as w')
                    ->select(
                        array(
                            'time',
                            'id',
                            'user_id',
                            'is_occupied',
                            'is_favourite',
                            'status',
                            'trainer_id',
                            DB::raw("DAYOFWEEK(date) dow"), 
                            DB::Raw('DATE(w.date) day'))
                        )
                    ->where('status',NULL)
                    // ->whereDate('date', '>=',  \Carbon\Carbon::now())
                    ->groupBy('day','trainer_id');

         if($param == 'favourite'){         	
         	$favList = getTrainerFavouriteList();
            $query->whereIn('trainer_id',$favList);
         }
         if($param == 'history'){
         	$query->where('user_id', '=', Session::get('user.id'));
         }
         
        if($param == 'recommended'){
			$list=trainerRatingsOrder();
         	$query->whereIn('trainer_id', $list);
		}
         if($param2 == '00:00:00-06:00:00'){
         	$query->whereBetween('time', ['00:00:00','06:00:00']);
         }
         if($param2 == '06:00:00-12:00:00'){
         	$query->whereBetween('time', ['06:00:00','12:00:00']);
         }
         if($param2 == '12:00:00-18:00:00'){
         	$query->whereBetween('time', ['12:00:00','18:00:00']);
         }
         if($param2 == '18:00:00-24:00:00'){
         	$query->whereBetween('time', ['18:00:00','24:00:00']);
         }
        $schedule= $query->get();

    	if(isset($schedule)){
	            	foreach($schedule as $key=>$vals){
	            		$trainerSorted[$count]= $vals->trainer_id;
	            		$periodArray[$count] = array(

	            			// 'display' => 'background',
	            			'allDay' => true,
	            			'color' => $vals->user_id === Session::get('user.id') && $vals->is_occupied == 1 ? 'red' : 'transparent',
							'start' =>  $vals->day, // purchase plan start day
							'extendedProps' => array(
								// 'type' =>  'normal',
								'imageurl'=> getTrainerImage($vals->trainer_id),
	                            // 'type' => 'recurring',
								'trainer_id' =>  $vals->trainer_id
	                            
							)
	            		);
						$count++;
	            	}
	            }

// recurring event //
		$expiredDate = \Carbon\Carbon::parse($purchasePlan->created_at)
						->addMonths($purchasePlan->period_month)
						->Format('y-m-d');

		$startDate = \Carbon\Carbon::parse($purchasePlan->created_at)
						->Format('y-m-d');

		$dateRange = \Carbon\CarbonPeriod::create($startDate, $expiredDate);
		
		foreach ($dateRange as $keys=>$date) {

		 	
			if(dateIsnotPast($date->format('Y-m-d'))){


				$query2 = \App\Model\TrainerRecurringSchedule::where('status',NULL)
	                    ->where('dow',$date->dayOfWeek)
	                    ->groupBy('dow','trainer_id');
	             // dd($recurring);

	             if($param == 'favourite'){
		         	$favList = getTrainerFavouriteList();
            		$query2->whereIn('trainer_id',$favList);
		         }
		         if($param == 'history'){
		         	$query2->whereIn('trainer_id',$trainerSorted);
		         }
		         if($param == 'recommended'){
					$list=trainerRatingsOrder();
		         	$query2->whereIn('trainer_id', $list);
				}
		         if($param2 == '00:00:00-06:00:00'){
		         	$query2->whereBetween('time', ['00:00:00','06:00:00']);
		         }
		         if($param2 == '06:00:00-12:00:00'){
		         	$query2->whereBetween('time', ['06:00:00','12:00:00']);
		         }
		         if($param2 == '12:00:00-18:00:00'){
		         	$query2->whereBetween('time', ['12:00:00','18:00:00']);
		         }
		         if($param2 == '18:00:00-24:00:00'){
		         	$query2->whereBetween('time', ['18:00:00','24:00:00']);
		         }

		        $recurring = $query2->get();

	            if(isset($recurring)){
	            	foreach($recurring as $key=>$vals){

	            		$periodArray[$count] = array(
	            			// 'display' => 'background',
	            			'allDay' => true,
	            			'color' => 'transparent',
							'start' =>  $date->format('Y-m-d'), // purchase plan start day
							'extendedProps' => array(
								// 'type' =>  'recurring',
								'imageurl'=> getTrainerImage($vals->trainer_id),
								'trainer_id' =>  $vals->trainer_id
	                            
							)
	            		);
						$count++;
	            	}
	            }
            }

		}
// !! -- recurring event !!--//		
	}

	
		// return $periodArray;
	$data = null;
        
    $data = array_values(array_intersect_key( $periodArray , array_unique( array_map('serialize' , $periodArray ) ) ));

    return $data;
        
}
function getTrainerListByDate($param){	


	$count = 0;
	$periodArray=array();
	$trainerSorted=array();

		$query = \DB::table('tbl_trainer_schedules as w')
                    ->select(
                        array(
                            'time',
                            'id',
                            'user_id',
                            'is_occupied',
                            'is_favourite',
                            'status',
                            'trainer_id',
                            DB::raw("DAYOFWEEK(date) dow"), 
                            DB::Raw('DATE(w.date) day'))
                        )
                    ->where('status',NULL)
                    ->whereDate('date',$param)
                    ->take(4)
                    ->groupBy('day','trainer_id');


         $schedule= $query->get();

    	if(isset($schedule)){
        	foreach($schedule as $key=>$vals){

        		 if($vals->trainer_id){

	        		$trainerSorted[$count]= $vals->trainer_id;

	     //    		$periodArray[$count] = array(

						// 'imageurl'=>  getTrainer($vals->trainer_id) ? getTrainer($vals->trainer_id)->photo_path : NULL,
						// 'trainer_id' =>  $vals->trainer_id,
						// 'name' =>  getTrainer($vals->trainer_id)->first_name,
						// 'instructions' =>  getTrainer($vals->trainer_id)->instructions
	     //    		);

	        		$periodArray[$count] = array(
	        				// for time view slot
							'imagesurl'=>  getTrainer($vals->trainer_id) ? getTrainer($vals->trainer_id)->photo_path : NULL,
							'trainer_id' =>  $vals->trainer_id,
							'name' =>  getTrainer($vals->trainer_id)->first_name,
							'instructions' =>  getTrainer($vals->trainer_id)->instructions,
	        				// for time view slot

	            			// 'display' => 'background',
	            			'allDay' => true,
	            			'color' => 'transparent',
	            			// 'color' => $vals->user_id === Session::get('user.id') && $vals->is_occupied == 1 ? 'red' : 'transparent',
							'start' =>  $vals->day, // purchase plan start day
							'extendedProps' => array(
								// 'color' => $vals->user_id === Session::get('user.id') && $vals->is_occupied == 1 ? 'red' : 'transparent',
								// 'type' =>  'normal',
								'imageurl'=> getTrainerImage($vals->trainer_id),
	                            // 'type' => 'recurring',
								'trainer_id' =>  $vals->trainer_id
	                            
							)
	            		);
					$count++;
        		}
        	}
	    }

// recurring event //
// recurring event //
// recurring event //
		$date = \Carbon\Carbon::parse($param);
		$query2 = \App\Model\TrainerRecurringSchedule::where('status',NULL)
                ->where('dow',$date->dayOfWeek)
                ->take(4)
                ->groupBy('dow','trainer_id');

        $recurring = $query2->get();

        if(isset($recurring)){
        	foreach($recurring as $key=>$vals){
        		if($vals->trainer_id){
        			

        			$periodArray[$count] = array(
        					 // for time view slot
							'imagesurl'=> getTrainer($vals->trainer_id) ? getTrainer($vals->trainer_id)->photo_path : NULL,
							'trainer_id' =>  $vals->trainer_id,
							'name' =>  getTrainer($vals->trainer_id)? getTrainer($vals->trainer_id)->first_name : NULL,
							'instructions' => getTrainer($vals->trainer_id) ?  getTrainer($vals->trainer_id)->instructions : NULL,
        					 // for time view slot
	            			// 'display' => 'background',
	            			'allDay' => true,
	            			'color' => 'transparent',
							'start' =>  $param, // purchase plan start day
							'extendedProps' => array(
								// 'type' =>  'recurring',
								'imageurl'=> getTrainerImage($vals->trainer_id),
								'trainer_id' =>  $vals->trainer_id
	                            
							)
	            		);
					$count++;
        		}
        		
        	}

		}
// !! -- recurring event !!--//		
// !! -- recurring event !!--//		
	
	
		// return $periodArray;
		$data = null;
	        
        $data = array_values(array_intersect_key( $periodArray , array_unique( array_map('serialize' , $periodArray ) ) ));
        return $data;
        
}
function timeslot($trainer_id,$date,$time){


		$query = \DB::table('tbl_trainer_schedules as w')
                    ->where('status',NULL)
                    ->whereDate('date',$date)
                    ->where('time',$time)
                    ->where('trainer_id',$trainer_id)->first();
                    // ->groupBy('trainer_id');
        if($query){
        	return $query;
        }


		$date = \Carbon\Carbon::parse($date);
		$query2 = \App\Model\TrainerRecurringSchedule::where('status',NULL)
                ->where('dow',$date->dayOfWeek)
                ->where('time',$time)
                ->where('trainer_id',$trainer_id)->first();
                // ->groupBy('trainer_id');

        if($query2){
        	return $query2;
        }
	    
	   return 'not_found';   
}

function getTime($trainer_id,$date){	

	$count = 0;
	$periodArray=array();
	$trainerSorted=array();

		$query = \DB::table('tbl_trainer_schedules as w')
                    ->select(
                        array(
                            'time',
                            'id',
                            'user_id',
                            'is_occupied',
                            'is_favourite',
                            'status',
                            'trainer_id',
                            'date',
                            DB::Raw('DATE(w.date) day'))
                        )
                    ->where('status',NULL)
                    ->whereDate('date',$date)
                    ->where('trainer_id',$trainer_id);
                    // ->groupBy('trainer_id');


         $schedule= $query->get();
// dd($schedule);
    	if(isset($schedule)){
        	foreach($schedule as $key=>$vals){
        		$trainerSorted[$count]= $vals->trainer_id;
        		$periodArray[$count] = array(
                    'is_occupied'=>$vals->is_occupied,
					'time'=> $vals->time,
					'trainer_id' =>  $vals->trainer_id,
					'id' =>  $vals->id,
					'date' =>  $vals->date,
					'type' => 'normal'
        		);
				$count++;
        	}
	    }

// recurring event //
// recurring event //
// recurring event //
		$date = \Carbon\Carbon::parse($date);
		$query2 = \App\Model\TrainerRecurringSchedule::where('status',NULL)
                ->where('dow',$date->dayOfWeek)
                ->where('trainer_id',$trainer_id);
                // ->groupBy('trainer_id');

        $recurring = $query2->get();

        if(isset($recurring)){
        	foreach($recurring as $key=>$vals){

        		$periodArray[$count] = array(
                    'is_occupied'=>0,
					'time'=> $vals->time,
					'trainer_id' =>  $vals->trainer_id,
					'id' =>  $vals->id,
					'date' =>  $vals->date,
					'type' => 'recurring'
 
        		);
				$count++;
        	}

		}
// !! -- recurring event !!--//		
// !! -- recurring event !!--//		
	
	
		// return $periodArray;
		$data = null;
	        
        $data = array_values(array_intersect_key( $periodArray , array_unique( array_map('serialize' , $periodArray ) ) ));
         return $data;
        
}
function checkTimeExist($time_array,$key){

    $val = array_search($key, array_column($time_array, 'time'));
    if($val > -1){
    	return $val;
    }
    return false;
}
function checkIsoccupied($time_array,$key){
    $val = array_search($key, array_column($time_array, 'is_occupied'));
    
    if($val != false){

    	return true;
    }
    return false;
}
function array_key_exists_r($needle, $haystack)
{
    $result = array_key_exists($needle, $haystack);
    if ($result) return $result;
    foreach ($haystack as $v) {
        if (is_array($v)) {
            $result = array_key_exists_r($needle, $v);
        }
        if ($result) return $result;
    }

    dd($result->toArray());
    return $result;
}
function trainerRatingsOrder(){
	$rearrangeArray=array();
	$order=\DB::table('tbl_trainer_ratings as r')
                    ->select(['trainer_id'])
                    ->groupBy('trainer_id')
                	->havingRaw('SUM(star_ratings) > ?', [3])
                    ->get()
                    ->toArray();
    if(isset($order)){
    	foreach ($order as $key => $value) {
    		$rearrangeArray[$key] = $value->trainer_id;
    	}
    }

    return $rearrangeArray;                
}
function is_favourite($user_id,$trainer_id){
	$data = \DB::table('tbl_favourite_trainers')
                    ->where('trainer_id',$trainer_id)
                    ->where('user_id',$user_id)
                	->first();
    if(isset($data)){
    	return true;
    }   
    return false;         	
}
function getTrainerFavouriteList(){
	$rearrangeArray=array();
	$order=\DB::table('tbl_favourite_trainers')
                    ->select(['trainer_id'])
                    ->where('user_id',Session::get('user.id'))
                    ->get()
                    ->toArray();
    if(isset($order)){
    	foreach ($order as $key => $value) {
    		$rearrangeArray[$key] = $value->trainer_id;
    	}
    }

    return $rearrangeArray; 
}

?>