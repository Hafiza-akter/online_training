<?php 
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
function BMRcalculation($gendar,$weight,$length,$age){

	$setUpData = \App\Model\Setting::get()->first();
	if($gendar === 'male'){
		$bmr_gender_coefficient = $setUpData->bmr_male_coefficient;
		$bmr_gender_offset = $setUpData->bmr_male_offset;

	}else{
		$bmr_gender_coefficient = $setUpData->bmr_female_coefficient;
		$bmr_gender_offset = $setUpData->bmr_female_offset;

	}
	
	dd($bmr_gender_coefficient);
	$result = ($setUpData->bmr_weight_coefficient*$setUpData->bmr_weight_offset*$weight)
			+($setUpData->bmr_length_coefficient*$setUpData->bmr_length_offset*$length)
			+($setUpData->bmr_age_coefficient*$setUpData->bmr_age_offset*$age)
			+($setUpData->bmr_gender_coefficient+$setUpData->bmr_gender_offset);
	return $result;

	//BMR_weight_coefficient*BMR_weight_offset*weight+BMR_length_coefficient*BMR_length_offset*length+BMR_age_coefficient*BMR_age_offset+BMR_male_coefficient+BMR_male_offse
}
?>