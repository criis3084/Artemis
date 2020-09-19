<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Usuario;
use App\Proveedor;
use App\IngresoMedicamento;
use Faker\Generator as Faker;

$factory->define(IngresoMedicamento::class, function (Faker $faker) {
    return [
        'fecha_ingreso' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'descripcion' => $faker->text($maxNbChars = 100),
        'usuario_id' => Usuario::pluck('id')[$faker->numberBetween(1,Usuario::count()-1)],
        'proveedor_id' => Proveedor::pluck('id')[$faker->numberBetween(1,Proveedor::count()-1)],
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
