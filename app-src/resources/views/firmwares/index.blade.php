@extends('layouts.admin')

@section('content')
    <div class="mb-2">
        <a href="{{ route('admin.manage.firmwares.create', $device) }}" class="btn btn-primary">New Firmware</a>
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
                        <span class="badge-pill">
                            <a href="{{ route('admin.manage.firmwares.edit', $firmware->id) }}" class="btn text-success">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn text-danger"
                                onclick="event.preventDefault();document.getElementById('delete-firmware-{{ $firmware->id }}').submit();console.log();">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form id="delete-firmware-{{ $firmware->id }}" class="d-none" method="post"
                                action="{{ route('admin.manage.firmwares.destroy', $firmware->id) }}">
                                @csrf
                                @method('delete')
                            </form>
                        </span>
                    </a>
                    @component('components.collapse-content', ['id' => 'firmware-' . $firmware->id])
                        <div class="card-body">
                            <a href="{{ route('download.firmware', [$firmware->device->name, $firmware->version, 'firmware']) }}"
                                data-turbolinks="false" class="btn btn-primary">firmware</a>
                            <a href="{{ route('download.firmware', [$firmware->device->name, $firmware->version, 'checksum']) }}"
                                data-turbolinks="false" class="btn btn-primary">checksum</a>
                        </div>
                    @endcomponent
                </li>
            @empty
                <li class="list-group-item">no any firmware found.</li>
            @endforelse
        </ul>
    </div>
@endsection
