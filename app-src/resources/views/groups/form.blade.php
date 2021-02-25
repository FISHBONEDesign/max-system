<form method="post" action="{{ $action }}">
    @csrf
    @if ($update)
        @method('patch')
    @endif
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-10">
            <input id="name" name="name" value="{{ old('name', $group->name) }}" type="text"
                class="form-control @error('name') border-danger @enderror">
            @error('name')
                <small id="name-error" class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="model-name" class="col-sm-2 col-form-label">Model Name</label>
        <div class="col-sm-10">
            <select id="model-name" name="model_name" class="form-control select2 @error('model_name') border-danger @enderror">
                @php
                    $oldvalue = old('model_name', $group->model_name);
                @endphp
                @foreach ($models as $model)
                    @php
                        $selected = $oldvalue === $model->value ? 'selected' : '';
                    @endphp
                    <option {{ $selected }} value="{{ $model->value }}">{{ $model->label }}</option>
                @endforeach
            </select>
            @error('model_name')
                <small id="model-id-error" class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="model-name-1" class="col-sm-2 col-form-label">Model Name</label>
        <div class="col-sm-10">
            <select id="model-name-1" name="model_name" class="form-control select2 tags @error('model_name') border-danger @enderror">
                @php
                    $oldvalue = old('model_name', $group->model_name);
                @endphp
                @foreach ($models as $model)
                    @php
                        $selected = $oldvalue === $model->value ? 'selected' : '';
                    @endphp
                    <option {{ $selected }} value="{{ $model->value }}">{{ $model->label }}</option>
                @endforeach
            </select>
            @error('model_name')
                <small id="model-id-error" class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="model-name-2" class="col-sm-2 col-form-label">Model Name</label>
        <div class="col-sm-10">
            <select id="model-name-2" name="model_name" class="form-control select2 @error('model_name') border-danger @enderror" multiple>
                @php
                    $oldvalue = old('model_name', $group->model_name);
                @endphp
                @foreach ($models as $model)
                    @php
                        $selected = $oldvalue === $model->value ? 'selected' : '';
                    @endphp
                    <option {{ $selected }} value="{{ $model->value }}">{{ $model->label }}</option>
                @endforeach
            </select>
            @error('model_name')
                <small id="model-id-error" class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="model-name-3" class="col-sm-2 col-form-label">Model Name</label>
        <div class="col-sm-10">
            <select id="model-name-3" name="model_name" class="form-control select2 tags @error('model_name') border-danger @enderror" multiple>
                @php
                    $oldvalue = old('model_name', $group->model_name);
                @endphp
                @foreach ($models as $model)
                    @php
                        $selected = $oldvalue === $model->value ? 'selected' : '';
                    @endphp
                    <option {{ $selected }} value="{{ $model->value }}">{{ $model->label }}</option>
                @endforeach
            </select>
            @error('model_name')
                <small id="model-id-error" class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="model-id" class="col-sm-2 col-form-label">Model ID</label>
        <div class="col-sm-10">
            <input id="model-id" name="model_id" value="{{ old('model_id', $group->model_id) }}" type="text"
                class="form-control @error('model_id') border-danger @enderror">
            @error('model_id')
                <small id="model-id-error" class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-10">
            @php
                $cancel = $update ? route('admin.groups.show', $group) : route('admin.groups.index');
            @endphp
            <button type="submit" class="btn btn-primary">{{ !$update ? 'Create' : 'Update' }}</button>
            <a href="{{ $cancel }}" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</form>
