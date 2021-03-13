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
use App\Model\TrainerRecurringSchedule;


use DateTime;
use DateInterval;

class ScheduleController extends Controller
{

    public function calendar(Request $request){

    	if($request->type == 'month'){
    		$view ='pages.trainer.month';
    	}
    	if($request->type == 'week'){
    		$view ='pages.trainer.week';
    	}
    	if($request->type == 'week_all'){
    		$view ='pages.trainer.week_all';
    	}
    	
        $parsedArray = array();
        $isActive = "schedule";
        $count=0;
    	$schedule =TrainerSchedule::where('trainer_id',Session::get('user')->id)
                    ->where('status',NULL)
                    ->get();
        $recurring =TrainerRecurringSchedule::where('trainer_id',Session::get('user')->id)
                    ->where('status',NULL)
                    ->get();
         // dd($compareArray);
        if($recurring){

            foreach($recurring as $key=>$value){
                // dd($value->dow);
                // $found=$this->filter_array_value(Carbon::parse($value->time)->format('H:i:s'),$compareArray);
                    // $rv = $this->check_duplication($value,$schedule);
                    // dd($rv);
                    // if($rv == 'not_found'){
                        $parsedArray[$count]['title']=Carbon::parse($value->time)->format('H:i')." - ".Carbon::parse($value->time)->addMinutes(60)->format('H:i');
                        $parsedArray[$count]['id']=$value->id;
                        $parsedArray[$count]['daysOfWeek']=array($value->dow);
                        $parsedArray[$count]['startTime']=Carbon::parse($value->time)->format('H:i:s');
                        $parsedArray[$count]['endTime']=Carbon::parse($value->time)->addMinutes(60)->format('H:i:s');
                        $parsedArray[$count]['exclude']=$value->exclude;
                        $parsedArray[$count]['start_date']=$value->start_date;
                        $parsedArray[$count]['extendedProps']=array(
                            'type' => 'recurring',
                            'startTime' => Carbon::parse($value->time)->format('H:i:s'),
                            'exdate' => $value->exclude,
                            'dow' => $value->dow

                        );
                        if($request->type == 'week' || $request->type == 'week_all'){
                            // $parsedArray[$count]['display'] = 'background';
                        } 
                            
                        $parsedArray[$count]['className'] = 'tblue';
                        $parsedArray[$count]['type'] = 'recurring';
                        $parsedArray[$count]['time'] = Carbon::parse($value->time)->format('H:i:s');
                        if($request->type == 'week' || $request->type == 'week_all'){
                            $parsedArray[$count]['display'] = 'background';
                        }
                        $count++;
                    // }

                
            }
         }
           

    	if($schedule && $view != 'pages.trainer.week_all'){
    		foreach ($schedule as $key => $value) {

    			if($value->trainer_id == Session::get('user')->id){

            //         "title": "12.06 am - 1.06 am",
            // "start": "2021-01-25T00:30:00",
            // "end": "2021-01-25T01:30:00",
            //   'className' : 'tblue',
            //   'textColor' : '#ffffff'

                    $y=Carbon::parse($value->date)->format('Y-m-d');
                    $t=Carbon::parse($value->time)->format('H:i:s');
                    $tt = Carbon::parse($value->time)->addMinutes(60)->format('g:i A');

                    $title=Carbon::parse($value->time)->format('H:i')." - ".Carbon::parse($value->time)->addMinutes(60)->format('H:i');
                    $parsedArray[$count]['title'] = $title;
                    $parsedArray[$count]['id'] = $value->id;
                    $parsedArray[$count]['is_occupied'] = $value->is_occupied;
                    $parsedArray[$count]['date_data'] = Carbon::parse($value->date)->format('Y-m-d');

                    $parsedArray[$count]['time'] = $t;
                    $parsedArray[$count]['start'] = Carbon::parse($value->date)->format('Y-m-d')."T".$t;
                    $parsedArray[$count]['end'] = Carbon::parse($value->date)->format('Y-m-d')."T".$tt;
		    		$parsedArray[$count]['extendedProps']=array(
                        'type' => 'normal',
                        'startTime' =>  $t,
                        'date' =>  Carbon::parse($value->date)->format('Y-m-d')
                    );
                    $parsedArray[$count]['type'] = 'normal';

                    if($value->is_occupied === 1){
                         $parsedArray[$count]['className'] = 'tred';

		    		}else{
		    			 $parsedArray[$count]['className'] = 'tblue';

		    		}

                    $parsedArray[$count]['textColor'] = '#ffffff';
                    if($value->is_occupied === 1){

                    }else{
                    	if($request->type == 'week' || $request->type == 'week_all'){
                    		$parsedArray[$count]['display'] = 'background';
                    	}
                    	
                    }
    			}

                $count++;
    		}
    	}
       
         // dd($parsedArray);

        $listSchedule =TrainerSchedule::where('trainer_id',Session::get('user')->id)
        ->where('is_occupied',1)->orderBy('date','DESC')
        ->get();
    	return view($view)
        ->with('isActive',$isActive)
        ->with('nschedule',json_encode($schedule,true))
        ->with('schedule',json_encode($parsedArray,true))
        ->with('listSchedule',$listSchedule)->with('gridView','dayGridMonth');
    }
    public function filter_array_value($time,$compareArray){
        // dd($parsedArray);
        foreach($compareArray as $val){
            if($val['time'] === $time){
                return true;
            }
        }
        return false;
    }

