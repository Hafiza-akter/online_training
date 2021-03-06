<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Model\Setting;
use App\Model\Equipment;
use App\Model\UserPlanPurchase;



class DashboardController extends Controller
{
    public function index(){
        $data = UserPlanPurchase::Where('id','!=',null)->get();
        return view('admin.dashboard')->with('planList',$data)
                                        ->with('page','dashboard');

    }

    
    public function scheduleManagement(){
        return view(('admin.schedule'));
    }

    public function setting(){
        $settingData = Setting::Where('id','!=',null)->first();
        return view('admin.setting')->with('setupData',$settingData)
                                    ->with('page','equipment');
    }
    public function settingForm(){
        $settingData = Setting::Where('id','!=',null)->first();
        return view('admin.setting_edit')->with('setupData',$settingData)
                                        ->with('page','equipment');
    }
    public function settingSubmit(Request $request){
        $settingData = Setting::Where('id','!=',null)->first();
        $settingData->reminder_mail_info = $request->input('reminder_mail_info');
        $settingData->reminder_mail_time = $request->input('reminder_mail_time');
        $settingData->cancellation_time = $request->input('cancellation_time');
        $settingData->bmr_weight_coefficient = $request->input('bmr_weight_coefficient');
        $settingData->bmr_length_coefficient = $request->input('bmr_length_coefficient');
        $settingData->bmr_age_coefficient = $request->input('bmr_age_coefficient');
        $settingData->bmr_male_coefficient = $request->input('bmr_male_coefficient');
        $settingData->bmr_female_coefficient = $request->input('bmr_female_coefficient');
        $settingData->calory_gained_large_coefficient = $request->input('calory_gained_large_coefficient');
        $settingData->calory_gained_standard = $request->input('calory_gained_standard');
        $settingData->calory_gained_small_coefficient = $request->input('calory_gained_small_coefficient');
        $settingData->ditcoefficient = $request->input('ditcoefficient');
        $settingData->pal_middium_standard = $request->input('pal_middium_standard');
        $settingData->pal_low_standard = $request->input('pal_low_standard');
        $settingData->pal_high_standard = $request->input('pal_high_standard');
        $settingData->traininng_calory_coefficient = $request->input('traininng_calory_coefficient');
        $settingData->adter_burn_coefficient = $request->input('adter_burn_coefficient');
        $settingData->weight_balance_coefficient1 = $request->input('weight_balance_coefficient1');
        $settingData->weight_balance_coefficient2 = $request->input('weight_balance_coefficient2');
        $settingData->save();
        return redirect()->route('admin.setting')->with('message', 'Edited successfully!');
    }

    public function equipmentList(){
        $list = Equipment::Orderby('id','desc')->get();
        // dd($list);
        return view('admin.equipment.list')->with('equipmentList',$list) 
                                            ->with('page','equipment');

        // return view('admin.equipment.list');    
    }
    public function equipAdd(){
        return view('admin.equipment.add');
    }
    public function equipAddSubmit(Request $request){
        $validateData = $request->validate([
            'name' => 'required',
        ]);
        $equipment = new Equipment();
        $equipment->name = $request->input('name');
        if($request->input('status')){
            $equipment->status = 1;
        }
        else{
            $equipment->status = 0;
        }
        $equipment->save();
        return redirect()->route('admin.equipment.list')->with('message', 'Added successfully!');


    }
    public function eqiptEdit($id){
        $data = Equipment::Where('id',$id)->first();
        return view('admin.equipment.edit')->with('data',$data);

    }
    public function equipEditSubmit(Request $request){
        $validateData = $request->validate([
            'name' => 'required',
        ]);
        $equipment = Equipment::Where('id',$request->input('id'))->first();
        $equipment->name = $request->input('name');
        if($request->input('status')){
            $equipment->status = 1;
        }
        else{
            $equipment->status = 0;
        }
        $equipment->save();
        return redirect()->route('admin.equipment.list')->with('message', 'Edited successfully!');


    }
    // public function equipmentDelete($id){
    //     $data = Equipment::Where('id',$id)->delete();
    //     return redirect()->route('admin.equipment.list')->with('message', 'Deleted successfully!');
    // }
    

}