<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TipoExamen;
use Faker\Generator as Faker;

$factory->define(TipoExamen::class, function (Faker $faker) {
    return [
        'nombre'  => $faker->randomElement(['orina','sangre','glucosa','Colesterol','Triglicérido']),
        'estado' => $faker->numberBetween($min = 0, $max = 1)
    ];
});
