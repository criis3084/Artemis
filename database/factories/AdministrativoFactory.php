<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Administrativo;
use App\Usuario;
use Faker\Generator as Faker;

$factory->define(Administrativo::class, function (Faker $faker) {
    return [
        
        'descripcion_puesto' => $faker->text($maxNbChars = 100),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        // 'vivienda_id' => Vivienda::pluck('id')[$faker->numberBetween(1,Vivienda::count()-1)],
        'usuario_id' => factory(App\Usuario::class),
        // 'usuario_id' => Usuario::pluck('id')[$faker->numberBetween(1,Usuario::count()-1)],
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
