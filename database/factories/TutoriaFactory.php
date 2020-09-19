<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tutoria;
use App\Tutor;
use App\Nino;
use Faker\Generator as Faker;

$factory->define(Tutoria::class, function (Faker $faker) {
    return [
        'nombre' => $faker->firstNameMale,
        'fecha' => $faker-> date($format = 'Y-m-d', $max = 'now'),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'tutor_id' => Tutor::pluck('id')[$faker->numberBetween(1,Tutor::count()-1)],
        'nino_id' => Nino::pluck('id')[$faker->numberBetween(1,Nino::count()-1)],
    ];
});
