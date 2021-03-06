<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TrainerSchedule extends Model
{
    protected $table = 'tbl_trainer_schedules';
    protected $guarded = [];
    public function timeAvailableColor($time_array){

    	// !empty($time) && Carbon\Carbon::parse($time->time)->format('H') == $i ? 'color-t' : '' }}
    	return 'test';
    }

    public function getUser(){
        return $this->belongsTo('App\Model\User','user_id');
    }
    public function getTrainer(){
        return $this->belongsTo('App\Model\Trainer','trainer_id');
    }
}
