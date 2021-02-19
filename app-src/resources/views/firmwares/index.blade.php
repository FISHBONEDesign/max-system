@extends('layouts.admin')

@section('content')
    <div class="mb-2">
        <a href="{{ route('admin.manage.firmwares.create', $device) }}" class="btn btn-primary">New Firmware</a>
    </div>
    <div class="card">
        <div class="card-header">{{$device->name}} firmwares:</div>
        <ul class="list-group">
            @forelse ($device->firmwares()->latest()->get() as $index => $firmware)
                <li class="list-group-item">
                    <a href="#">
                        <span class="badge-pill">#{{ $index }}</span>
                        {{ $firmware->version }}
                        <span class="badge-pill">
                        </span>
                        <span class="badge-pill">
                            <a href="{{ route('admin.manage.devices.edit', $device->id) }}" class="btn text-success">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn text-danger"
                                onclick="event.preventDefault();document.getElementById('delete-device-{{ $device->id }}').submit();console.log();">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form id="delete-device-{{ $device->id }}" class="d-none" method="post"
                                action="{{ route('admin.manage.devices.destroy', $device->id) }}">
                                @csrf
                                @method('delete')
                            </form>
                        </span>
                    </a>
                </li>
            @empty
                <li class="list-group-item">no any firmware found.</li>
            @endforelse
        </ul>
    </div>
@endsection
