<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'email' => $faker->unique()->safeEmail,
        'logo' => $faker->imageUrl(800, 600, 'cats'),
        'website' => $faker->url,
    ];
});
