<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\HistorialPpi;
use App\Nino;
use App\Ppi;
use Faker\Generator as Faker;

$factory->define(HistorialPpi::class, function (Faker $faker) {
    return [
        'fecha_estudio'=> $faker->date($format = 'Y-m-d', $max = 'now'),
        // 'nino_id' => Nino::pluck('id')[$faker->numberBetween(1,Nino::count()-1)],
        'nino_id' => factory(App\Nino::class),
        // 'ppi_id' => Ppi::pluck('id')[$faker->numberBetween(1,Ppi::count()-1)],
        'ppi_id' => factory(App\Ppi::class),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
