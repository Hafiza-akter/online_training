<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\UserPlanPurchase;
use App\Model\PlanPurchase;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Model\User; 

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(UserPlanPurchase::class, function (Faker $faker) {
    return [
        'user_id' =>  User::all()->random()->id,
        'purchase_plan_id' =>PlanPurchase::all()->random()->id,
        'objective' =>'weight_loss',
        'target_calory_gained' =>2755,
        'period_month' =>1,
        'created_at' =>date('Y-m-d H:i:s')

        
    ];
});
