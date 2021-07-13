<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use App\Model\TrainerEquipment;

class Trainer extends Model implements Authenticatable
{
    use AuthenticableTrait;

    protected $table = 'tbl_trainers';

    public function equipment() 
    { 
        return $this->hasOne(TrainerEquipment::class); 
    }
}
