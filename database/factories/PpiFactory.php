<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Ppi;
use Faker\Generator as Faker;

$factory->define(Ppi::class, function (Faker $faker) {
    return [
        'respuesta1' => $faker->numberBetween($min = 0, $max = 100),
        'respuesta2' => $faker->numberBetween($min = 0, $max = 100),
        'respuesta3' => $faker->numberBetween($min = 0, $max = 100),
        'respuesta4' => $faker->numberBetween($min = 0, $max = 100),
        'respuesta5' => $faker->numberBetween($min = 0, $max = 100),
        'respuesta6' => $faker->numberBetween($min = 0, $max = 100),
        'respuesta7' => $faker->numberBetween($min = 0, $max = 100),
        'respuesta8' => $faker->numberBetween($min = 0, $max = 100),
        'respuesta9' => $faker->numberBetween($min = 0, $max = 100),
        'respuesta10' => $faker->numberBetween($min = 0, $max = 100),
        'total' => $faker->numberBetween($min = 0, $max = 1000),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
