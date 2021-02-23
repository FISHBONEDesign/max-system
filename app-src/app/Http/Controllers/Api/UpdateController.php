<?php

namespace App\Http\Controllers\Api;

use App\Device;
use App\Http\Controllers\Controller;
use App\Project;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function check_update($project, Request $request)
    {
        $project = Project::whereName($project)->first();
        $request->validate([
            'device' => 'required|exists:devices,name',
            'version' => 'required'
        ]);
        return $this->fetch_firmware($project, $request);
    }

    private function fetch_firmware($project, $request)
    {
        $firmware = $project->devices()->whereName($request->device)->first()
            ->firmwares()
            ->where('support_version_oldest', '<=', $request->version)
            ->where('support_version_newest', '>=', $request->version)
            ->latest()->first();
        if ($firmware === null) abort(404);
        $response = [
            'device' => $firmware ? $firmware->device->name : '',
            'version' => $firmware->version,
            'change-log' => route('download.firmware', [$project->name, $firmware->device->name, $firmware->version, 'version_log']),
            'firmware' => route('download.firmware', [$project->name, $firmware->device->name, $firmware->version, 'firmware'])
        ];
        return response()->json($response, $firmware ? 200 : 404);
    }
}
