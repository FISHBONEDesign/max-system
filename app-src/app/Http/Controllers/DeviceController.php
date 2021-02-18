<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        return view('devices.index')->with('devices', Device::all());
    }

    public function create()
    {
        return view('devices.create');
    }

    public function edit(Device $device)
    {
        return view('devices.edit')->with('device', $device);
    }

    public function store(Request $request)
    {
        Device::create($request->validate([
            'name' => ['required', 'unique:devices'],
            'level' => ['required', 'in:first,second,third']
        ]));
        return redirect()->route('admin.manage.devices.index');
    }

    public function update(Device $device)
    {
        $device->update(request()->validate([
            'name' => ['required', "unique:devices,name,{$device->id}"],
            'level' => ['required', 'in:first,second,third']
        ]));
        return redirect()->route('admin.manage.devices.index');
    }

    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->route('admin.manage.devices.index');
    }
}
