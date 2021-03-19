<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Hash;
use Session;

use App\Events\NewUserRegisteredEvent;
use Carbon\Carbon;
use App\Model\User;
use App\Model\Inquery;


use DateTime;
use DateInterval;

class InquiryController extends Controller
{
    
    public function inquiry(Request $request){
        $user = Session::get('user');
        $user_inquery = Inquery::Where('email',$user->email)
                                ->orderBy('id','desc')
                                ->get();
        // dd($user_inquery);
        return view('pages.inquery')
        ->with('user',Session::get('user'))
        ->with('inqueryList',$user_inquery)
        ->with('isActive','inquiry');

    }

    public function inquirysubmit(Request $request){
        $validateData = $request->validate([
            'title' => 'required|max:255',
            'message' => 'required',
        ]);
            $email = $request->input('email');
            $title = $request->input('title');
            $message = $request->input('message');
            $user_id = $request->input('user_id');
            $user = User::Where('id',$user_id)->first();
            $user_name = $user->name;

            $inquery = new Inquery();
            $inquery->name = $user_name;
            $inquery->email = $email;
            $inquery->title = $title;
            $inquery->message = $message;
            $inquery->save();
            return redirect()->route('inquiry')->with('message','Successfully sent your query.');

            


    }
    public function inquirysubmittoppage(Request $request){
        $validateData = $request->validate([
            'title' => 'required|max:255',
            'message' => 'required|max:500',
            'email' => 'required|email',
            'name' => 'required|max:30',
        ]);
            $email = $request->input('email');
            $title = $request->input('title');
            $message = $request->input('message');
            $user_name = $request->input('name');

            $inquery = new Inquery();
            $inquery->name = $user_name;
            $inquery->email = $email;
            $inquery->title = $title;
            $inquery->message = $message;
            $inquery->save();
            return redirect()->back()->with('swal','success')->with('message','Successfully sent your query.');

            


    }
     

}
