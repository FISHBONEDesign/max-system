@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Choose a Device</div>
        <div class="card-body">
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
                @component('firmwares.components.tab-panel', ['id' => 'all', 'active' => true, 'devices' => $devices])
                @endcomponent
                @component('firmwares.components.tab-panel', ['id' => 'first-layer', 'active' => false, 'devices' =>
                    $devices->where('level', 'first')])
                @endcomponent
                @component('firmwares.components.tab-panel', ['id' => 'second-layer', 'active' => false, 'devices' =>
                    $devices->where('level', 'second')])
                @endcomponent
                @component('firmwares.components.tab-panel', ['id' => 'third-layer', 'active' => false, 'devices' =>
                    $devices->where('level', 'third')])
                @endcomponent
            </div>
        </div>
    </div>
@endsection
