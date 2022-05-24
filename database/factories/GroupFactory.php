<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Group;
use Faker\Generator as Faker;
use App\Models\Project;

$factory->define(Group::class, function (Faker $faker) {
    return [
        "name" => $faker->word,
        "model_name" => "App\Models\Project",
        "model_id" => Project::all()->random()->id
    ];
});
