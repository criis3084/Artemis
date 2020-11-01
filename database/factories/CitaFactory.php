<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Cita;
use App\Clinico;
use App\Paciente;
use App\TipoCita;
use Faker\Generator as Faker;

$factory->define(Cita::class, function (Faker $faker) {
    return [
        'fecha'=> $faker->dateTimeBetween($startDate = '-10 months', $endDate = 'now', $timezone = null),
        'descripcion'=> $faker->realText($maxNbChars = 100),
        'clinico_id' => Clinico::pluck('id')[$faker->numberBetween(1,Clinico::count()-1)],
        'paciente_id' => Paciente::pluck('id')[$faker->numberBetween(1,Paciente::count()-1)],
        'tipo_cita_id' => TipoCita::pluck('id')[$faker->numberBetween(1,TipoCita::count()-1)],
        'estado' => $faker->numberBetween($min = 0, $max = 1)
    ];
});
