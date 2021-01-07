<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;


class TraineeController extends Controller
{
    public function planPurchase(){
        return view('pages.user_purchase_plan');
    }
    
    

}
