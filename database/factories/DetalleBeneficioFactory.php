<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Beneficio;
use App\Medicamento;
use App\DetalleBeneficio;
use Faker\Generator as Faker;

$factory->define(DetalleBeneficio::class, function (Faker $faker) {
    return [
        'cantidad'=> $faker ->numberBetween($min = 1, $max = 10),
        'beneficio_id' => Beneficio::pluck('id')[$faker->numberBetween(1,Beneficio::count()-1)],
        'medicamento_id' => Medicamento::pluck('id')[$faker->numberBetween(1,Medicamento::count()-1)],
        'estado' => $faker->numberBetween($min = 0, $max = 1),

    ];
});
