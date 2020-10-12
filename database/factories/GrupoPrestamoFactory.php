<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\GrupoPrestamo;
use Faker\Generator as Faker;

$factory->define(GrupoPrestamo::class, function (Faker $faker) {
    return [
        'nombre' => $faker->text($maxNbChars = 20),
        'descripcion' => $faker->text($maxNbChars = 200),
        'cantidad_ultimo_prestamo' => $faker-> randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10000),
        'cantidad_prestamo_actual' => $faker-> randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10000),
        'interes_ultimo_prestamo' => $faker-> randomFloat($nbMaxDecimals = 2, $min = 1, $max = 5),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
       // 'dia_pago' => $faker->dayOfWeek($max = 'now'), 
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
