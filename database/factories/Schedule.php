<?php
use App\Model\TrainerSchedule;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Model\User; 
use App\Model\Trainer;

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

$factory->define(TrainerSchedule::class, function (Faker $faker) {
    return [
    	
        'trainer_id' =>  Trainer::all()->random()->id,
        'user_id' =>  User::all()->random()->id,
        'date'=>\Carbon\Carbon::now()->addDays(rand(1, 5))->format('Y-m-d'), //date('Y-m-d H:i:s'),
        'time'=> date('H:i:s', rand(1,54000)),
        'is_occupied'=>0
        
        
    ];
});
