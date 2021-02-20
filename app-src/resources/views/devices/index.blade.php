@extends('layouts.admin')

@section('content')
    <div class="mb-2">
        <a href="{{ route('admin.manage.devices.create') }}" class="btn btn-primary">New Device</a>
    </div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        @component('components.tab-nav', ['id' => 'all', 'active' => true, 'name' => 'All'])
        @endcomponent
        @component('components.tab-nav', ['id' => 'first-layer', 'active' => false, 'name' => 'First Layer'])
        @endcomponent
        @component('components.tab-nav', ['id' => 'second-layer', 'active' => false, 'name' => 'Second Layer'])
        @endcomponent
        @component('components.tab-nav', ['id' => 'third-layer', 'active' => false, 'name' => 'Third Layer'])
        @endcomponent
    </ul>
    <div class="tab-content" id="myTabContent">
        @component('devices.components.tab-panel', ['id' => 'all', 'active' => true, 'devices' => $devices])
        @endcomponent
        @component('devices.components.tab-panel', ['id' => 'first-layer', 'active' => false, 'devices' =>
            $devices->where('level', 'first')])
        @endcomponent
        @component('devices.components.tab-panel', ['id' => 'second-layer', 'active' => false, 'devices' =>
            $devices->where('level', 'second')])
        @endcomponent
        @component('devices.components.tab-panel', ['id' => 'third-layer', 'active' => false, 'devices' =>
            $devices->where('level', 'third')])
        @endcomponent
    </div>
@endsection
