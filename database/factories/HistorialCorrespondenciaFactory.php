<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\HistorialCorrespondencia;
use App\Correspondencia;
use App\Apadrinamiento;
use Faker\Generator as Faker;

$factory->define(HistorialCorrespondencia::class, function (Faker $faker) {
    return [
        'correspondencia_id' => factory(App\Correspondencia::class),
        'apadrinamiento_id' => factory(App\Apadrinamiento::class),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
    ];
});
