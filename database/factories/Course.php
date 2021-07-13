<?php
use App\Model\Trainer;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Model\Course; 
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

$factory->define(Course::class, function (Faker $faker) {
    return [
    	
        'course_name' =>  $faker->name,
        'course_type' =>  'weight_loss',
        'equipment_id' =>  Equipment::all()->random()->id,
      
        
    ];
});
