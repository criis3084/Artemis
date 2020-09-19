<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TipoVivienda;
use Faker\Generator as Faker;

$factory->define(TipoVivienda::class, function (Faker $faker) {
    return [
        'nombre' => $faker->text($maxNbChars = 10), 
        'descripcion' => $faker->text($maxNbChars = 100),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
