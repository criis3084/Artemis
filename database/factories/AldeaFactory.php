<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Aldea;
use Faker\Generator as Faker;

$factory->define(Aldea::class, function (Faker $faker) {
    return [
        'nombre' => $faker->state,
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'updated_at' => $faker->dateTime($max = 'now', $timezone = null),
    ];
});
