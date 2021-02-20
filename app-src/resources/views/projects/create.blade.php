@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Create New Project</div>
        <div class="card-body">
            @component('projects.form', [
                'action' => route('admin.projects.store'),
                'update' => false,
                'project' => $project
                ])
            @endcomponent
        </div>
    </div>
@endsection
