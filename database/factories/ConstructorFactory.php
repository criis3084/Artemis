<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Constructor;
use App\PersonaSinAcceso;
use Faker\Generator as Faker;

$factory->define(Constructor::class, function (Faker $faker) {
    return [
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'persona_sin_acceso_id' => PersonaSinAcceso::pluck('id')[$faker->numberBetween(1,PersonaSinAcceso::count()-1)],
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
