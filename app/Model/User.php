<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use App\Model\UserEquipment;
use App\Model\UserPlanPurchase;

class User extends Model implements Authenticatable
{
    use AuthenticableTrait;
    protected $table = 'tbl_users';
    
    public function equipment() 
    { 
        return $this->hasOne(UserEquipment::class); 
    }
    public function purchasPlan() 
    { 
        return $this->hasOne(UserPlanPurchase::class); 
    }
}
