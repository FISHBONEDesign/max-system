@extends('layouts.admin')

@section('content')
    @include('projects.show', ['project' => $device->project])
    @php
    $firmware_release;
    foreach (
        $device
            ->firmwares()
            ->latest()
            ->get()
        as $index => $firmware
    ) {
        $firmware_release[] = explode('-', $firmware->release)[0];
    }
    $release_years = array_unique($firmware_release);
    $release_year ?? '';
    @endphp
    <div class="mb-2">
        <a href="{{ route('admin.projects.folders.show', [$device->project, $device->folder]) }}"
            class="btn btn-outline-dark">{{ '< Back' }}</a>
        @can('update', $device->project)
            <a href="{{ route('admin.projects.firmwares.create', [$device->project, $device]) }}" class="btn btn-primary">
                New Firmware
            </a>
        @endcan
    </div>
    <div class="card">
        <div class="card-header">
            {{ $device->name }} Firmwares
            <div class="btn-group ml-3">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    years
                </button>
                <div class="dropdown-menu">
                    @foreach ($release_years as $index => $year)
                    <a class="dropdown-item"
                    href="{{ route('admin.projects.firmwares.year', [$device->project, $device, $year]) }}">{{ $year }}</a>
                    @endforeach
                    <a class="dropdown-item"
                            href="{{ route('admin.projects.firmwares.year', [$device->project, $device, 'all']) }}">show all</a>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row m-4">
                <div class="col-1 font-weight-bold text-center">#</div>
                <div class="col-1 font-weight-bold text-center">version</div>
                <div class="col-2 font-weight-bold text-center">release at</div>
                <div class="col-2 font-weight-bold text-center">download</div>
                <div class="col-1 font-weight-bold text-center">delete</div>
            </div>
            @if ($choose_firmware ?? '')
                @forelse ($choose_firmware as $index => $firmware)
                    <div class="row m-4">
                        <div class="col-1 text-center">
                            #{{ $index }}
                        </div>
                        <div class="col-1 text-center">
                            @if (Auth::user()->can('update', $device->project))
                                <a href="{{ route('admin.projects.firmwares.edit', [$device->project, $firmware]) }}">
                                    {{ $firmware->version }}
                                </a>
                            @else
                                {{ $firmware->version }}
                            @endif
                        </div>
                        <div class="col-2 text-center">
                            @if (Auth::user()->can('update', $device->project))
                                <a href="{{ route('admin.projects.firmwares.edit', [$device->project, $firmware]) }}">
                                    {{ $firmware->release }}
                                </a>
                            @else
                                {{ $firmware->release }}
                            @endif
                        </div>
                        <div class="col-2 text-center">
                            <a href="#" class="text-success" @component('components.collapse-btn-attr', ['target' => 'firmware-' . $firmware->id])  @endcomponent>
                                <i class="fas fa-file-download"></i>
                            </a>
                        </div>
                        <div class="col-1 text-center">
                            @if (Auth::user()->can('update', $device->project))
                                <button type="button" class="text-danger"
                                    onclick="event.preventDefault();if (window.confirm('comfirm to delete this firmware?')) document.getElementById('delete-firmware-{{ $firmware->id }}').submit();console.log();">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <form id="delete-firmware-{{ $firmware->id }}" class="d-none" method="post"
                                    action="{{ route('admin.projects.firmwares.destroy', [$device->project, $firmware]) }}">
                                    @csrf
                                    @method('delete')
                                </form>
                            @else
                                <div class="text-secondary">
                                    <i class="fas fa-trash-alt"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                    @component('components.collapse-content', ['id' => 'firmware-' . $firmware->id])
                        <div class="row ml-4 mb-2">
                            <div class="col-1">
                                <a href="{{ route('download.firmware', [$firmware->device->project->name, $firmware->device->name, $firmware->version, 'firmware']) }}"
                                    data-turbolinks="false" class="btn btn-primary">firmware</a>
                            </div>
                            <div class="col-sm-4">
                                @if ($firmware->version_log)
                                    <a href="{{ route('download.firmware', [$firmware->device->project->name, $firmware->device->name, $firmware->version, 'version_log']) }}"
                                        data-turbolinks="false" class="btn btn-primary">change log</a>
                                @else
                                    <a class="btn btn-outline-dark">no change log</a>
                                @endif
                                <span class="ml-4">checksum: {{ $firmware->checksum }}</span>
                            </div>
                        </div>
                    @endcomponent
                @empty
                    <li class="list-group-item">no any firmware found.</li>
                @endforelse
            @else
                @forelse ($device->firmwares()->latest()->get() as $index => $firmware)
                    <div class="row m-4">
                        <div class="col-1 text-center">
                            #{{ $index }}
                        </div>
                        <div class="col-1 text-center">
                            @if (Auth::user()->can('update', $device->project))
                                <a href="{{ route('admin.projects.firmwares.edit', [$device->project, $firmware]) }}">
                                    {{ $firmware->version }}
                                </a>
                            @else
                                {{ $firmware->version }}
                            @endif
                        </div>
                        <div class="col-2 text-center">
                            @if (Auth::user()->can('update', $device->project))
                                <a href="{{ route('admin.projects.firmwares.edit', [$device->project, $firmware]) }}">
                                    {{ $firmware->release }}
                                </a>
                            @else
                                {{ $firmware->release }}
                            @endif
                        </div>
                        <div class="col-2 text-center">
                            <a href="#" class="text-success" @component('components.collapse-btn-attr', ['target' => 'firmware-' . $firmware->id])  @endcomponent>
                                <i class="fas fa-file-download"></i>
                            </a>
                        </div>
                        <div class="col-1 text-center">
                            @if (Auth::user()->can('update', $device->project))
                                <button type="button" class="text-danger"
                                    onclick="event.preventDefault();if (window.confirm('comfirm to delete this firmware?')) document.getElementById('delete-firmware-{{ $firmware->id }}').submit();console.log();">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <form id="delete-firmware-{{ $firmware->id }}" class="d-none" method="post"
                                    action="{{ route('admin.projects.firmwares.destroy', [$device->project, $firmware]) }}">
                                    @csrf
                                    @method('delete')
                                </form>
                            @else
                                <div class="text-secondary">
                                    <i class="fas fa-trash-alt"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                    @component('components.collapse-content', ['id' => 'firmware-' . $firmware->id])
                        <div class="row ml-4 mb-2">
                            <div class="col-1">
                                <a href="{{ route('download.firmware', [$firmware->device->project->name, $firmware->device->name, $firmware->version, 'firmware']) }}"
                                    data-turbolinks="false" class="btn btn-primary">firmware</a>
                            </div>
                            <div class="col-sm-4">
                                @if ($firmware->version_log)
                                    <a href="{{ route('download.firmware', [$firmware->device->project->name, $firmware->device->name, $firmware->version, 'version_log']) }}"
                                        data-turbolinks="false" class="btn btn-primary">change log</a>
                                @else
                                    <a class="btn btn-outline-dark">no change log</a>
                                @endif
                                <span class="ml-4">checksum: {{ $firmware->checksum }}</span>
                            </div>
                        </div>
                    @endcomponent
                @empty
                    <li class="list-group-item">no any firmware found.</li>
                @endforelse
            @endif


            {{-- @forelse ($device->firmwares()->latest()->get() as $index => $firmware)
                <div class="row m-4">
                    <div class="col-1 text-center">
                        #{{ $index }}
                    </div>
                    <div class="col-1 text-center">
                        @if (Auth::user()->can('update', $device->project))
                            <a href="{{ route('admin.projects.firmwares.edit', [$device->project, $firmware]) }}">
                                {{ $firmware->version }}
                            </a>
                        @else
                            {{ $firmware->version }}
                        @endif
                    </div>
                    <div class="col-2 text-center">
                        @if (Auth::user()->can('update', $device->project))
                            <a href="{{ route('admin.projects.firmwares.edit', [$device->project, $firmware]) }}">
                                {{ $firmware->release }}
                            </a>
                        @else
                            {{ $firmware->release }}
                        @endif
                    </div>
                    <div class="col-2 text-center">
                        <a href="#" class="text-success" @component('components.collapse-btn-attr', ['target' => 'firmware-' . $firmware->id])  @endcomponent>
                            <i class="fas fa-file-download"></i>
                        </a>
                    </div>
                    <div class="col-1 text-center">
                        @if (Auth::user()->can('update', $device->project))
                            <button type="button" class="text-danger"
                                onclick="event.preventDefault();if (window.confirm('comfirm to delete this firmware?')) document.getElementById('delete-firmware-{{ $firmware->id }}').submit();console.log();">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form id="delete-firmware-{{ $firmware->id }}" class="d-none" method="post"
                                action="{{ route('admin.projects.firmwares.destroy', [$device->project, $firmware]) }}">
                                @csrf
                                @method('delete')
                            </form>
                        @else
                            <div class="text-secondary">
                                <i class="fas fa-trash-alt"></i>
                            </div>
                        @endif
                    </div>
                </div>
                @component('components.collapse-content', ['id' => 'firmware-' . $firmware->id])
                    <div class="row ml-4 mb-2">
                        <div class="col-1">
                            <a href="{{ route('download.firmware', [$firmware->device->project->name, $firmware->device->name, $firmware->version, 'firmware']) }}"
                                data-turbolinks="false" class="btn btn-primary">firmware</a>
                        </div>
                        <div class="col-sm-4">
                            @if ($firmware->version_log)
                                <a href="{{ route('download.firmware', [$firmware->device->project->name, $firmware->device->name, $firmware->version, 'version_log']) }}"
                                    data-turbolinks="false" class="btn btn-primary">change log</a>
                            @else
                                <a class="btn btn-outline-dark">no change log</a>
                            @endif
                            <span class="ml-4">checksum: {{ $firmware->checksum }}</span>
                        </div>
                    </div>
                @endcomponent
            @empty
                <li class="list-group-item">no any firmware found.</li>
            @endforelse --}}
        </div>
    </div>
@endsection
