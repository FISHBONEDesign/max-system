<?php

use App\Models\Firmware;
use Illuminate\Database\Seeder;

class FirmwareTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Firmware::class, 10)->create();
    }
}
