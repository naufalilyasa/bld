<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Document;
use Faker\Generator as Faker;

$factory->define(Document::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'title' => $faker->title,
        'author' => $faker->name('male'),
        'publisher' => 'Localhost',
        'category' => 'Umum',
        'items_available' => $faker->randomNumber(1),
        'location' => '-',
        'published_at' => $faker->dateTime()
    ];
});
