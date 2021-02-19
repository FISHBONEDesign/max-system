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
}
