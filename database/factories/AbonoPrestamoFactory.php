<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\AbonoPrestamo;
use App\Microprestamo;
use App\DetalleIntegrante;
use App\Usuario;
use Faker\Generator as Faker;

$factory->define(AbonoPrestamo::class, function (Faker $faker) {
    return [
        'cantidad_abono' => $faker-> randomFloat($nbMaxDecimals = 2, $min = 1, $max = 150),
        'cantidad_restante' => $faker-> randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10000),
        'descripcion' => $faker->text($maxNbChars = 200),
        'fecha_pago' => $faker->dateTime($max = 'now', $timezone = null),
        'mora' => $faker-> numberBetween($min = 0, $max = 100),
        //'microprestamo_id' => Microprestamo::pluck('id')[$faker->numberBetween(1,Microprestamo::count()-1)],
        'detalle_integrante_id' => factory(App\DetalleIntegrante::class),
        'usuario_id' => factory(App\Usuario::class),
        'microprestamo_id' => factory(App\Microprestamo::class),
        //'detalle_integrante_id' => DetalleIntegrante::pluck('id')[$faker->numberBetween(1,DetalleIntegrante::count()-1)],
        //'usuario_id' => Usuario::pluck('id')[$faker->numberBetween(1,Usuario::count()-1)],
        'estado' => $faker->numberBetween($min = 0, $max = 1),
    ];
});
