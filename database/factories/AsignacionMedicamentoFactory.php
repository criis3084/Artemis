<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\AsignacionMedicamento;
use App\Receta;
use App\Medicamento;
$factory->define(AsignacionMedicamento::class, function (Faker $faker) {
    return [
        'cantidad'=> $faker ->numberBetween($min = 1, $max = 10),
        'frecuencia'=> $faker->text($maxNbChars = 100), 
        'receta_id' => factory(App\Receta::class),
       
        'medicamento_id' => factory(App\Medicamento::class),
        // 'user_id' => User::pluck('id')[$faker->numberBetween(1,User::count()-1)],
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),


    ];
});
