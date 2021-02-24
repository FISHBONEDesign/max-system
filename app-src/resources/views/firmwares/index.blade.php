@extends('layouts.admin')

@section('content')
    @include('projects.show', ['project' => $device->project])
    <div class="mb-2">
        <a href="{{ route('admin.projects.folders.show', [$device->project, $device->folder]) }}"
            class="btn btn-outline-dark">
            < Back</a>
                <a href="{{ route('admin.projects.firmwares.create', [$device->project, $device]) }}"
                    class="btn btn-primary">New Firmware</a>
    </div>
    <div class="card">
        <div class="card-header">{{ $device->name }} firmwares:</div>
        <ul class="list-group">
            @forelse ($device->firmwares()->latest()->get() as $index => $firmware)
                <li class="list-group-item">
                    <a href="#" @component('components.collapse-btn-attr', ['target'=> 'firmware-' . $firmware->id])
                        @endcomponent>
                        <span class="badge-pill">#{{ $index }}</span>
                        {{ $firmware->version }}
                        <span class="badge-pill">
                        </span>
                    </a>
                    <span class="text-gray-400">(release at: {{ $firmware->release }})</span>
                    <span class="badge-pill">
                        <a href="{{ route('admin.projects.firmwares.edit', [$device->project, $firmware]) }}"
                            class="btn text-success">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn text-danger"
                            onclick="event.preventDefault();if (window.confirm('comfirm to delete this firmware?')) document.getElementById('delete-firmware-{{ $firmware->id }}').submit();console.log();">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        <form id="delete-firmware-{{ $firmware->id }}" class="d-none" method="post"
                            action="{{ route('admin.projects.firmwares.destroy', [$device->project, $firmware]) }}">
                            @csrf
                            @method('delete')
                        </form>
                    </span>
                    @component('components.collapse-content', ['id' => 'firmware-' . $firmware->id])
                        <div class="card-body">
                            <a href="{{ route('download.firmware', [$firmware->device->project->name, $firmware->device->name, $firmware->version, 'firmware']) }}"
                                data-turbolinks="false" class="btn btn-primary">firmware</a>
                            @if ($firmware->version_log)
                                <a href="{{ route('download.firmware', [$firmware->device->project->name, $firmware->device->name, $firmware->version, 'version_log']) }}"
                                    data-turbolinks="false" class="btn btn-primary">change log</a>
                            @else
                                <a class="btn btn-outline-dark">no change log</a>
                            @endif
                            checksum: {{ $firmware->checksum }}
                        </div>
                    @endcomponent
                </li>
            @empty
                <li class="list-group-item">no any firmware found.</li>
            @endforelse
        </ul>
    </div>
@endsection
