<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\HistorialAbonoVivienda;
use App\AbonoVivienda;
use App\Vivienda;

use Faker\Generator as Faker;

$factory->define(HistorialAbonoVivienda::class, function (Faker $faker) {
    return [
        'abono_vivienda_id' => factory(App\AbonoVivienda::class),
        'vivienda_id' => factory(App\Vivienda::class),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
    ];
});
