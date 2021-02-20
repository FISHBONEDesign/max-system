<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('projects.index', ['user' => auth()->user()]);
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
        return redirect()->route('admin.projects.show', $project);
    }

    public function show(Project $project)
    {
        return redirect()->route('admin.projects.folders.show', $project);
    }
}
