<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Accordous\Contract;
use Accordous\Property;
use Faker\Generator as Faker;

$factory->define(Contract::class, function (Faker $faker) {
    return [
        'property_id' => Property::whereDoesntHave('contract')->get()->random()->id,
        'name' => $faker->firstName,
        'document_type' => $faker->randomElement(['CPF', 'CNPJ']),
        'document_number' => $faker->numerify('###########'),
        'email' => $faker->email,
    ];
});
