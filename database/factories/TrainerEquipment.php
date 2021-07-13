<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Model\Trainer; 
use App\Model\Equipment; 
use App\Model\TrainerEquipment; 

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

$factory->define(TrainerEquipment::class, function (Faker $faker) {
    return [
        'trainer_id' =>  Trainer::all()->random()->id,
        'equipment_id' =>Equipment::all()->random()->id,
        
    ];
});
