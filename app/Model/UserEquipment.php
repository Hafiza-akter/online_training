<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\User;

class UserEquipment extends Model
{
    protected $table = 'tbl_user_equipments';
    protected $guarded = [];

    public function user() 
    { 
        return $this->belongsTo(User::class); 
    }
}
