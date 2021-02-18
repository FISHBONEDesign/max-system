@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Create New Device</div>
        <div class="card-body">
            <form method="post" action="{{ route('admin.manage.devices.store') }}">
                @csrf
                <div class="form-group row">
                    <label for="device-name" class="col-sm-2 col-form-label">Device Name</label>
                    <div class="col-sm-10">
                        <input id="device-name" name="name" value="{{ old('name') }}" type="text"
                            class="form-control @error('name') border-danger @enderror">
                        @error('name')
                            <small id="device-name-error" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <fieldset class="form-group row">
                    <legend class="col-form-label col-sm-2 float-sm-left pt-0">Device Level</legend>
                    <div class="col-sm-10 @error('level') border border-danger @enderror">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="level" id="level-1-radio" value="first">
                            <label class="form-check-label" for="level-1-radio">
                                First Level
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="level" id="level-2-radio" value="second">
                            <label class="form-check-label" for="level-2-radio">
                                Second Level
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="level" id="level-3-radio" value="third">
                            <label class="form-check-label" for="level-3-radio">
                                Third Level
                            </label>
                        </div>
                        @error('level')
                            <small id="device-level-error" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </fieldset>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="{{ route('admin.manage.devices.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
