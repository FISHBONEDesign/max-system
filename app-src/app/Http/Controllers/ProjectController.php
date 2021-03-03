<?php

namespace App\Http\Controllers;

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

    public function index()
    {
        $user = auth()->user();
        if ($user->email === 'admin@email.com')
            $projects = Project::all();
        else
            $projects = $user->projects;
        $projects = Project::all()->filter(function ($project) use ($user) {
            return $user->can('view', $project);
        });
        return view('projects.index', compact('user', 'projects'));
    }

    public function create()
    {
        $project = new Project();
        $project->user_id = auth()->user()->id;
        return view('projects.create', ['project' => $project]);
    }

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
        return redirect()->route('admin.projects.show', $project);
    }

    public function show(Project $project)
    {
        return redirect()->route('admin.projects.folders.show', $project);
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Project $project)
    {
        $project->update(request()->validate(['name' => 'required']));
        return redirect()->route('admin.projects.show', $project);
    }

    public function destroy(Project $project)
    {
        $project->folders()->delete();
        $project->group->members()->delete();
        $project->group->delete();
        $project->delete();
        return redirect()->route('admin.home');
    }
}
