<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Examen;
use App\HistorialExamen;
use Faker\Generator as Faker;

$factory->define(HistorialExamen::class, function (Faker $faker) {
    return [
        'examen_id' => factory(App\Examen::class),
        'paciente_id' => factory(App\Paciente::class),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
    ];
});
