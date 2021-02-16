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


use DateTime;
use DateInterval;

class InquiryController extends Controller
{
    
    public function inquiry(Request $request){

        return view('pages.inquery')
        ->with('user',Session::get('user'))
        ->with('isActive','inquiry');

    }

    public function inquirysubmit(Request $request){

       


    }
     

}
