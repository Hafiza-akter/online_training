<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Model\Setting;
use App\Model\TrainerSetupData;



class TrainerSetupDataController extends Controller
{
    public function index(){
        $list = TrainerSetupData::Orderby('id','desc')->get();
        // dd($list);
        return view('admin.trainersetupdata.list')->with('trainersetupdataList',$list) 
                                            ->with('page','trainersetupdata');

    }

    
    
    public function trainersetupdataAdd(){
        return view('admin.trainersetupdata.add')
        ->with('page','trainersetupdata');

    }
    public function trainersetupdataAddSubmit(Request $request){
        $validateData = $request->validate([
            'name' => 'required',
        ]);
        $equipment = new TrainerSetupData();
        $equipment->name = $request->input('name');
        $equipment->type = $request->input('type');
        if($request->input('status')){
            $equipment->status = 1;
        }
        else{
            $equipment->status = 0;
        }
        $equipment->save();
        return redirect()->route('admin.trainersetupdata')->with('message', 'Added successfully!');


    }
    public function trainersetupdataEdit($id){
        $data = TrainerSetupData::Where('id',$id)->first();
        return view('admin.trainersetupdata.edit')->with('data',$data)
        ->with('page','trainersetupdata');


    }
    public function trainersetupdataEditSubmit(Request $request){
        $validateData = $request->validate([
            'name' => 'required',
        ]);
        $equipment = TrainerSetupData::Where('id',$request->input('id'))->first();
        $equipment->name = $request->input('name');
        // $equipment->name = $request->input('type');
        if($request->input('status')){
            $equipment->status = 1;
        }
        else{
            $equipment->status = 0;
        }
        $equipment->save();
        return redirect()->route('admin.trainersetupdata')->with('message', 'Edited successfully!');


    }
    

}