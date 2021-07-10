<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BbsEntry extends Model
{
    //テーブルと関連付ける
    protected $table = "bbs_entries";

    //filableまたはguardedを指定しないとモデル作成できない
    protected $fillable = ['user_id', 'date', 'count', 'time'];
}