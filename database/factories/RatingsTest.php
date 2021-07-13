<?php
use App\Model\Trainer;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Model\User; 
use App\Model\Ratings; 
use App\Model\RatingsSetup; 

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

$factory->define(Ratings::class, function (Faker $faker) {
    return [
    	
        'trainer_id' =>  Trainer::all()->random()->id,
        'user_id' =>  User::all()->random()->id,
        'schedule_id'=>1,
        'training_id' =>1,
        'star_ratings'=>0   
        
    ];
});
