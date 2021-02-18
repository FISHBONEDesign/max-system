@extends('layouts.admin')

@section('content')
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
