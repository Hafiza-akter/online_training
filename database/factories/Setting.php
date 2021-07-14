<?php
use App\Model\Setting;
use Faker\Generator as Faker;

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

$factory->define(Setting::class, function (Faker $faker) {
    return [
    	
        'reminder_mail_info' =>   $faker->unique()->safeEmail,
        'reminder_mail_time' =>  13,
        'cancellation_time'=>22,
        'bmr_weight_coefficient'=> 13.397,
        'bmr_length_coefficient'=>4.799,
        'bmr_age_coefficient'=>5.677,
        'bmr_weight_female_coefficient'=>9.247,
        'bmr_length_female_coefficient'=>3.098,

        'bmr_age_female_coefficient'=>4.33,
        'bmr_male_coefficient'=>88.362,
        'bmr_female_coefficient'=>447.599,
        'calory_gained_large_coefficient'=>22,
        'calory_gained_standard'=>22.7,
        'calory_gained_small_coefficient'=>22,
        'ditcoefficient'=>0.1,
        'pal_middium_standard'=>1.55,
        'pal_low_standard'=>1.5,
        'pal_high_standard'=>1.75,
        'traininng_calory_coefficient'=>1.05,
        'adter_burn_coefficient'=>0.05,
        'weight_balance_coefficient1'=>1.1,
        'weight_balance_coefficient2'=>6,
        'average_mets'=>null
        
        
    ];
});
