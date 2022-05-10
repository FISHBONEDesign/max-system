<?php

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = Project::all();
        $project_count = $projects->count();
        for ($i = 1; $i < ($project_count + 1); $i++) {
            DB::table('groups')->insert([
                'name' => 'Group for ' . $projects->name,
                'model_name' => 'App\Models\Project',
                'created_at' => now(),
                'updated_at' => now(),
                ]);
        }
    }
}
