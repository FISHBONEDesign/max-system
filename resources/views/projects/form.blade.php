@php
$firmware = $project;
@endphp
<form method="post" action="{{ $action }}">
    @csrf
    @if ($update)
        @method('patch')
    @endif
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-10">
            <input id="name" name="name" value="{{ old('name', $project->name) }}" type="text"
                class="form-control @error('name') border-danger @enderror">
            @error('name')
                <small id="name-error" class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">{{ !$update ? 'Create' : 'Update' }}</button>
            @if ($update)
                <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-secondary">Cancel</a>
            @else
                <a href="{{ route('admin.home') }}" class="btn btn-secondary">Cancel</a>
            @endif
        </div>
    </div>
</form>