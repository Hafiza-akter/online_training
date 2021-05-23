<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Hash;

use App\Model\Admin;
use App\Model\Trainer;



class TrainerController extends Controller
{
    
   public function trainerList(){
        $trainerList = Trainer::orderBy('id','DESC')->get();
        // dd($trainerList);
        return view('admin.trainer_manage.list')->with('trainerList',$trainerList)
                                                ->with('page','trainer');
    
   }
   public function trainerEdit($id){
    $data = Trainer::Where('id',$id)->first();
    return view('admin.trainer_manage.edit')->with('trainer',$data); 
   }
   public function trainerEditSubmit(Request $request){
    $validateData = $request->validate([
        'email' => 'required',
        'unit_price' => 'required',
    ]);
    $id = $request->input('id');
    $data = Trainer::Where('id',$id)->first(); 
    $data->first_name = $request->input('first_name');
    $data->first_phonetic = $request->input('first_phonetic');
    $data->family_name = $request->input('family_name');
    $data->email = $request->input('email');
    $data->prefecture = $request->input('prefecture');
    $data->city = $request->input('city');
    $data->zip_code = $request->input('zip_code');
    $data->intro = $request->input('intro');
    $data->unit_price = $request->input('unit_price');
    $data->interface = $request->input('interface');
    $data->certification = $request->input('certification');
    if($request->input('status')){
        $data->status = 1;
    }
    else{
        $data->status = 0;
    }
    $data->save();
    return redirect()->route('trainer.list')->with('message', 'Edited successfully!');

   }
   public function trainerView($id){
        $trainer_id = $id;
        $data = Trainer::Where('id',$trainer_id)->first();
        return view('admin.trainer_manage.details')->with('trainer',$data); 

    }

}