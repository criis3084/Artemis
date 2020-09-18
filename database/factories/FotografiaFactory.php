<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Fotografia;
use Faker\Generator as Faker;

$factory->define(Fotografia::class, function (Faker $faker) {
    return [
        'ruta' => $faker->text($maxNbChars = 200), 
        'descripcion' => $faker->text($maxNbChars = 100), 
        'titulo' => $faker->text($maxNbChars = 10), 
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
