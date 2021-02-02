<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserPlanPurchase extends Model
{
    protected $table = 'tbl_user_plans';
    protected $guarded = [];

    public function getTransaction(){
        return $this->hasMany('App\Model\Transactions', 'user_id');
    }
    public function getUser(){
        return $this->belongsTo('App\Model\User', 'user_id');
    }
    public function getPlan(){
        return $this->belongsTo('App\Model\PlanPurchase', 'purchase_plan_id');
    }
}
