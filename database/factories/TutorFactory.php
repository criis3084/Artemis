<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tutor;
use App\Usuario;
use Faker\Generator as Faker;

$factory->define(Tutor::class, function (Faker $faker) {
    return [
        'especialidad' => $faker->name($gender = 'male'or'female'), 
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'usuario_id' => Usuario::pluck('id')[$faker->numberBetween(1,Usuario::count()-1)],
    ];
});
