<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Microprestamo;
use App\DestinoInversion;

use Faker\Generator as Faker;

$factory->define(Microprestamo::class, function (Faker $faker) {
    return [
        'total' => $faker-> randomFloat($nbMaxDecimals = 2, $min = 1, $max = 10000),
        'interes' => $faker-> randomFloat($nbMaxDecimals = 2, $min = 1, $max = 100),
        'fecha_inicio' => $faker -> dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null), // DateTime('2003-03-15 02:00:49', 'Africa/Lagos')
        'duracion' => $faker->numberBetween($min = 1, $max =64),
        'dia_pago' => $faker->numberBetween($min = 1, $max =7),
        'pago_mes' => $faker-> randomFloat($nbMaxDecimals = 2, $min = 1, $max = 300),
        'mora_por_atraso' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 6),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        //'destino_inversion_id' => DestinoInversion::pluck('id')[$faker->numberBetween(1,DestinoInversion::count()-1)],
    ];
});
