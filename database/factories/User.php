<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'expired_at' => now(),
        'phonetic'=>$faker->name,
        'is_verified' => 1,
        'weight' => 75,
        'sex' => 'male',
        'phone' => '01773374864',
        'address' => 'japa',
        'length' => 160,
        'dob' => '01/01/2000',
        'pal' => 1.75,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'token' => Str::random(10),
        'bmr_weight_offset' =>1,
        'bmr_length_offset' =>1,
        'bmr_age_offset' =>1,
        'bmr_male_offset' =>0,
        'bmr_female_offset' =>0,
        'calory_gained_large_offset' =>1,
        'calory_gained_offset' =>1,
        'calory_gained_small_offset' =>1,
        'ditoffset' =>1,
        'pal_middium_offset' =>1,
        'pal_low_offset' =>1,
        'pal_high_offset' =>1,
        'trainning_calory_offset' =>1,
        'after_burn_offset' =>1,
        'weight_balance_offset' =>1,
        'weight_balance_offset' =>1
    ];
});
