<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'expired_at' => now(),
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
    ];
});
