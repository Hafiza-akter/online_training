<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Model\Setting;
use App\Model\RatingsSetup;



class RatingsController extends Controller
{
    public function index(){
        $list = RatingsSetup::Orderby('id','desc')->get();
        // dd($list);
        return view('admin.ratings.list')->with('ratingsList',$list) 
                                            ->with('page','ratings');

    }

    
    
    public function ratingsAdd(){
        return view('admin.ratings.add')
        ->with('page','ratings');

    }
    public function ratingsAddSubmit(Request $request){
        $validateData = $request->validate([
            'name' => 'required',
        ]);
        $equipment = new RatingsSetup();
        $equipment->name = $request->input('name');
        if($request->input('status')){
            $equipment->status = 1;
        }
        else{
            $equipment->status = 0;
        }
        $equipment->save();
        return redirect()->route('admin.ratings')->with('message', 'Added successfully!');


    }
    public function ratingsEdit($id){
        $data = RatingsSetup::Where('id',$id)->first();
        return view('admin.ratings.edit')->with('data',$data)
        ->with('page','ratings');


    }
    public function ratingsEditSubmit(Request $request){
        $validateData = $request->validate([
            'name' => 'required',
        ]);
        $equipment = RatingsSetup::Where('id',$request->input('id'))->first();
        $equipment->name = $request->input('name');
        if($request->input('status')){
            $equipment->status = 1;
        }
        else{
            $equipment->status = 0;
        }
        $equipment->save();
        return redirect()->route('admin.ratings')->with('message', 'Edited successfully!');


    }
    

}