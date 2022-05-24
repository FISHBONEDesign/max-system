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
        $this->call(RolesTableSeeder::class);
        // $this->call(TestAdminTableSeeder::class); // 測試用，上線前刪除
        // $this->call(ProjectTableSeeder::class);   // 測試用，上線前刪除
        // $this->call(UsersTableSeeder::class);
    }
}
