@extends('layouts.admin')

@section('content')
    @component('devices.components.form', [
        'update' => true,
        'action' => route('admin.projects.devices.update', [$device->project, $device]),
        'folder' => $device->folder,
        'device' => $device,
    ])
    @endcomponent
@endsection
