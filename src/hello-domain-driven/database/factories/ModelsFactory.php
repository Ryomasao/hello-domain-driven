<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Eloquent\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'user_id' => $faker->uuid,
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
    ];
});
