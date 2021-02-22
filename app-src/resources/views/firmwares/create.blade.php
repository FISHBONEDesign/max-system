@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Create New Firmware</div>
        <div class="card-body">
            @component('firmwares.components.form', [
                'action' => route('admin.projects.firmwares.store', [$firmware->device->project, $firmware->device]),
                'update' => false,
                'firmware' => $firmware
            ])
            @endcomponent
        </div>
    </div>
@endsection
