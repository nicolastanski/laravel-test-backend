<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Accordous\Property;
use Faker\Generator as Faker;

$factory->define(Property::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'address' => $faker->streetName,
        'number' => $faker->buildingNumber,
        'complement' => $faker->randomNumber(2),
        'neighborhood' => $faker->lastName,
        'city'  => $faker->city,
        'state' => $faker->randomElement(['SP', 'RJ', 'RS']),

    ];
});
