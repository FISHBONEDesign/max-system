@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">{{ $device->project->name }} - {{ $update ? 'Edit' : 'Create New' }} Device</div>
        <div class="card-body">
            <form method="post" action="{{ $action }}">
                @csrf
                @if ($update)
                    @method('patch')
                @endif
                <div class="form-group row">
                    <label for="device-name" class="col-sm-2 col-form-label">Device Name</label>
                    <div class="col-sm-10">
                        <input id="device-name" name="name" value="{{ old('name', $device->name) }}" type="text"
                            class="form-control @error('name') border-danger @enderror">
                        @error('name')
                            <small id="device-name-error" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <fieldset class="form-group row">
                    <legend class="col-form-label col-sm-2 float-sm-left pt-0">Path</legend>
                    <div class="col-sm-10">
                        <input id="device-path" name="path"
                            value="{{ old('path', $device->folder ? $device->folder->path : '/') }}" type="text"
                            class="form-control @error('path') border-danger @enderror">
                        @error('path')
                            <small id="device-path-error" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </fieldset>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.projects.folders.show', [$device->project, $device->folder]) }}"
                            class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
