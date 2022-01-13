<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\User;
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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'user_name' => $faker->userName,
        'password' => md5("12345"),
        'created_at' => $faker->dateTime(),
        "updated_at" => $faker->dateTime(),
        "created_by" => $faker->randomDigit,
        "updated_by" => $faker->randomDigit,
    ];
});
