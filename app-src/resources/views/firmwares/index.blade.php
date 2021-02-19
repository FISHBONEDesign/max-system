@extends('layouts.admin')

@section('content')
    <div class="mb-2">
        <a href="{{ route('admin.manage.firmwares.create', $device) }}" class="btn btn-primary">New Firmware</a>
    </div>
    <div class="card">
        <div class="card-header">{{$device->name}} firmwares:</div>
        <ul class="list-group">
            @forelse ($device->firmwares as $index => $firmware)
                <li class="list-group-item">
                    <a href="{{ route('admin.manage.firmwares.list', $firmware) }}">
                        <span class="badge-pill">#{{ $index }}</span>
                        {{ $firmware->name }}
                        <span class="badge-pill">
                        </span>
                    </a>
                </li>
            @empty
                <li class="list-group-item">no any firmware found.</li>
            @endforelse
        </ul>
    </div>
@endsection
