<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\FlowProcess;
use Faker\Generator as Faker;

$factory->define(FlowProcess::class, function (Faker $faker) {
    return [
        'project_id' => 0,
        'flow_id' => 0,
        'name' => $faker->word(),
        'description' => $faker->text( 50 ),
        'sort_num' => rand( 1, 5),
    ];
});
