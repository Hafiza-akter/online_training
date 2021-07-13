<?php
use App\Model\Trainer;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Model\User; 
use App\Model\Favourite; 

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

$factory->define(Favourite::class, function (Faker $faker) {
    return [
    	
        'trainer_id' =>  Trainer::all()->random()->id,
        'user_id' =>  User::all()->random()->id,
        'serial_order'=>1        
        
    ];
});
