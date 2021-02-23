<?php

namespace App\Http\Controllers;

use App\Device;
use App\Firmware;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class FirmwareController extends Controller
{
    public function list(Project $project, Device $device)
    {
        return view('firmwares.index', compact('device'));
    }

    public function create(Project $project, Device $device)
    {
        $firmware = new Firmware();
        $firmware->device_id = $device->id;
        return view('firmwares.create', compact('firmware'));
    }

    public function store(Project $project, Device $device)
    {
        $validated = request()->validate([
            'version' => 'required|unique:firmwares',
            'release' => 'required|date',
            'support_version_oldest' => 'nullable|string',
            'support_version_newest' => 'nullable|string',
            'checksum' => 'required|string',
            'version_log' => 'nullable|file',
            'firmwareFile' => 'required|file'
        ]);
        $driver = 'public';
        $storage_path  = 'firmwares/' . $device->name . '/' . request()->version;
        $validated['version_log'] = request()->version_log->store($storage_path, $driver);
        $validated['path'] = request()->firmwareFile->store($storage_path, $driver);
        $firmware_obj = $device->firmwares()->create($validated);
        return redirect()->route('admin.projects.firmwares.list', [$device->project, $device]);
    }

    public function edit(Project $project, Firmware $firmware)
    {
        return view('firmwares.edit', compact('firmware'));
    }

    public function update(Project $project, Firmware $firmware)
    {
        $validated = request()->validate([
            'version' => "required|unique:firmwares,version,{$firmware->id}",
            'release' => 'required|date',
            'support_version_oldest' => 'nullable|string',
            'support_version_newest' => 'nullable|string',
            'checksum' => 'required|string',
            'version_log' => 'nullable|file',
            'firmwareFile' => 'nullable|file'
        ]);
        $driver = 'public';
        $storage_path  = 'firmwares/' . $firmware->device->name . '/' . request()->version;
        if (request()->version_log)
            $validated['version_log'] = request()->version_log->store($storage_path, $driver);
        if (request()->firmwareFile)
            $validated['path'] = request()->firmwareFile->store($storage_path, $driver);
        $firmware->update($validated);

        return redirect()->route('admin.projects.firmwares.list', [$project, $firmware->device]);
    }

    public function destroy(Project $project, Firmware $firmware)
    {
        $device = $firmware->device;
        $firmware->delete();
        return redirect()->route('admin.projects.firmwares.list', [$project, $device]);
    }

    public function download($project, $device, $version, $action)
    {
        $project = Project::whereName($project)->firstOrFail();
        $device = $project->devices()->where('name', $device)->firstOrFail();
        $firmware = $device->firmwares()->where('version', $version)->firstOrFail();
        $response = null;
        $file_prefix = $device->name . '-v' . $version;
        $download_name = null;
        if ($action === 'firmware') {
            $ext = pathinfo($firmware->path)['extension'];
            $download_name = $file_prefix . '.' . $ext;
            $response = Storage::disk('public')->path($firmware->path);
        }
        if ($action === 'version_log') {
            $ext = pathinfo($firmware->version_log)['extension'];
            $download_name = $file_prefix . '-change-log' . '.' . $ext;
            $response = Storage::disk('public')->path($firmware->version_log);
        }
        if ($response === null) abort(404);
        $response = new BinaryFileResponse($response);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $download_name);
        return $response;
    }
}
