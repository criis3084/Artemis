<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Nino;
use App\Escuela;
use App\PersonaSinAcceso;
use Faker\Generator as Faker;

$factory->define(Nino::class, function (Faker $faker) {
    return [
        'codigo' => $faker->numberBetween($min = 1000, $max = 9999),
        'fecha_ingreso' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'fecha_egreso' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'ruta_imagen' => $faker->text($maxNbChars = 200), 
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'persona_sin_acceso_id' => PersonaSinAcceso::pluck('id')[$faker->numberBetween(1,PersonaSinAcceso::count()-1)],
        'escuela_id' => Escuela::pluck('id')[$faker->numberBetween(1,Escuela::count()-1)],
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
