<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Encargado;
use App\PersonaSinAcceso;
use Faker\Generator as Faker;

$factory->define(Encargado::class, function (Faker $faker) {
    return [
        'ruta_imagen' => $faker->text($maxNbChars = 200), 
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        //'persona_sin_acceso_id' => $faker->numberBetween($min = 1, $max = 250),
        'persona_sin_acceso_id' => PersonaSinAcceso::pluck('id')[$faker->numberBetween(1,PersonaSinAcceso::count()-1)],
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
