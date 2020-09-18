<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Vivienda;
use App\TipoVivienda;
use App\Constructor;
use App\Encargado;
use Faker\Generator as Faker;

$factory->define(Vivienda::class, function (Faker $faker) {
    return [
        'costo_total' => $faker->numberBetween($min = 10000, $max = 100000),
        'direccion' => $faker->address, 
        'fecha_inicio' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'duracion' => $faker->numberBetween($min = 0, $max = 10),
        'imagen_final' => $faker->text($maxNbChars = 100), 
        'tipo_vivienda_id' => factory(App\TipoVivienda::class),
        'constructor_id' => factory(App\Constructor::class),
        'Encargado_id' => factory(App\Encargado::class),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
