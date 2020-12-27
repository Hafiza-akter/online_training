<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;



class TrainerController extends Controller
{
    public function trainerView(){
        return view('pages.trainer_details');
    }
  

}