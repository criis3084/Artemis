<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Clinico;
use App\Paciente;
use App\HistorialClinico;
use Faker\Generator as Faker;

$factory->define(HistorialClinico::class, function (Faker $faker) {
    return [
        'descripcion' => $faker->text($maxNbChars = 100), 
        'peso_actual'=> $faker->randomFloat($nbMaxDecimals = NULL, $min = 20, $max = 300),
        'glicemia'=> $faker->randomFloat($nbMaxDecimals = NULL, $min = 10, $max = 150),
        'semanas_embarazo'=> $faker-> numberBetween($min = 5, $max = 30),
        'talla'=> $faker->randomFloat($nbMaxDecimals = NULL, $min = 20, $max = 150),
        'pulso'=> $faker-> numberBetween($min = 80, $max = 200),
        'respiracion'=> $faker-> numberBetween($min = 1000, $max = 9000),
        'temperatura'=> $faker->randomFloat($nbMaxDecimals = NULL, $min = 50, $max = 150),
        'presion_arterial'=> $faker -> numberBetween($min = 80, $max = 200),
        'objetivo' => $faker->text($maxNbChars = 50), 
        'subjetivo' => $faker->text($maxNbChars = 50), 
        'paciente_id' => Paciente::pluck('id')[$faker->numberBetween(1,Paciente::count()-1)],
        'clinico_id' => Clinico::pluck('id')[$faker->numberBetween(1,Clinico::count()-1)],
        'estado' => $faker->numberBetween($min = 0, $max = 1),
    ];
});
