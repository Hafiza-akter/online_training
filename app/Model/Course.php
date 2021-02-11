<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'tbl_courses';

    public function getEquipment(){
        return $this->belongsTo('App\Model\Equipment','equipment_id');
    }
}
