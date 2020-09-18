<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\HistorialFotografia;
use App\Nino;
use App\Fotografia;
use Faker\Generator as Faker;

$factory->define(HistorialFotografia::class, function (Faker $faker) {
    return [
        // 'nino_id' => Nino::pluck('id')[$faker->numberBetween(1,Nino::count()-1)],
        'nino_id' => factory(App\Nino::class),
        // 'fotografia_id' => Fotografia::pluck('id')[$faker->numberBetween(1,Fotografia::count()-1)],
        'fotografia_id' => factory(App\Fotografia::class),
        'estado' => $faker->numberBetween($min = 0, $max = 1),
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
