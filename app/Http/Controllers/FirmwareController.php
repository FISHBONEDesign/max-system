<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Firmware;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class FirmwareController extends Controller
{
    public function list(Project $project, Device $device)
    {
        $this->authorize('view', $project);
        return view('firmwares.index', compact('device'));
    }

    public function create(Project $project, Device $device)
    {
        $this->authorize('update', $project);
        $firmware = new Firmware();
        $firmware->device_id = $device->id;
        return view('firmwares.create', compact('firmware'));
    }

    public function store(Project $project, Device $device)
    {
        $this->authorize('update', $project);
        $validated = request()->validate([
            'version' => 'required',
            'release' => 'required|date',
            'support_version_oldest' => 'nullable|string',
            'support_version_newest' => 'nullable|string',
            'checksum' => 'required|string',
            'version_log' => 'nullable|file',
            'firmwareFile' => 'required|file'
        ]);
        $old_firmware = $device->firmwares()->whereVersion($validated['version'])->first();
        if ($old_firmware) {
            throw ValidationException::withMessages([
                'version' => 'The version has already been taken.'
            ]);
        }
        $driver = 'public';
        $storage_path = 'firmwares/' . $device->name . '/' . request()->version;
        if (request()->version_log) {
            $validated['version_log'] = request()->version_log->store($storage_path);
        };
        $validated['path'] = request()->firmwareFile->store($storage_path);
        $firmware_obj = $device->firmwares()->create($validated);
        return redirect()->route('admin.projects.firmwares.list', [$device->project, $device]);
    }

    public function edit(Project $project, Firmware $firmware)
    {
        $this->authorize('update', $project);
        return view('firmwares.edit', compact('firmware'));
    }

    public function update(Project $project, Firmware $firmware)
    {
        $this->authorize('update', $project);
        $validated = request()->validate([
            'version' => "required",
            'release' => 'required|date',
            'support_version_oldest' => 'nullable|string',
            'support_version_newest' => 'nullable|string',
            'checksum' => 'required|string',
            'version_log' => 'nullable|file',
            'firmwareFile' => 'nullable|file'
        ]);
        $old_firmware = $firmware->device->firmwares()->where('id', '!=', $firmware->id)
            ->whereVersion($validated['version'])->first();
        if ($old_firmware) {
            throw ValidationException::withMessages([
                'name' => 'The version has already been taken.'
            ]);
        }
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
        $this->authorize('update', $project);
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
        if ($action === 'firmware' && $firmware->path) {
            $ext = pathinfo($firmware->path)['extension'];
            $download_name = $file_prefix . '.' . $ext;
            // dd('i am here');
            $response = Storage::path($firmware->path);
        }
        if ($action === 'version_log' && $firmware->version_log) {
            $ext = pathinfo($firmware->version_log)['extension'];
            $download_name = $file_prefix . '-change-log' . '.' . $ext;
            $response = Storage::path($firmware->version_log);
        }
        if ($response === null) abort(404);
        $response = new BinaryFileResponse($response);
        $response->headers->set('Cache-Control', 'no-cache, must-revalidate');
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $download_name);
        return $response;
    }

    public function classifyFirmwares(Project $project, Device $device, $year)
    {
        $this->authorize('view', $project);
        $firmware = $device->firmwares()->latest()->get();
        $firmware_release = [];
        foreach ($firmware as $key => $value) {
            $release_year = explode('-', $value->release)[0];
            if ($release_year == $year) {
                $firmware_release[] = $value;
            } elseif ($year == 'all') {
                $firmware_release[] = $value;
            };
        };
        $choose_firmware = $firmware_release;

        return view('firmwares.index', compact('device', 'choose_firmware'));
    }
}
