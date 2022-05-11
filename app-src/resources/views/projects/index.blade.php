@extends('layouts.admin')

@section('content')
    <div class="mb-2">
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
    </div>
    <div class="mb-2">
        <h1 class="text-2xl mb-2">Shared Projects:</h1>
        @forelse ($user->shared_projects as $project)
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
    </div>
    @if (auth('admin')->user()->isSupervisor)
        <div class="mb-2">
            <h1 class="text-2xl mb-2">Other Projects:</h1>
            @forelse ($projects->diff($user->projects)->diff($user->shared_projects) as $project)
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
        </div>
    @endif
@endsection
