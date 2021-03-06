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
use App\Model\TrainerEquipment;


use DateTime;
use DateInterval;

class TrainerController extends Controller
{
    public function trainerView(){
        return view('pages.trainer_details');
    }
    public function scheduleCalendar(Request $request){
        $isActive = "schedule";
    	$schedule =TrainerSchedule::where('trainer_id',Session::get('user')->id)
        ->where('status',NULL)
        ->get();
    	$parsedArray = array();

    	if($schedule){
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

                    $title=Carbon::parse($value->time)->format('g:i A')." - ".$tt;
                    $parsedArray[$key]['title'] = $title;
                    $parsedArray[$key]['id'] = $value->id;
                    $parsedArray[$key]['date_data'] = Carbon::parse($value->date)->format('Y-m-d');

                    $parsedArray[$key]['start'] = Carbon::parse($value->date)->format('Y-m-d')."T".$t;
                    $parsedArray[$key]['end'] = Carbon::parse($value->date)->format('Y-m-d')."T".$tt;
		    		if($value->is_occupied === 1){
                         $parsedArray[$key]['className'] = 'tred';

		    		}else{
		    			 $parsedArray[$key]['className'] = 'tblue';

		    		}
                        $parsedArray[$key]['textColor'] = '#ffffff';
                        // $parsedArray[$key]['display'] = 'background';
    			}

    		}
    	}
        // dd($parsedArray);
        $listSchedule =TrainerSchedule::where('trainer_id',Session::get('user')->id)->orderBy('id','DESC')->get();
    	return view('pages.trainer.calendar')
        ->with('isActive',$isActive)
        ->with('schedule',json_encode($parsedArray,true))
        ->with('listSchedule',$listSchedule)->with('gridView','dayGridMonth');
    }
    public function scheduleCalendarSubmit(Request $request){
    	// time 
    	$time =TrainerSchedule::where('date',$request->selected_date)->where('trainer_id',Session::get('user')->id)->get();

    	return view('pages.trainer.time')
    	->with('selected_date',$request->selected_date)
    	->with('time',$time);
    }
    
    public function scheduleTime(Request $request){
    	$time =TrainerSchedule::where('date',$request->selected_date)->get();
    	return view('pages.trainer.time')
    	->with('selected_date',$request->selected_date)
    	->with('time',$time);
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
        if($request->type=='initial_registration'){
            $arr=json_decode($request->list);
            if(count($arr) > 0){
                foreach($arr as $index=>$val){

                    $allDateSchedule = TrainerSchedule::where('date',Carbon::parse($val->start)->format('Y-m-d'))
                                    ->where('trainer_id',$request->trainer_id)
                                    ->where('time',Carbon::parse($val->start)->format('H:i:s'))
                                    ->get()->first();
                    if(!$allDateSchedule){
                        $scheduleU = new TrainerSchedule();
                        $scheduleU->date =Carbon::parse($val->start)->format('Y-m-d');
                        $scheduleU->trainer_id =$request->trainer_id;
                        $scheduleU->time =Carbon::parse($val->start)->format('H:i:s');
                        // dd($scheduleU);
                        $scheduleU->save();
                    }
                    
                }
                return redirect()->back()
                    ->with('message','Schedule time set succesfully!! ');
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
                    ->with('message','Schedule time set succesfully!! ')->with('gridView',$request->gridView);
                }


            }

             return redirect()->back()
                    ->with('message','Schedule time set succesfully!! ');
                            
        }
        
        if($request->type == 'weekupdate'){

            $arr = explode(',',$request->date_array[0]);
            if(count($arr) > 0){

                if(count($arr) == 1){
                    $initialDate = $arr[0];
                }
                foreach($arr as $key=>$val){

                        $uniqueSlot=$this->checkUniqueTimeSlot($val,$request->start_time);
                        if($uniqueSlot === 'FALSE'){

                            // $Error .= '<br> Time slot date: '.$val.' time range from '.$request->start_time.' already assigned <br>';
                             $Error .= '<br> Time slot date: '.$val.' time range from '.$request->start_time.' already assigned <br>';
                            if(count($arr) == 1){
                                return redirect()->back()
                                ->with('errors_m','Time slot is not avaliable for '.$request->start_time)
                                ->with('dayGridspecific',$initialDate)
                                ->with('gridView',$request->gridView);
                            }
                        }else{
                            $scheduleU = TrainerSchedule::where('date',$val)->where('time',Carbon::parse($request->db_start_time)->format('H:i:s'))->where('trainer_id',$request->trainer_id)->get()->first();
                            if($scheduleU){
                                $scheduleU->status ='rescheduled';
                                $scheduleU->save();
                            }
                            

                            $scheduleU = new TrainerSchedule();
                            $scheduleU->date =$val;
                            $scheduleU->trainer_id =$request->trainer_id;
                            $scheduleU->time =Carbon::parse($request->start_time)->format('H:i:s');
                            $scheduleU->save();
                        }
                    
                }
            }
            
            return redirect()->back()
                    ->with('dayGridspecific',$initialDate)
                    ->with('message','Reschedule time set succesfully!! ')->with('gridView',$request->gridView);
        }

        if($request->type == 'dayupdate'){


                        $uniqueSlot=$this->checkUniqueTimeSlot($request->db_date,$request->start_time);
                        if($uniqueSlot === 'FALSE'){
                            return redirect()->back()
                                    ->with('errors_m','Time slot is not avaliable')->with('gridView',$request->gridView);
                        }
                    

                        $scheduleU = TrainerSchedule::where('id',$request->db_schedule_id)->get()->first();
                        $scheduleU->status ='rescheduled';
                        $scheduleU->save();

                        $scheduleU = new TrainerSchedule();
                        $scheduleU->date =$request->db_date;
                        $scheduleU->trainer_id =$request->trainer_id;
                        $scheduleU->time =Carbon::parse($request->start_time)->format('H:i:s');
                        $scheduleU->save();
                    
            return redirect()->back()
                    ->with('message','Reschedule time set succesfully!! ')->with('gridView',$request->gridView);
        }

        if($request->type == 'weekcancel'){

            $arr = explode(',',$request->date_array[0]);
            if(count($arr) > 0){
                if(count($arr) == 1){
                    $initialDate = $arr[0];
                }
                foreach($arr as $key=>$val){

                        $scheduleU = TrainerSchedule::where('date',$val)->where('time',Carbon::parse($request->db_start_time)->format('H:i:s'))->where('trainer_id',$request->trainer_id)->get()->first();
                        if($scheduleU){
                            $scheduleU->status ='cancelled';
                            $scheduleU->save();
                        }
                        

                }
            }

            
            return redirect()->back()                  
                    ->with('dayGridspecific',$initialDate)
                    ->with('message','Schedule cancelled  succesfully!! ')->with('gridView',$request->gridView);
        }

        if($request->type == 'daycancel'){

            $scheduleU = TrainerSchedule::where('id',$request->db_schedule_id)->get()->first();
            if($scheduleU){
                $scheduleU->status ='cancelled';
                $scheduleU->save();
            }
            

            return redirect()->back()
                    ->with('message','Schedule cancelled  succesfully!! ')->with('gridView',$request->gridView);
        }

        return redirect()->back();
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
    public function trainerDetails(Request $request){
    	$trainerData = Trainer::find($request->id);
    	return view('pages.trainee.trainer_details')->with('trainerData',$trainerData);
    }
     public function trainerselect(Request $request){
        $trainerData = Trainer::find($request->id);
        return view('pages.trainee.trainer_details_by_time')
        ->with('date',$request->date)
        ->with('time',$request->time)
        ->with('trainerData',$trainerData);
    }
    

    public function trainerScheduleDelete($id){
        TrainerSchedule::Where('id',$id)->delete();
        return redirect()->back()->with('message','Schedule delete successful');


    }
    public function psettings(Request $request){

        $user = Trainer::where('id',Session::get('user.id'))->first();

        return view('pages.trainer.p-settings')
        ->with('user',$user)
        ->with('equipment',Equipment::get())->with('isActive','p-settings');

    }
    public function psettingsSubmit(Request $request){


        if($request->action_type == 'password_update'){

            $trainee = Trainer::find($request->user_id);
            if( (!Hash::check($request->input('oldpassword'),$trainee->password))){
                return redirect()->back()->with('message','Your Previous Password did not match');
            }

            $trainee->password = Hash::make($request->input('password'));

            $trainee->save();
            return redirect()->back()
            ->with('success','Password update succesfully');
        }
        if($request->action_type == 'info_update'){

              $validateData = $request->validate([

            'first_name' => 'required'
            // 'fat' => 'required',
        ]);

            $trainer = Trainer::find($request->user_id);

            $trainer->first_name = $request->input('first_name');
            $trainer->first_phonetic = $request->input('first_phonetic');

            $trainer->family_name = $request->input('family_name');
            $trainer->family_phonetic = $request->input('family_phonetic');
            
            $trainer->prefecture = $request->input('prefecture');

            $trainer->address_line = $request->input('address');
            $trainer->zip_code = $request->input('zip_code');
            $trainer->city = $request->input('city');
            $trainer->phone = $request->input('phone');
            $trainer->intro = $request->input('intro');
            $trainer->photo_path = $request->input('photo_path');
            $trainer->unit_price = $request->input('unit_price');
            $trainer->certification = $request->input('certification');
            $trainer->interface = $request->input('interface');

            // dd($request->hasFile('image'));
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = rand(1, 9000).strtotime("now");
                $file->move(public_path() . '/images/', $filename . '_trainer_image' . '.' . $file->getClientOriginalExtension());
                $path = $filename . '_trainer_image' . '.' . $file->getClientOriginalExtension();
                $imgfullPath = $path;
                $trainer->photo_path = $imgfullPath;
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

            return redirect()->back()
            ->with('success','Profile update succesfully');
        }
        

    }
  

}