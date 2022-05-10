<?php

use App\Models\Folder;
use Illuminate\Database\Seeder;

class FoderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Folder::class, 5)->create();
    }
}
