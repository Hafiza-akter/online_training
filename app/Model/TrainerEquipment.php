<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Trainer;

class TrainerEquipment extends Model
{
    protected $table = 'tbl_trainer_equipments';
    protected $guarded = [];
    public function Trainer() 
    { 
        return $this->belongsTo(Trainer::class); 
    }
}