    public function check_duplication($item,$arr){
      
        if(count($arr) > 0){
            foreach($arr as $val){
                
                if($item->dow == Carbon::parse($val->date)->dayOfWeek && $item->time == $val->time){
                    return 'found';
                }else{
                    return 'not_found';
                }
                // if(Carbon::parse($val->date)->dayOfWeek == (int) $item->dow && $val->time == $item->time){
                //     dd('found');
                //     return "found";
                // }else{
                //     return "not_found";
                // }

                // $fnd=TrainerRecurringSchedule::where('dow',$dow)
                // ->where('time',$val->time)
                // ->get()->first();
                // if($fnd){
                //     return "found";
                // }else{
                //     return "not_found";
                // }
                
            }
        }else{
             return "not_found";
        }

       
    }
    public function scheduleSubmit(Request $request){


    	// $arrT=explode('-',$request->start_time);
        // $time= Carbon::parse('14:27')->format('H:i:s');
    	// $ftime = $time->format('H:i:s');
        // dd($time);
    	// $ftime = $arrT[0];


        // validation for unique time set up 

        $allDateSchedule = TrainerSchedule::where('date',$request->date)->get();

        if($allDateSchedule){
            foreach($allDateSchedule as $val){


                $start =strtotime($val->time);

                $timestamp = strtotime($val->time) + 60*60;
                $end = strtotime(date('H:i:s', $timestamp));

                $ctime=  strtotime($request->start_time.':00') + 60*60; 
               
                if ( $ctime > $start && $ctime < $end ) {
                    return redirect()->back()->with('errors_m','Time slot is not avaliable');

                }


            }

        }


    	$schedule = new TrainerSchedule();
    	$schedule->date =$request->date;
    	$schedule->trainer_id =$request->trainer_id;
    	$schedule->time =Carbon::parse($request->start_time)->format('H:i:s');
    	$schedule->save();

    	return redirect()->route('trainerTime.view',$request->date)
    	->with('message','Schedule time set succesfully')
    	->with('selected_date',$request->date);

    }

