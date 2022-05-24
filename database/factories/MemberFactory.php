<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Member;
use App\Models\Admin;
use App\Models\Group;
use Faker\Generator as Faker;

$factory->define(Member::class, function (Faker $faker) {
    return [
        "group_id" => Group::all()->random()->id,
        "admin_id" => Admin::all()->random()->id,
        "edit" => collect([0, 1])->random()
    ];
});
