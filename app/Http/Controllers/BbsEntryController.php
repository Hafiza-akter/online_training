<?php

namespace App\Http\Controllers;

use App\BbsEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BbsEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        return view("bbs_entries", ["user" => $user]);
    }

    public function post(Request $request){
        $user = Auth::user();
        $user->start_of_set = true;                 //フラグの状態を書き換える
        $user->count_per_set = $request->input('count_per_set');    //回数を書き換える
        $user->save();
        return view("bbs_entries", ["user" => $user]);
    }
}
