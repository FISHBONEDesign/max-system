<?php

namespace App\Http\Controllers;

use App\Device;
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
            'version' => 'required',
            'checksum' => 'required|file',
            'firmware' => 'required|file'
        ]);
        // $checksum = request()->checksum->store('test', 'public');
        // $checksum = 'test/dcwVTroxa3DvLnWrodyMZqVvw4svAWegbEqihquE.txt';
        // $checksum_url = Storage::disk('public')->url($checksum);
        // $checksum_url = str_replace(env('APP_URL'), url('/'), $checksum_url); // directly access
        // $download = Storage::disk('public')->download($checksum, 'checksum'); // directly download
        // return $checksum_url;
    }
}
