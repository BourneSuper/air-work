<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Flow;
use Faker\Generator as Faker;

$factory->define(Flow::class, function (Faker $faker) {
    return [
        'project_id' => 0,
    ];
});
