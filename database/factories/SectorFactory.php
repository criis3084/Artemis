<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sector;
use App\Aldea;
use Faker\Generator as Faker;

$factory->define(Sector::class, function (Faker $faker) {
    return [
        'nombre' => $faker->country,
        'aldea_id' => Aldea::pluck('id')[$faker->numberBetween(1,Aldea::count()-1)],
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
