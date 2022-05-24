<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Folder;
use Faker\Generator as Faker;
use App\Models\Project;

$factory->define(Folder::class, function (Faker $faker) {
    return [
        "project_id" => Project::all()->random()->id,
        "parent_id" => '0',
        "name" => $faker->word
    ];
});
