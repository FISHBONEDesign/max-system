<?php

namespace App\Http\Controllers;

use App\Models\AdminProject;
use App\Models\Group;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->authorizeResource(Project::class, 'project');
    }

    /**
     * 顯示所有project 頁面
     *
     * @return void
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->email === 'admin@email.com') {
            $projects = Project::all();
        } else {
            $projects = $user->projects;
        };
        // $projects = Project::all()->filter(function ($project) use ($user) {
        //     return $user->can('view', $project);
        // });
        return view('projects.index', compact('user', 'projects'));
    }

    /**
     * 顯示建立new project 頁面
     *
     * @return void
     */
    public function create()
    {
        $project = new Project();
        $project->user_id = auth()->user()->id;
        return view('projects.create', ['project' => $project]);
    }

    /**
     * 儲存new project
     *
     * @return void
     */
    public function store()
    {
        $project = auth()->user()->projects()
            ->create(request()->validate([
                'name' => 'required'
            ]));
        $group = Group::create([
            'name' => 'Group for ' . $project->name,
            'model_name' => Project::class,
            'model_id' => $project->id
        ]);
        $group->members()->create([
            'admin_id' => auth()->user()->id,
            'edit' => true
        ]);
        $member = AdminProject::create([
            'project_id' => $project->id,
            'admin_id' => auth()->user()->id,
            'owner' => true,
            'edit' => true,
        ]);

        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * 顯示project 頁面
     *
     * @param Project $project
     * @return void
     */
    public function show(Project $project)
    {
        return redirect()->route('admin.projects.folders.show', $project);
    }

    /**
     * 顯示編輯project 頁面
     *
     * @param Project $project
     * @return void
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * 更新projct 資料
     *
     * @param Project $project
     * @return void
     */
    public function update(Project $project)
    {
        $project->update(request()->validate(['name' => 'required']));
        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * 刪除project
     *
     * @param Project $project
     * @return void
     */
    public function destroy(Project $project)
    {
        $project->folders()->delete();
        $project->group->members()->delete();
        $project->group->delete();
        $project->delete();
        return redirect()->route('admin.home');
    }
}
