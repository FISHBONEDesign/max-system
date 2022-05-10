<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Firmware;
use App\Models\Device;
use Faker\Generator as Faker;

$factory->define(Firmware::class, function (Faker $faker) {
    return [
        "device_id" => Device::all()->random()->id,
        "version" => $faker->randomDigit . "." . $faker->randomDigit . "." . $faker->randomDigit,
        "release" => $faker->date(),
        "support_version_oldest" => $faker->randomDigit . "." . $faker->randomDigit . "." . $faker->randomDigit,
        "support_version_newest" => $faker->randomDigit . "." . $faker->randomDigit . "." . $faker->randomDigit,
        "checksum" => $faker->randomNumber . $faker->randomLetter,
        "path" => "firmwares/MAXDimmer-1CT/5.2.0/2vK7Ag6HXw7vA6gjkoZ7eiE5t1XkCkr2X2GMBnYC.bin"
    ];
});
