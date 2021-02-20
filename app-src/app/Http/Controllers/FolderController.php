<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FolderController extends Controller
{
    public function create(Project $project, Folder $folder = null)
    {
        $folder = new Folder([
            'project_id' => $project->id,
            'parent_id' => $folder ? $folder->id : 0
        ]);
        return view('projects.folders.create', ['folder' => $folder]);
    }

    public function store(Project $project, Folder $folder = null)
    {
        $router_parameters = [$project];
        $data = request()->validate([
            'name' => 'required'
        ]);
        $data['project_id'] = $project->id;
        if ($folder) $data['parent_id'] = $folder->id;
        else $data['parent_id'] = 0;
        $exists = (bool)Folder::where($data)->get()->count();
        if ($exists) throw ValidationException::withMessages([
            'name' => 'folder already exist.'
        ]);
        $folder = $project->folders()->create($data);
        $router_parameters[] = $folder;
        return redirect()->route('admin.projects.folders.show', $router_parameters);
    }

    public function show(Project $project, Folder $folder = null)
    {
        if ($folder === null) {
            $folder = new Folder([
                'project_id' => $project->id,
                'name' => $project->name
            ]);
            $folder->id = 0;
        }
        return view('projects.folders.show', [
            'project' => $project,
            'folder' => $folder
        ]);
    }
}
