<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Clinico;
use App\Usuario;
use App\Profesion;
use Faker\Generator as Faker;

$factory->define(Clinico::class, function (Faker $faker) {
    return [
        'usuario_id' => Usuario::pluck('id')[$faker->numberBetween(1,Usuario::count()-1)],
        'profesion_id' => Profesion::pluck('id')[$faker->numberBetween(1,Profesion::count()-1)],
        'estado' => $faker->numberBetween($min = 0, $max = 1)
    ];
});
