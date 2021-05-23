<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Model\Inquery;


use DateTime;
use DateInterval;

class InquiryController extends Controller
{
    
    public function list(){
        $inqueryList = Inquery::orderBy('id','desc')
                                ->get();
        // dd($user_inquery);
        return view('admin.inquery.list')
        ->with('inqueryList',$inqueryList)
        ->with('page','inquery');


    }

     

}
