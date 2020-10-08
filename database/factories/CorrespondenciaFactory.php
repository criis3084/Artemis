<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Correspondencia;
use App\Apadrinamiento;
use Faker\Generator as Faker;

$factory->define(Correspondencia::class, function (Faker $faker) {
    return [
        'ruta_imagen' => $faker->text($maxNbChars = 100),
        'descripcion' => $faker->text($maxNbChars = 100),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
