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
?>