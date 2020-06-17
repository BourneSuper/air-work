<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'flow_id' => rand( 1, 1000 ),
        'owner_id' => rand( 1, 1000 ),
        'owner_name' => $faker->name(),
        'name' => $faker->name(),
        'description' => $faker->text( 50 ),
        'deadline' => $faker->date() . " " . $faker->time()
    ];
});
