<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Correspondencia;
use App\Apadrinamiento;
use Faker\Generator as Faker;

$factory->define(Correspondencia::class, function (Faker $faker) {
    return [
        'fecha_boleta' => $faker->numberBetween($min = 0, $max = 100),
        'fecha_ingreso' => $faker->numberBetween($min = 0, $max = 100),
        'total_ingresos' => $faker->numberBetween($min = 0, $max = 100),
        'alimentacion' => $faker->numberBetween($min = 0, $max = 100),
        'situacion_vivienda' => $faker->numberBetween($min = 0, $max = 100),
        'costo_vivienda' => $faker->numberBetween($min = 0, $max = 100),
        'luz' => $faker->numberBetween($min = 0, $max = 100),
        'agua' => $faker->numberBetween($min = 0, $max = 100),
        'drenaje' => $faker->numberBetween($min = 0, $max = 100),
        'cantidad_cuartos' => $faker->numberBetween($min = 0, $max = 100),
        'bano' => $faker->numberBetween($min = 0, $max = 100),
        'paredes' => $faker->numberBetween($min = 0, $max = 100),
        'techo' => $faker->numberBetween($min = 0, $max = 100),
        'piso' => $faker->numberBetween($min = 0, $max = 100),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
