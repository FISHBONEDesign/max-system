<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Folder;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        return view('devices.index')->with('devices', Device::all());
    }

    public function create(Project $project, Folder $folder = null)
    {
        $this->authorize('update', $project);
        $folder = $folder ? $folder : new Folder();
        $device = new Device;
        $device->project_id = $project->id;
        $device->folder_id = $folder->id;
        return view('devices.create', ['device' => $device]);
    }

    public function edit(Project $project, DEvice $device)
    {
        $this->authorize('update', $project);
        return view('devices.edit')->with('device', $device);
    }

    public function store(Project $project, Request $request)
    {
        $this->authorize('update', $project);
        $data = $request->validate([
            'name' => ['required'],
            'path' => ['required']
        ]);
        $old_device = $project->devices()->whereName($data['name'])->first();
        if ($old_device) {
            return $this->update($project, $old_device);
        }
        $data['folder_id'] = $this->path_to_folder($project, $data['path']);
        $device = $project->devices()->create($data);
        return redirect()->route('admin.projects.folders.show', [$device->project, $device->folder]);
    }

    public function update(Project $project, Device $device)
    {
        $this->authorize('update', $project);
        $data = request()->validate([
            'name' => ['required'],
            'path' => ['required']
        ]);
        $old_device = $project->devices()->where('id', '!=', $device->id)->whereName($data['name'])->first();
        if ($old_device) {
            throw ValidationException::withMessages([
                'name' => 'device already exist in this project.'
            ]);
        }
        $data['folder_id'] = $this->path_to_folder($project, $data['path']);
        $device->update($data);
        return redirect()->route('admin.projects.folders.show', [$device->project, $device->folder]);
    }

    private function path_to_folder($project, $path)
    {
        $folders = collect(explode('/', $path));
        $log_folder = ['project_id' => $project->id, 'parent_id' => 0];
        $exists_folder = null;
        foreach ($folders as $folder) {
            if ($folder === '') continue;
            $log_folder['name'] = $folder;
            $exists_folder = Folder::where($log_folder)->first();
            if ($exists_folder) {
                $log_folder['parent_id'] = $exists_folder->id;
            }
        }
        return $exists_folder ? $exists_folder->id : 0;
    }

    public function destroy(Project $project, Device $device)
    {
        $this->authorize('update', $project);
        $route = route('admin.projects.folders.show', [$device->project, $device->folder]);
        $device->delete();
        return redirect($route);
    }
}
