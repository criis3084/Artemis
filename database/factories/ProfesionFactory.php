<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Profesion;
use Faker\Generator as Faker;

$factory->define(Profesion::class, function (Faker $faker) {
    return [
        'nombre' => $faker->word,
        'estado' => $faker->numberBetween($min = 0, $max = 1),
    ];
});
