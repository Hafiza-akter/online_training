<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Trainer;
use Faker\Generator as Faker;

$factory->define(Trainer::class, function (Faker $faker) {
    return [
        'first_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'expired_at' => now(),
        'is_verified' => 1,
        'is_google' => 1,
        'sex' => 'male',
        'phone' => '01773374864',
        'address_line' => 'japa',
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
    ];
});
