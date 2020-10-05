<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\EstudioSocioeconomico;
use Faker\Generator as Faker;

$factory->define(EstudioSocioeconomico::class, function (Faker $faker) {
    return [
        'fecha_boleta' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'fecha_ingreso' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'total_ingresos' => $faker->numberBetween($min = 0, $max = 3000),
        'alimentacion' => $faker->word,
        'situacion_vivienda' => $faker->numberBetween($min = 0, $max = 3),
        'descripcion_costo' => $faker->word,
        'luz' => $faker->numberBetween($min = 0, $max = 100),
        'agua' => $faker->numberBetween($min = 0, $max = 100),
        'drenaje' => $faker->numberBetween($min = 0, $max = 100),
        'cantidad_cuartos' => $faker->numberBetween($min = 0, $max = 5),
        'bano' => $faker->word,
        'paredes' => $faker->word,
        'techo' => $faker->word,
        'piso' => $faker->word,
        'evaluacion_diagnostico' => $faker->word,
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
