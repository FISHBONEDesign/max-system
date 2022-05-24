<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Admin;
use Faker\Generator as Faker;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$QM7OEBVNGZomBc6A5fqXGOx8.X7jUEt.WStQow2nplqxog7DV7Ajy', // 12345678
    ];
});
