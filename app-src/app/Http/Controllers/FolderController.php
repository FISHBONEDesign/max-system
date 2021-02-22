<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FolderController extends Controller
{

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
        $new_folders = collect(explode('/', $data['name']));
        $absolute = $new_folders[0] === '';
        if ($absolute || $folder === null) {
            $folder = new Folder();
            $folder->project_id = $project->id;
            $folder->id = 0;
        }
        foreach ($new_folders as $index => $new_folder) {
            if ($absolute && $index === 0) continue;
            $new_folder_data = [
                'project_id' => $folder->project_id,
                'parent_id' => $folder->id,
                'name' => $new_folder
            ];
            $exists_folder = Folder::where($new_folder_data)->first();
            if ($exists_folder) {
                if ($index === $new_folders->count() - 1) {
                    throw ValidationException::withMessages([
                        'name' => 'folder already exist.'
                    ]);
                } else {
                    $folder = $exists_folder;
                }
            } else {
                $new_folder = $project->folders()->create($new_folder_data);
                $folder = $new_folder;
            }
        }
        $router_parameters[] = $folder;
        return redirect()->route('admin.projects.folders.show', $router_parameters);
    }

    public function edit(Project $project, Folder $folder)
    {
        return view('projects.folders.edit', compact('folder'));
    }

    public function update(Project $project, Folder $folder)
    {
        $data = request()->validate(['name' => 'required']);
        $data['project_id'] = $folder->project_id;
        $data['parent_id'] = $folder->parent_id;
        preg_match('/[\/]/', $data['name'], $matches);
        $invalid_name = (bool) count($matches);
        if ($invalid_name) {
            throw ValidationException::withMessages([
                'name' => 'folder\'s name can\'t has \'/\'.'
            ]);
        }
        $exists = (bool) Folder::where('id', '!=', $folder->id)->where($data)->get()->count();
        if ($exists) {
            throw ValidationException::withMessages([
                'name' => 'folder already exist.'
            ]);
        } else {
            $folder->update($data);
        }
        return redirect()->route('admin.projects.folders.show', [$folder->project, $folder->parent]);
    }

    public function destroy(Project $project, Folder $folder)
    {
        $route = route('admin.projects.folders.show', $folder->project, $folder->parent);
        $folder->delete();
        return redirect($route);
    }
}
