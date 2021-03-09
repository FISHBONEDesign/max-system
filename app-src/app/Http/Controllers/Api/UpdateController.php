<?php

namespace App\Http\Controllers\Api;

use App\Models\Device;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $firmware = $project->devices()->whereName($request->device)->firstOrFail()
            ->firmwares()->where('release', '<=', now())->latest()->get()
            ->filter(function ($firmware) use ($version) {
                $filtered = $firmware->version > $version;
                if ($firmware->support_version_oldest) $filtered &= $firmware->support_version_oldest <= $version;
                if ($firmware->support_version_newest) $filtered &= $firmware->support_version_newest >= $version;
                return $filtered;
            })->first();
        if ($firmware === null) abort(404);
        $response = [
            'device' => $firmware ? $firmware->device->name : '',
            'version' => $firmware->version,
            'release' => $firmware->release,
            'change_log' => ($firmware->version_log ? Storage::disk('public')->get($firmware->version_log) : ''),
            'firmware' => route('download.firmware', [$project->name, $firmware->device->name, $firmware->version, 'firmware']),
            'checksum' => $firmware->checksum
        ];
        return response()->json($response, $firmware ? 200 : 404);
    }
}
