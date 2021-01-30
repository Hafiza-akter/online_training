<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Model\PurchasePlan;



class PurchasePlanController extends Controller
{

    public function planList(){
        $planList = PurchasePlan::orderBy('id','DESC')->get();
        // dd($trainerList);
        return view('admin.plan_purchase.list')->with('planList',$planList);
    }
    public function planEdit($id){
        $data = PurchasePlan::Where('id',$id)->first();
        return view('admin.plan_purchase.edit')->with('plan',$data);     
    }

    public function planEditSubmit(Request $request){
        // dd($request);
        $validateData = $request->validate([
            'name' => 'required',
            'objective' => 'required',
            'times_per_week' => 'required',
        ]);
        $id = $request->input('id');
        $data = PurchasePlan::Where('id',$id)->first();
        $data->name = $request->input('name');
        $data->objective = $request->input('objective');
        $data->times_per_week = $request->input('times_per_week');
        $data->cost_per_month = $request->input('cost_per_month');
        $data->percentage_1mo = $request->input('percentage_1mo');
        $data->percentage_3mo = $request->input('percentage_3mo');
        if($request->input('status')){
            $data->status = 1;
        }
        else{
            $data->status = 0;
        }
        $data->save();
        return redirect()->route('purchase.plan.list')->with('message', 'Edited successfully!');

    }
   

}