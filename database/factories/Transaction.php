<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Transactions;
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

$factory->define(Transactions::class, function (Faker $faker) {
    return [
        'user_id' =>  User::all()->random()->id,
        'amount' =>'10',
        'transaction_id' =>Str::random(10),
        'purchase_plan_id' =>PlanPurchase::all()->random()->id,
        'period_month' =>1

        
    ];
});
