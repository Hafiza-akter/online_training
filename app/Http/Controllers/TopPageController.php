<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Hash;
use Carbon\Carbon;
use App\Model\Trainer;
use App\Model\Trainee;
use DateTime;
use DateInterval;



class TopPageController extends Controller
{
    public function index(){
        return view('pages.toppage.index_v2');
    }
    public function trainerList(){
    	return view('pages.toppage.trainer_list');
    }

}