    public function schedule(Request $request){
        $initialDate="FA";
        $Error="";
        $setUpData = \App\Model\Setting::get()->first();

        // recurring schedule registration//
        if($request->type=='recuring_event'){
            $arr=json_decode($request->list);
            if(count($arr) > 0){
                foreach($arr as $index=>$val){
                    // dd($val->daysOfWeek[0]);

                    $allDateSchedule = TrainerRecurringSchedule::where('time',$val->startTime)
                                    // ->where('start_date',$val->startRecur)
                                    ->where('status',NULL)
                                    ->where('dow',$val->daysOfWeek[0])
                                    ->where('trainer_id',$request->trainer_id)
                                    ->get()->first();
                    if(!$allDateSchedule){
                        $scheduleU = new TrainerRecurringSchedule();
                        $scheduleU->trainer_id =$request->trainer_id;
                        $scheduleU->time =$val->startTime;
                        $scheduleU->unique_id =$val->unique_id;
                        $scheduleU->start_date =$val->startRecur;
                        $scheduleU->dow =$val->daysOfWeek[0];

                        $scheduleU->save();
                    }
                    
                }
                return redirect()->back()
                    ->with('message','予約が完了しました。 ');
            }else{
                return redirect()->back()
                    ->with('message','トレーニング時間を先に選択してください。 ');
            }
            
        }


        if($request->type=='initial_registration'){
            $string="";
            $arr=json_decode($request->list);
            if(count($arr) > 0){
                foreach($arr as $index=>$val){

                    $isToday=Carbon::parse($val->start)->isToday();
                    $isPast=Carbon::parse($val->start)->isPast();
       
                    if(!$isToday && $isPast){
                        $string = "-- 過去の日付が含まれていたため、いくつかのスケジュールが作成に失敗しました。";
                        continue;
                    }

                    $allDateSchedule = TrainerSchedule::where('date',Carbon::parse($val->start)->format('Y-m-d'))
                                    ->where('trainer_id',$request->trainer_id)
                                    ->where('status',NULL)
                                    ->where('time',Carbon::parse($val->start)->format('H:i:s'))
                                    ->get()->first();
                    if(!$allDateSchedule){

                        // filtering //
                       

                        $scheduleU = new TrainerSchedule();
                        $scheduleU->date =Carbon::parse($val->start)->format('Y-m-d');
                        $scheduleU->trainer_id =$request->trainer_id;
                        $scheduleU->time =Carbon::parse($val->start)->format('H:i:s');
                        // dd($scheduleU);
                        $scheduleU->save();


                    }
                    
                }
                return redirect()->back()
                    ->with('message','予約が完了しました。 !! '.$string);
            }else{
                return redirect()->back()
                    ->with('message','Please select training time first! ');
            }
            

        }
        if($request->type == 'weekinsert'){
            
            $arr = explode(',',$request->date_array[0]);
            if(count($arr) > 0){

                if(count($arr) == 1){
                    $initialDate = $arr[0];
                }

                $Error="";
                foreach($arr as $key=>$val){

                    $uniqueSlot=$this->checkUniqueTimeSlot($val,$request->start_time);
                    if($uniqueSlot === 'FALSE'){

                        $Error .= '<br> Time slot date: '.$val.' time range from '.$request->start_time.' already assigned <br>';
                        if(count($arr) == 1){
                            return redirect()->back()
                            ->with('errors_m','Time slot is not avaliable for '.$request->start_time)
                            ->with('dayGridspecific',$initialDate)
                            ->with('gridView',$request->gridView);
                        }

                        
                    }else{

                        $scheduleU = new TrainerSchedule();
                        $scheduleU->date =$val;
                        $scheduleU->trainer_id =$request->trainer_id;
                        $scheduleU->time =Carbon::parse($request->start_time)->format('H:i:s');
                        $scheduleU->save();
                    }

                    
                }

                if(count($arr) == 1){
                    return redirect()->back()
                    ->with('dayGridspecific',$initialDate)
                    ->with('message','予約が完了しました。 ')->with('gridView',$request->gridView);
                }


            }

             return redirect()->back()
                    ->with('message','予約が完了しました。 ');
                            
        }
        
        if($request->type == 'weekupdate' || $request->type == 'dayupdate' ){

            if(checkPastDate($request->db_date)){
                return redirect()->back()
                 ->with('errors_m','The schedule date has been passed');
            }

            if($request->event_type == 'recurring'){

                     $scheduleU = TrainerRecurringSchedule::where('id',$request->db_schedule_id)->get()->first();
                    // dd($scheduleU);
                    if($scheduleU){
                        $getExcludeData = $scheduleU->exclude;
                        if($getExcludeData != NULL ){
                            $getExcludeData .= ",".$request->db_date;
                        }else{
                            $getExcludeData = $request->db_date;
                        }
                        $scheduleU->exclude = $getExcludeData;
                        $scheduleU->save();
                    }

                    $scheduleUn = new TrainerSchedule();
                    $scheduleUn->date =$request->db_date;
                    $scheduleUn->trainer_id =$request->trainer_id;
                    $scheduleUn->time =Carbon::parse($request->start_time)->format('H:i:s');
                    $scheduleUn->save();
                  return redirect()->back()
                    ->with('dayGridspecific',$initialDate)
                    ->with('message','Reschedule time rescheduled succesfully!! ')
                    ->with('gridView',$request->gridView);
            }

        	$time = Carbon::parse($request->start_time)->format('H:i:s');
        	$existingTime = Carbon::parse($request->db_start_time)->format('H:i:s');
            
            if($time == $existingTime){
                return redirect()->route('traineeCalendar.view')
                ->with('message','Your rescheduled time is same as previous one !');
            }
        	$id = $request->db_schedule_id;
        	$found=TrainerSchedule::where('date',$request->db_date)
        					->where('status',NULL)
        					->where('time',Carbon::parse($request->start_time)->format('H:i:s'))
        					->where('trainer_id',$request->trainer_id)
        					->get()->first();
        	if($found){
                return redirect()->back()
                ->with('errors_m','Time slot is not avaliable for '.$request->start_time)
                ->with('dayGridspecific',$initialDate)
                ->with('gridView',$request->gridView);
            }else{
        		$scheduleU = TrainerSchedule::where('id',$request->db_schedule_id)
        		->get()->first();
	            if($scheduleU){
	                $scheduleU->status ='rescheduled';
	                $scheduleU->save();
	            }
	            

	            $scheduleU = new TrainerSchedule();
	            $scheduleU->date =$request->db_date;
	            $scheduleU->trainer_id =$request->trainer_id;
	            $scheduleU->time =Carbon::parse($request->start_time)->format('H:i:s');
	            $scheduleU->save();
            }
            
            
            return redirect()->back()
                    ->with('dayGridspecific',$initialDate)
                    ->with('message','Reschedule time rescheduled succesfully!! ')
                    ->with('gridView',$request->gridView);
        }

        

        if($request->type == 'weekcancel'){

            if(checkPastDate($request->db_date)){
                return redirect()->back()
                 ->with('errors_m','The schedule date has been passed');
            }
          

            if($request->event_type == 'recurring'){
                
                $scheduleU = TrainerRecurringSchedule::where('id',$request->db_schedule_id)->get()->first();
                // dd($scheduleU);
                if($scheduleU){
                    $getExcludeData = $scheduleU->exclude;
                    if($getExcludeData != NULL ){
                        $getExcludeData .= ",".$request->db_date;
                    }else{
                        $getExcludeData = $request->db_date;
                    }
                    $scheduleU->exclude = $getExcludeData;
                    $scheduleU->save();
                }
            }else{

             

                $scheduleU = TrainerSchedule::find($request->db_schedule_id);

                if($scheduleU){

                    if($scheduleU->is_occupied == 1){
                        if(checkLimitValidation($scheduleU->time,$request->db_date)){
                            return redirect()->back()
                                    ->with('errors_m','You will not able to modify the schedule, because the cacncelation time limit exceed');
      
                        }
                    }
                    $scheduleU->status ='cancelled';
                    $scheduleU->save();
                }
            }

        	
            
            return redirect()->back()                  
                    ->with('dayGridspecific',$initialDate)
                    ->with('message','スケジュールが正常にキャンセルされました。 ')->with('gridView',$request->gridView);
        }

        if($request->type == 'daycancel'){

            
            if(checkPastDate($request->db_date)){
                return redirect()->back()
                 ->with('errors_m','The schedule date has been passed');
            }

            if($request->event_type == 'recurring'){

                $scheduleU = TrainerRecurringSchedule::where('id',$request->db_schedule_id)->get()->first();
                if($scheduleU){
                    $getExcludeData = $scheduleU->exclude;
                    if($getExcludeData != NULL ){
                        $getExcludeData .= ",".$request->db_date;
                    }else{
                        $getExcludeData = $request->db_date;
                    }
                    $scheduleU->exclude = $getExcludeData;
                    $scheduleU->save();
                }
            }else{

                
                $scheduleU = TrainerSchedule::where('id',$request->db_schedule_id)->get()->first();
                if($scheduleU){
                    if($scheduleU->is_occupied == 1){
                        if(checkLimitValidation($scheduleU->time,$request->db_date)){
                            return redirect()->back()
                            ->with('errors_m','You will not able to modify the schedule, because the cacncelation time limit exceed');
          
                        }
                    }
                    $scheduleU->status ='cancelled';
                    $scheduleU->save();
                }
            }
            
            

            return redirect()->back()
                    ->with('message','スケジュールが正常にキャンセルされました。 ')->with('gridView',$request->gridView);
        }

        if($request->type == 'recurring_delete'){
            $scheduleU = TrainerRecurringSchedule::where('id',$request->db_schedule_id)->get()->first();
            if($scheduleU){
                $scheduleU->status ='cancelled';
                $scheduleU->save();
            }
            

            return redirect()->back()
                    ->with('message','スケジュールが正常にキャンセルされました。 ')->with('gridView',$request->gridView);
        }
        if($request->type == 'recurring_delete_exclude'){
            $scheduleU = TrainerRecurringSchedule::where('id',$request->db_schedule_id)->get()->first();
            if($scheduleU){
                $getExcludeData = $scheduleU->exclude;
                if($getExcludeData != NULL ){
                    $getExcludeData .= ",".$request->db_date;
                }else{
                    $getExcludeData = $request->db_date;
                }
                $scheduleU->exclude = $getExcludeData;
                $scheduleU->save();
            }
            

            return redirect()->back()
                    ->with('message','スケジュールが正常にキャンセルされました。 ')->with('gridView',$request->gridView);
        }
        

        return redirect()->back();
    }
    public function checkLimitValidation($time,$date){
        $setUpData = \App\Model\Setting::get()->first();
      // not to modify the past date and if limit time exceed
        // not to modify the past date and if limit time exceed
        $end= new Carbon($date." ".$time);
        $start = Carbon::now();
      
        $totalDuration = $start->diffInMinutes($end,false); 
        if($totalDuration < $setUpData->cancellation_time){
            return true ; 
        }
        return false;
        // ---------------------------------------------------
        // ---------------------------------------------------
    }
    public function scheduleDelete(Request $request){
    	$arr=json_decode($request->dlist);
        // dd($arr);
        if(count($arr) > 0){
            foreach($arr as $index=>$val){
                // dd($val->extendedProps->type);
                if($val->extendedProps->type == 'recurring'){
                    // TrainerRecurringSchedule::where('id',$val->id)->delete();
                    $scheduleU = TrainerRecurringSchedule::where('id',$val->id)->get()->first();
                    if($scheduleU){
                        if($val->db_date != 'Nan'){
                            $getExcludeData = $scheduleU->exclude;
                            if($getExcludeData != NULL ){
                                $getExcludeData .= ",".$val->db_date;
                            }else{
                                $getExcludeData = $val->db_date;
                            }
                            $scheduleU->exclude = $getExcludeData;
                        }else{
                            $scheduleU->status ='cancelled';
                        }
                        $scheduleU->save();
                    }
                }else{
                    $scheduleU = TrainerSchedule::where('id',$val->id)->get()->first();
                    if($scheduleU){
                        $scheduleU->status ='cancelled';
                        $scheduleU->save();
                    }
                }
            }
            return redirect()->back()
                ->with('message','スケジュールが正常に削除されました。 ');
        }else{
            return redirect()->back()
                ->with('message','最初にトレーニング時間を選んでください。 ');
        }
    }

    public function checkUniqueTimeSlot($date,$time){
        $allDateSchedule = TrainerSchedule::where('status',NULL)->where('date',$date)->where('trainer_id',Session::get('user')->id)->get();
        

        if($allDateSchedule){
            foreach($allDateSchedule as $val){

            
                $start =strtotime($val->time);

                $end = strtotime($val->time) + 60*60;

                $ctime=  strtotime($time); 
                $ctimeH=  strtotime($time) + 60*60; 
                if($ctime == $start){
                     return "FALSE";
                }

                if($ctime < $start && ($ctimeH > $start &&  $ctimeH < $end)){
                     return "FALSE";
                }

                if($ctime > $start &&  $ctime < $end){
                     return "FALSE";
                }


            }

        }
        return "TRUE";
    }
    public function logout(){
        session()->flush();
        return redirect()->route('trainerLogin');
    }
    
    public function trainerScheduleDelete($id){
        TrainerSchedule::Where('id',$id)->delete();
        return redirect()->back()->with('message','スケジュールが正常に削除されました。');


    }
   
  

}