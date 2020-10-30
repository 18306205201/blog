<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {
    $sentence = $faker->sentence();
    //随机取一个月内的时间
    $updated = $faker->dateTimeThisMonth();
    //创建时间永远要比创建时间要大
    $created = $faker->dateTimeThisMonth($updated);
    return [
        'title' => $faker->title,
        'body' => $faker->text(),
        'excerpt' => $sentence,
        'user_id' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
        'category_id' => $faker->randomElement([1, 2, 3, 4]),
        'created_at' => $created,
        'updated_at' => $updated
    ];
});
