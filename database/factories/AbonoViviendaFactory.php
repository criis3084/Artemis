<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\AbonoVivienda;
use App\Vivienda;
use App\Usuario;
use Faker\Generator as Faker;

$factory->define(AbonoVivienda::class, function (Faker $faker) {
    return [
        'cantidad_abono' => $faker->numberBetween($min = 1000, $max = 10000),
        'descripcion' => $faker->text($maxNbChars = 100),
        'fecha_pago' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'cantidad_restante' => $faker->numberBetween($min = 10000, $max = 100000),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        // 'vivienda_id' => Vivienda::pluck('id')[$faker->numberBetween(1,Vivienda::count()-1)],
        'usuario_id' => factory(App\Usuario::class),
        // 'usuario_id' => Usuario::pluck('id')[$faker->numberBetween(1,Usuario::count()-1)],
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
