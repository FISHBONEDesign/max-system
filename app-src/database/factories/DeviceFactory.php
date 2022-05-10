<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Device;
use App\Models\Folder;
use Faker\Generator as Faker;
use App\Models\Project;

$factory->define(Device::class, function (Faker $faker) {
    return [
        "project_id" => Project::all()->random()->id,
        "folder_id" => Folder::all()->random()->id,
        "name" => $faker->word
    ];
});
