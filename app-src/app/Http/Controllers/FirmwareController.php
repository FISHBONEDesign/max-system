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
        return view('firmwares.create', compact('device'));
    }

    public function store(Device $device)
    {
        request()->validate([
            'version' => 'required|unique:firmwares',
            'checksum' => 'required|file',
            'firmware' => 'required|file'
        ]);
        $driver = 'public';
        $storage_path  = 'firmwares/' . $device->name . '/' . request()->version;
        $checksum = request()->checksum->store($storage_path, $driver);
        $firmware = request()->firmware->store($storage_path, $driver);
        $firmware_obj = $device->firmwares()->create([
            'version' => request()->version,
            'checksum' => $checksum,
            'path' => $firmware
        ]);
        return redirect()->route('admin.manage.firmwares.list', $device);
    }

    public function edit(Firmware $firmware)
    {
        return view('firmwares.edit', compact('firmware'));
    }

    public function update(Firmware $firmware)
    {
        request()->validate([
            'version' => 'required',
            'checksum' => 'nullable|file|mimes:text,txt', // --> update to text
            'firmware' => 'nullable|file|mimes:bin'
        ]);
        return redirect()->back();
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
        if ($action === 'checksum') {
            $ext = pathinfo($firmware->checksum)['extension'];
            $download_name = $file_prefix . '.' . $ext;
            $response = Storage::disk('public')->download($firmware->checksum, $download_name);
        }
        if ($response === null) abort(404);
        return $response;
    }
}
