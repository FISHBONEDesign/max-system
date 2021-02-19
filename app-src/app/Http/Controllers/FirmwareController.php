<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;

class FirmwareController extends Controller
{
    public function index(Request $request)
    {
        $devices = Device::all();
        return view('firmwares.devices-index', compact('devices'));
    }

    public function list(Device $device)
    {
        $firmwares = $device->firmwares;
        return view('firmwares.index', compact('device', 'firmwares'));
    }

    public function create(Device $device)
    {
        return $device;
    }
}
