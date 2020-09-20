<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Receta;
use App\Medicamento;
use Faker\Generator as Faker;
use App\AsignacionMedicamento;

$factory->define(AsignacionMedicamento::class, function (Faker $faker) {
    return [
        'cantidad'=> $faker ->numberBetween($min = 1, $max = 10),
        'frecuencia'=> $faker->text($maxNbChars = 100), 
        'medicamento_id' => Medicamento::pluck('id')[$faker->numberBetween(1,Medicamento::count()-1)],
        'receta_id' => Receta::pluck('id')[$faker->numberBetween(1,Medicamento::count()-1)],
    ];
});
