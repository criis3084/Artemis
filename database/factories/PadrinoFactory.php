<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Padrino;
use App\PersonaSinAcceso;
use Faker\Generator as Faker;

$factory->define(Padrino::class, function (Faker $faker) {
    return [
        'ruta_imagen' => $faker->text($maxNbChars = 200), 
        'correo' => $faker->text($maxNbChars = 100),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'persona_sin_acceso_id' => PersonaSinAcceso::pluck('id')[$faker->numberBetween(1,PersonaSinAcceso::count()-1)],
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
