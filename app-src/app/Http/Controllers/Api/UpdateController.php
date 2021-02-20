<?php

namespace App\Http\Controllers\Api;

use App\Device;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function check_update(Request $request)
    {
        $request->validate([
            'device' => 'required|exists:devices,name',
            'version' => 'required'
        ]);
        return $this->fetch_firmware($request);
    }

    private function fetch_firmware($request)
    {
        $firmware = Device::whereName($request->device)->first()
            ->firmwares()
            ->where('support_version_oldest', '<', $request->version)
            ->where('support_version_newest', '>', $request->version)
            ->latest()->first();
        $response = [
            'device' => $firmware ? $firmware->device->name : '',
            'version' => $firmware->version,
            'change-log' => route('download.firmware', [$firmware->device->name, $firmware->version, 'version_log']),
            'firmware' => route('download.firmware', [$firmware->device->name, $firmware->version, 'firmware'])
        ];
        return response()->json($response, $firmware ? 200 : 404);
    }
}
