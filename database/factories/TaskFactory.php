<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'project_id' => 0,
        'parent_id' => 0,
        'flow_process_id' => 0,
        'sort_num' => 1,
        'name' => $faker->word(),
        'description' => $faker->text( 50 ),
        'creator_id' => 0,
        'deadline' => $faker->date() . " " . $faker->time(),
    ];
});
