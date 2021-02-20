<?php

namespace App\Http\Controllers;

use App\Device;
use App\Firmware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FirmwareController extends Controller
{
    public function index(Request $request)
    {
        $devices = Device::all();
        return view('firmwares.devices-index', compact('devices'));
    }

    public function list(Device $device)
    {
        return view('firmwares.index', compact('device'));
    }

    public function create(Device $device)
    {
        $firmware = new Firmware();
        $firmware->device_id = $device->id;
        return view('firmwares.create', compact('firmware'));
    }

    public function store(Device $device)
    {
        $validated = request()->validate([
            'version' => 'required|unique:firmwares',
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
        return redirect()->route('admin.manage.firmwares.list', $device);
    }

    public function edit(Firmware $firmware)
    {
        return view('firmwares.edit', compact('firmware'));
    }

    public function update(Firmware $firmware)
    {
        $validated = request()->validate([
            'version' => "required|unique:firmwares,version,{$firmware->id}",
            'support_version_oldest' => 'nullable|string',
            'support_version_newest' => 'nullable|string',
            'checksum' => 'required|string',
            'version_log' => 'nullable|file',
            'firmwareFile' => 'nullable|file|mimes:bin'
        ]);
        $driver = 'public';
        $storage_path  = 'firmwares/' . $firmware->device->name . '/' . request()->version;
        if (request()->version_log)
            $validated['version_log'] = request()->version_log->store($storage_path, $driver);
        if (request()->firmwareFile)
            $validated['path'] = request()->firmwareFile->store($storage_path, $driver);
        $firmware->update($validated);

        return redirect()->route('admin.manage.firmwares.list', $firmware->device);
    }

    public function download($device, $version, $action)
    {
        $device = Device::where('name', $device)->firstOrFail();
        $firmware = $device->firmwares()->where('version', $version)->firstOrFail();
        $response = null;
        $file_prefix = $device->name . '-v' . $version;
        if ($action === 'firmware') {
            $ext = pathinfo($firmware->path)['extension'];
            $download_name = $file_prefix . '.' . $ext;
            $response = Storage::disk('public')->download($firmware->path, $download_name);
        }
        if ($action === 'version_log') {
            $ext = pathinfo($firmware->version_log)['extension'];
            $download_name = $file_prefix. '-change-log' . '.' . $ext;
            $response = Storage::disk('public')->download($firmware->version_log, $download_name);
        }
        if ($response === null) abort(404);
        return $response;
    }
}
