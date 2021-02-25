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
        $request->validate([
            'device' => 'required|exists:devices,name',
            'version' => 'required'
        ]);
        $project = Project::whereName($project)->firstOrFail();
        return $this->fetch_firmware($project, $request);
    }

    private function fetch_firmware($project, $request)
    {
        $version = $request->version;
        $firmware = $project->devices()->whereName($request->device)->first()
            ->firmwares()->where('release', '<=', now())->latest()->get()
            ->filter(function ($firmware) use ($version) {
                $filtered = true;
                if ($firmware->support_version_oldest) $filtered &= $firmware->support_version_oldest <= $version;
                if ($firmware->support_version_newest) $filtered &= $firmware->support_version_newest >= $version;
                return $filtered;
            })->first();
        if ($firmware === null) abort(404);
        $response = [
            'device' => $firmware ? $firmware->device->name : '',
            'version' => $firmware->version,
            'release-date'=> $firmware->release,
            'change-log' => ($firmware->version_log ? route('download.firmware', [$project->name, $firmware->device->name, $firmware->version, 'version_log']) : ''),
            'firmware' => route('download.firmware', [$project->name, $firmware->device->name, $firmware->version, 'firmware']),
            'checksum' => $firmware->checksum
        ];
        return response()->json($response, $firmware ? 200 : 404);
    }
}
