<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminTableSeeder::class);
        $this->call(ProjectTableSeeder::class);
        // $this->call(FoderTableSeeder::class);
        // $this->call(DeviceTableSeeder::class);
        // $this->call(FirmwareTableSeeder::class);
        // $this->call(GroupTableSeeder::class);
        // $this->call(MemberTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
    }
}
