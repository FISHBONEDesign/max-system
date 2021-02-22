@php
$route_parameters = [$folder->project, $update ? $folder->parent : $folder];
@endphp
<form method="post" action="{{ $action }}">
    @csrf
    @if ($update)
        @method('patch')
    @endif
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-10">
            <input id="name" name="name" value="{{ old('name', $folder->name) }}" type="text"
                class="form-control @error('name') border-danger @enderror">
            @error('name')
                <small id="name-error" class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">{{ !$update ? 'Create' : 'Update' }}</button>
            <a href="{{ route('admin.projects.folders.show', $route_parameters) }}"
                class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</form>
