<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(Request $request) {
        return view('devices.index')->with('devices', Device::all());
    }
}
