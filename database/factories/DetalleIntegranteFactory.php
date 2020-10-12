<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DetalleIntegrante;
use App\Encargado;
use App\GrupoPrestamo;
use Faker\Generator as Faker;
use App\DestinoInversion;

$factory->define(DetalleIntegrante::class, function (Faker $faker) {
    return [
        'encargado_id' => Encargado::pluck('id')[$faker->numberBetween(1,Encargado::count()-1)],
        'grupo_prestamo_id' => GrupoPrestamo::pluck('id')[$faker->numberBetween(1,GrupoPrestamo::count()-1)],
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'destino_inversion_id' => DestinoInversion::pluck('id')[$faker->numberBetween(1,DestinoInversion::count()-1)],
    ];
});
