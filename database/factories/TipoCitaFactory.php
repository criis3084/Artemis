<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TipoCita;
use Faker\Generator as Faker;

$factory->define(TipoCita::class, function (Faker $faker) {
    return [
        'nombre'=> $faker->sentence($nbWords = 2, $variableNbWords = true),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'descripcion' => $faker->text($maxNbChars = 100), 
    ];
});
