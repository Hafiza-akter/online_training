<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $table = 'tbl_trainings';
    protected $guarded = [];
    public function getExerciseData(){
        return $this->hasMany('App\Model\Exercise','training_id');
    }

}
