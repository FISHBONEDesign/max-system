<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => '$2y$10$QM7OEBVNGZomBc6A5fqXGOx8.X7jUEt.WStQow2nplqxog7DV7Ajy', // 12345678
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        for ($i = 1; $i < 6; $i++) {
            DB::table('admins')->insert([
                'name' => 'test' . ($i + 1),
                'email' => ($i + 1) . '@email.com',
                'password' => '$2y$10$QM7OEBVNGZomBc6A5fqXGOx8.X7jUEt.WStQow2nplqxog7DV7Ajy', // 12345678
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
