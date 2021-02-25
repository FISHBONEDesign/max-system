@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Create New Group</div>
        <div class="card-body">
            @component('groups.form', [
                'action' => route('admin.groups.store'),
                'update' => false,
                'group' => $group,
                'models' => $models
            ])
            @endcomponent
        </div>
    </div>
@endsection
