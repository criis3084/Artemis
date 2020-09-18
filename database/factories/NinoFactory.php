<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Nino;
use Faker\Generator as Faker;

$factory->define(Nino::class, function (Faker $faker) {
    return [
        'codigo' => $faker->numberBetween($min = 1000, $max = 9999),
        'fecha_ingreso' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'fecha_egreso' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'ruta_imagen' => $faker->text($maxNbChars = 200), 
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'persona_sin_acceso_id' => $faker->numberBetween($min = 251, $max = 500),
        'escuela_id' => $faker->numberBetween($min = 1, $max = 10),
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
