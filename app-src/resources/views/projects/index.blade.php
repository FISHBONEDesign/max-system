@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl mb-2">{{ $user->name }}'s Projects:</h1>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary mb-2">Create Project</a>
    @forelse ($user->projects as $project)
        <div class="card mb-2">
            <a href="{{ route('admin.projects.show', $project) }}">
                <div class="card-header">{{ $project->name }}</div>
                <div class="card-body">
                    owner: {{ $project->owner->name }} <br>
                    created at: {{ $project->created_at }} <br>
                    updated at: {{ $project->updated_at }}
                </div>
            </a>
        </div>
    @empty
        <div class="card-body">No any project found.</div>
    @endforelse
    <div class="card">
        <div class="card-header">Dashboard</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            You are logged in!
        </div>
    </div>
@endsection
