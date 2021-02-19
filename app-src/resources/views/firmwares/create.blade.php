@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Create New Firmware</div>
        <div class="card-body">
            <form method="post" action="{{ route('admin.manage.firmwares.store', $device) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label for="firmware-version" class="col-sm-2 col-form-label">Version</label>
                    <div class="col-sm-10">
                        <input id="firmware-version" name="version" value="{{ old('version') }}" type="text"
                            class="form-control @error('version') border-danger @enderror">
                        @error('version')
                            <small id="firmware-version-error" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="checksumFile" class="col-sm-2 col-form-label">Checksum</label>
                    <div class="col-sm-10">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="checksumFile" name="checksum">
                            <label class="custom-file-label @error('checksum') border-danger @enderror"
                                for="checksumFile">Choose file</label>
                        </div>
                        @error('checksum')
                            <small id="firmware-checksum-error" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="firmwareFile" class="col-sm-2 col-form-label">Firmware</label>
                    <div class="col-sm-10">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="firmwareFile" name="firmware">
                            <label class="custom-file-label @error('firmware') border-danger @enderror"
                                for="firmwareFile">Choose file</label>
                        </div>
                        @error('firmware')
                            <small id="firmware-firmware-error" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="{{ route('admin.manage.firmwares.list', $device) }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection