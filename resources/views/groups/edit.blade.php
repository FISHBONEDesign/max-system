@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Edit Group</div>
        <div class="card-body">
            @component('groups.form', [
                'action' => route('admin.groups.update', $group),
                'update' => true,
                'group' => $group,
                'models' => $models
            ])
            @endcomponent
        </div>
    </div>
@endsection
