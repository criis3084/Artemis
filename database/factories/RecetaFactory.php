<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Receta;
use App\HistorialClinico;
use Faker\Generator as Faker;

$factory->define(Receta::class, function (Faker $faker) {
    return [
        'listado' => $faker->text($maxNbChars = 100), 
        'historial_clinico_id' => HistorialClinico::pluck('id')[$faker->numberBetween(1,HistorialClinico::count()-1)],
    ];
});
