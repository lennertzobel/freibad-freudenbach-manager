<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Booking;
use Faker\Generator as Faker;

$factory->define(Booking::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTimeBetween($startDate = '-1 week', $endDate = '+1 week')->format('Y-m-d'),
        'timeslot' => $faker->randomElement(['morning' ,'noon', 'evening', 'noon_evening']),
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName(),
        'phone' => $faker->phoneNumber(),
        'amount_of_people' => $faker->numberBetween(1, 6),
    ];
});
