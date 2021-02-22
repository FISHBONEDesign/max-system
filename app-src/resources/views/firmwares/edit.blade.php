@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Edit Firmware</div>
        <div class="card-body">
            <div class="card-body">
                @component('firmwares.components.form', [
                    'action' => route('admin.projects.firmwares.update', [$firmware->device->project, $firmware]),
                    'update' => true,
                    'firmware' => $firmware,
                ])
                @endcomponent
            </div>
        </div>
    </div>
@endsection
