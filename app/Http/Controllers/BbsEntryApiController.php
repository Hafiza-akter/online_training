<?php

namespace App\Http\Controllers;

use App\BbsEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;
use App\Events\PublicBbsEntriesEvent;
use App\Events\PrivateBbsEntriesEvent;

class BbsEntryApiController extends Controller
{
    /**
     * トレーニングのセットを開始するフラグの状態を取得する
     * Api tokenを用いたUser認証を使用
     * @return \Illuminate\Http\Response
     */
    public function startOfSet()
    {
        $user = Auth::user();
        $flag = $user->start_of_set;

        if($flag){
            $user->start_of_set = false;    //フラグの状態を書き換える
            $user->save();
        }

        return json_encode(["flag" => $flag, "count" => $user->count_per_set]);
    }

    /**
     * デバイスから送信されてくる回数と時間の情報をデータベースに保存する
     * Api tokenを用いたUser認証を使用
     * push通知によるUIへの反映
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // JSONを変換する
        $data = json_decode(file_get_contents('php://input'));

        $user = Auth::user();
        $exists = BbsEntry::where('user_id', $user->id)->where('date', $data->date)->exists();

        if($exists){
            //データがある
            $old = BbsEntry::where('user_id', $user->id)->where('date', $data->date)->where('count', $data->count)->first();
            if($old != null){
                //存在している
                $old->time = $data->time; //時間を書き換える
                $old->save();
            }
            else{
                $entry = new BbsEntry();
                $entry->user_id = $user->id;
                $entry->date = $data->date;
                $entry->count = $data->count;
                $entry->time = $data->time;
                $entry->save();
            }
        }
        else{
            //データがない
            $entry = new BbsEntry();
            $entry->user_id = $user->id;
            $entry->date = $data->date;
            $entry->count = $data->count;
            $entry->time = $data->time;
            $entry->save();
        }

        //publicのPush通知(実験)
        //event(new PublicBbsEntriesEvent(["date" => $data->date, "list" => BbsEntry::where('user_id', $user->id)->where('date', $data->date)->get()]));

        //privateのPush通知
        event(new PrivateBbsEntriesEvent($user->id, ["date" => $data->date, "list" => BbsEntry::where('user_id', $user->id)->where('date', $data->date)->get()]));

        return json_encode($data);
    }

}
