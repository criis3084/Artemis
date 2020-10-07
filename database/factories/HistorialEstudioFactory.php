<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\HistorialEstudio;
use App\EstudioSocioeconomico;
use App\Nino;
use Faker\Generator as Faker;

$factory->define(HistorialEstudio::class, function (Faker $faker) {
    return [
        'estudio_socioeconomico_id' => factory(App\EstudioSocioeconomico::class),
        'relacion_id' => factory(App\Nino::class),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
