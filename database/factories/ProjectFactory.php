<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use App\User;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title' => $this->faker->realText(30),
        'description' => $this->faker->realText(180),
        'user_id' => function() {
            return factory(User::class)->create()->id;
        },
    ];
});
