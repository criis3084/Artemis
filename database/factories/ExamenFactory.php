<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Examen;
use App\Clinico;
use App\TipoExamen;
use Faker\Generator as Faker;

$factory->define(Examen::class, function (Faker $faker) {
    return [
        'descripcion'=> $faker->realText($maxNbChars = 100),
        'resultado'=> $faker->realText($maxNbChars = 100),
		'fecha_examen' => $faker->dateTimeBetween($startDate = '-9 months', $endDate = 'now', $timezone = null),
        'tipo_examen_id' => TipoExamen::pluck('id')[$faker->numberBetween(1,TipoExamen::count()-1)],
        'clinico_id' => Clinico::pluck('id')[$faker->numberBetween(1,Clinico::count()-1)],
        'estado' => $faker->numberBetween($min = 0, $max = 1),
    ];
});
