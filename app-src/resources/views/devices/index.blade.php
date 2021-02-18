@extends('layouts.admin')

@section('content')
    <div class="mb-2">
        <a href="{{ route('admin.manage.device.create') }}" class="btn btn-primary">New Device</a>
        <button type="button" class="btn btn-secondary">Secondary</button>
        <button type="button" class="btn btn-success">Success</button>
        <button type="button" class="btn btn-danger">Danger</button>
        <button type="button" class="btn btn-warning">Warning</button>
        <button type="button" class="btn btn-info">Info</button>
        <button type="button" class="btn btn-light">Light</button>
        <button type="button" class="btn btn-dark">Dark</button>

        <button type="button" class="btn btn-link">Link</button>
    </div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all"
                aria-selected="true">All</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="first-tab" data-toggle="tab" href="#first-layer" role="tab" aria-controls="first-layer"
                aria-selected="true">First Layer</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="second-tab" data-toggle="tab" href="#second-layer" role="tab"
                aria-controls="second-layer" aria-selected="false">Second Layer</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="third-tab" data-toggle="tab" href="#third-layer" role="tab" aria-controls="third-layer"
                aria-selected="false">Third Layer</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
            all devices
        </div>
        <div class="tab-pane fade" id="first-layer" role="tabpanel" aria-labelledby="first-tab">
            first-layer devices
        </div>
        <div class="tab-pane fade" id="second-layer" role="tabpanel" aria-labelledby="second-tab">
            second-layer devices
        </div>
        <div class="tab-pane fade" id="third-layer" role="tabpanel" aria-labelledby="third-tab">
            third-layer devices
        </div>
    </div>
@endsection
