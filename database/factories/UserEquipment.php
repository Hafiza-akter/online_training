<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\UserEquipment;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Model\User; 
use App\Model\Equipment; 

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

$factory->define(UserEquipment::class, function (Faker $faker) {
    return [
        'user_id' =>  User::all()->random()->id,
        'equipment_id' =>Equipment::all()->random()->id,
        
    ];
});
