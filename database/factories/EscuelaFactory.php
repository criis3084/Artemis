<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Escuela;
use Faker\Generator as Faker;

$factory->define(Escuela::class, function (Faker $faker) {
    return [
        'nombre' => $faker->company,
        'direccion' => $faker->address,
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
