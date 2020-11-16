<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tutor;
use App\User;
use Faker\Generator as Faker;

$factory->define(Tutor::class, function (Faker $faker) {
    return [
        'especialidad' => $faker->name($gender = 'male'or'female'), 
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'user_id' => User::pluck('id')[$faker->numberBetween(1,User::count()-1)],
    ];
});
