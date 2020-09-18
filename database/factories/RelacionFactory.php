<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Relacion;
use Faker\Generator as Faker;

$factory->define(Relacion::class, function (Faker $faker) {
    return [
        'relacion' => $faker->title($gender = null),     
        'direccion' => $faker->address,
        'codigo' => $faker->numberBetween($min = 1000, $max = 9999),
        'nino_id' => $faker->numberBetween($min = 1, $max = 50),
        'encargado_id' => $faker->numberBetween($min = 1, $max = 50),
        'sector_id' => $faker->numberBetween($min = 1, $max = 10),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
