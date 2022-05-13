<form method="post" action="{{ $action }}">
    @csrf
    @if ($update)
        @method('patch')
    @endif
    <div class="form-group row">
        <label for="user" class="col-sm-2 col-form-label">Member Name: </label>
        <div class="col-sm-10">
            @if ($update)
                {{ $member->name }}
            @else
                <select id="user" name="admin_id"
                    class="form-control select2 tags @error('admin_id') border-danger @enderror">
                    @php
                        $oldvalue = old('admin_id', $member->admin_id);
                    @endphp
                    @foreach (App\Models\Admin::all()->diff($member->project->adminProject->pluck('admin')) as $admin)
                        @php
                            $selected = $oldvalue === $admin->id ? 'selected' : '';
                        @endphp
                        <option {{ $selected }} value="{{ $admin->id }}">{{ $admin->name }}</option>
                    @endforeach
                </select>
                @error('admin_id')
                    <small id="user-error" class="form-text text-danger">{{ $message }}</small>
                @enderror
            @endif
        </div>
    </div>
    <div class="form-group row">
        <div class="offset-2 col-sm-2">
            @can('admin')
                <div class="form-check">
                    @php
                        $checked = $member->owner === true ? 'checked' : '';
                        // $checked = 'checked'
                    @endphp
                    <input class="form-check-input" type="checkbox" name="editPermission" id="editPermission" {{ $checked }}>
                    <label class="form-check-label" for="editPermission">
                        Project Manager
                    </label>
                </div>
            @endcan
            <div class="form-check">
                @php
                    // $checked = $member->edit === true ? 'checked' : '';
                    $checked = 'checked';
                @endphp
                <input class="form-check-input" type="checkbox" name="editable" id="editable" {{ $checked }}>
                <label class="form-check-label" for="editable">
                    Can Edit
                </label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-10">
            @php
                $cancel = route('admin.projects.show', $member->project);
            @endphp
            <button type="submit" class="btn btn-primary">{{ !$update ? 'Create' : 'Update' }}</button>
            <a href="{{ $cancel }}" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</form>
