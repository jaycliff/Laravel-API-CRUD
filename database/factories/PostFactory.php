<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(10),
        // 'title' => $faker->title,
        'user_id' => 1,
        'content' => $faker->text
    ];
});
