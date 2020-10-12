<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DetalleIntegrante;
use App\Encargado;
use App\GrupoPrestamo;
use App\Microprestamo;
use App\DestinoInversion;
use Faker\Generator as Faker;

$factory->define(DetalleIntegrante::class, function (Faker $faker) {
    return [
        'prestamo_individual'=> $faker->numberBetween($min =1000, $max = 10000),
        'encargado_id' => Encargado::pluck('id')[$faker->numberBetween(1,Encargado::count()-1)],
        'grupo_prestamo_id' => GrupoPrestamo::pluck('id')[$faker->numberBetween(1,GrupoPrestamo::count()-1)],
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'destino_inversion_id' => DestinoInversion::pluck('id')[$faker->numberBetween(1,DestinoInversion::count()-1)],
        'microprestamo_id' => Microprestamo::pluck('id')[$faker->numberBetween(1,Microprestamo::count()-1)],
    ];
});
