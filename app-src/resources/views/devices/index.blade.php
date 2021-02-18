@extends('layouts.admin')

@section('content')
    <div class="mb-2">
        <a href="{{ route('admin.manage.devices.create') }}" class="btn btn-primary">New Device</a>
    </div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all"
                aria-selected="true">All</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="first-tab" data-toggle="tab" href="#first-layer" role="tab" aria-controls="first-layer"
                aria-selected="true">First Layer</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="second-tab" data-toggle="tab" href="#second-layer" role="tab"
                aria-controls="second-layer" aria-selected="false">Second Layer</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="third-tab" data-toggle="tab" href="#third-layer" role="tab" aria-controls="third-layer"
                aria-selected="false">Third Layer</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
            <ul class="list-group">
                @forelse ($devices as $index => $device)
                    <li class="list-group-item">
                        <span class="badge-pill">#{{ $index }}</span>
                        {{ $device->name }}
                        <span class="badge-pill">
                            <a href="{{ route('admin.manage.devices.edit', $device->id) }}" class="btn text-success">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn text-danger"
                                onclick="event.preventDefault();document.getElementById('delete-device-{{ $device->id }}').submit();console.log();">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form id="delete-device-{{ $device->id }}" method="post"
                                action="{{ route('admin.manage.devices.destroy', $device->id) }}">
                                @csrf
                                @method('delete')
                            </form>
                        </span>
                    </li>
                @empty
                    <li class="list-group-item">no any device found.</li>
                @endforelse
            </ul>
        </div>
        <div class="tab-pane fade" id="first-layer" role="tabpanel" aria-labelledby="first-tab">
            <ul class="list-group">
                @forelse ($devices->where('level', 'first') as $index => $device)
                    <li class="list-group-item">
                        <span class="badge-pill">#{{ $index }}</span>
                        {{ $device->name }}
                        <span class="badge-pill">
                            <a href="{{ route('admin.manage.devices.edit', $device->id) }}" class="btn text-success">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn text-danger"
                                onclick="event.preventDefault();document.getElementById('delete-device-{{ $device->id }}').submit();console.log();">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form id="delete-device-{{ $device->id }}" method="post"
                                action="{{ route('admin.manage.devices.destroy', $device->id) }}">
                                @csrf
                                @method('delete')
                            </form>
                        </span>
                    </li>
                @empty
                    <li class="list-group-item">no any device found.</li>
                @endforelse
            </ul>
        </div>
        <div class="tab-pane fade" id="second-layer" role="tabpanel" aria-labelledby="second-tab">
            <ul class="list-group">
                @forelse ($devices->where('level', 'second') as $index => $device)
                    <li class="list-group-item">
                        <span class="badge-pill">#{{ $index }}</span>
                        {{ $device->name }}
                        <span class="badge-pill">
                            <a href="{{ route('admin.manage.devices.edit', $device->id) }}" class="btn text-success">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn text-danger"
                                onclick="event.preventDefault();document.getElementById('delete-device-{{ $device->id }}').submit();console.log();">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form id="delete-device-{{ $device->id }}" method="post"
                                action="{{ route('admin.manage.devices.destroy', $device->id) }}">
                                @csrf
                                @method('delete')
                            </form>
                        </span>
                    </li>
                @empty
                    <li class="list-group-item">no any device found.</li>
                @endforelse
            </ul>
        </div>
        <div class="tab-pane fade" id="third-layer" role="tabpanel" aria-labelledby="third-tab">
            <ul class="list-group">
                @forelse ($devices->where('level', 'third') as $index => $device)
                    <li class="list-group-item">
                        <span class="badge-pill">#{{ $index }}</span>
                        {{ $device->name }}
                        <span class="badge-pill">
                            <a href="{{ route('admin.manage.devices.edit', $device->id) }}" class="btn text-success">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn text-danger"
                                onclick="event.preventDefault();document.getElementById('delete-device-{{ $device->id }}').submit();console.log();">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form id="delete-device-{{ $device->id }}" method="post"
                                action="{{ route('admin.manage.devices.destroy', $device->id) }}">
                                @csrf
                                @method('delete')
                            </form>
                        </span>
                    </li>
                @empty
                    <li class="list-group-item">no any device found.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
