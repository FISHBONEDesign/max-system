<?php

use App\Models\Admin;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userCount = Admin::count();
        for ($i = 1; $i < ($userCount + 1); $i++) {
            DB::table('projects')->insert([
                'name' => 'p_test_' . ($i),
                'admin_id' => $i,
                'created_at' => now(),
                'updated_at' => now(),
                ]);
            DB::table('groups')->insert([
                'name' => 'Group for ' . 'p_test_' . $i,
                'model_name' => 'App\Models\Project',
                'model_id' => $i,
                'created_at' => now(),
                'updated_at' => now(),
                ]);
            DB::table('group_members')->insert([
                'group_id' => $i,
                'admin_id' => $i,
                'edit' => '1',
                'created_at' => now(),
                'updated_at' => now(),
                ]);
        }
    }
}
