<form method="post" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if ($update)
        @method('patch')
    @endif
    <div class="form-group row">
        <label for="firmware-version" class="col-sm-2 col-form-label">Version</label>
        <div class="col-sm-10">
            <input id="firmware-version" name="version" value="{{ old('version', $firmware->version) }}" type="text"
                class="form-control @error('version') border-danger @enderror">
            @error('version')
                <small id="firmware-version-error" class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="checksum" class="col-sm-2 col-form-label">Checksum</label>
        <div class="col-sm-10">
            <input id="checksum" name="checksum" value="{{ old('checksum', $firmware->checksum) }}" type="text"
                class="form-control @error('checksum') border-danger @enderror">
            @error('checksum')
                <small id="checksum-error" class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label>Support Version</label> <small class="text-red-600">required by v4</small>
        <div class="row">
            <label for="firmware-support-oldest" class="col-sm-2 col-form-label">Oldest Version</label>
            <div class="col-sm-4">
                <input id="firmware-support-oldest" name="support_version_oldest"
                    value="{{ old('support_version_oldest', $firmware->support_version_oldest) }}" type="text"
                    class="form-control @error('support_version_oldest') border-danger @enderror">
                @error('support_version_oldest')
                    <small id="firmware-support-oldest-error" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <label for="firmware-support-newest" class="col-sm-2 col-form-label">Newest Version</label>
            <div class="col-sm-4">
                <input id="firmware-support-newest" name="support_version_newest"
                    value="{{ old('support_version_newest', $firmware->support_version_newest) }}" type="text"
                    class="form-control @error('support_version_newest') border-danger @enderror">
                @error('support_version_newest')
                    <small id="firmware-support-newest-error" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="verlogFile" class="col-sm-2 col-form-label">Change Log
            <small class="text-red-600">required by v5</small>
        </label>
        <div class="col-sm-10">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="verlogFile" name="version_log">
                <label class="custom-file-label @error('version_log') border-danger @enderror" for="verlogFile">Choose
                    file</label>
            </div>
            @if ($update)
                <small class="form-text text-yellow-500">leave field blank, or it will override old file.</small>
            @endif
            @error('version_log')
                <small id="firmware-version-log-error" class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="firmwareFile" class="col-sm-2 col-form-label">Firmware</label>
        <div class="col-sm-10">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="firmwareFile" name="firmwareFile">
                <label class="custom-file-label @error('firmwareFile') border-danger @enderror" for="firmwareFile">Choose
                    file</label>
            </div>
            @if ($update)
                <small class="form-text text-yellow-500">leave field blank, or it will override old file.</small>
            @endif
            @error('firmwareFile')
                <small id="firmware-firmware-error" class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">{{ !$update ? 'Create' : 'Update' }}</button>
            <a href="{{ route('admin.manage.firmwares.list', $firmware->device) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</form>
