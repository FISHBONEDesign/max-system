@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Edit Project</div>
        <div class="card-body">
            @component('projects.form', [
                'action' => route('admin.projects.update', $project),
                'update' => true,
                'project' => $project
            ])
            @endcomponent
        </div>
    </div>
@endsection
