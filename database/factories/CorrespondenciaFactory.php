<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Correspondencia;
use App\Apadrinamiento;
use Faker\Generator as Faker;

$factory->define(Correspondencia::class, function (Faker $faker) {
    return [
        'mensaje' => $faker->text($maxNbChars = 254),
        'encabezado' => $faker->text($maxNbChars = 254),
        'piePagina' => $faker->text($maxNbChars = 254),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
