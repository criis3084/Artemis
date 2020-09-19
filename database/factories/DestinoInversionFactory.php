<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DestinoInversion;
use Faker\Generator as Faker;

$factory->define(DestinoInversion::class, function (Faker $faker) {
    return [
        'nombre' => $faker->company,
        'estado' => $faker->numberBetween($min = 0, $max = 1),
    ];
});
