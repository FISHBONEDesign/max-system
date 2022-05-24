@extends('layouts.admin')

@section('content')
    <div class="mb-2">
        <h1 class="text-2xl mb-2">{{ $user->name }}'s Projects:</h1>
        @canany(['admin', 'manager'])
            <a href="{{ route('admin.projects.create') }}" class="btn btn-primary mb-2">Create Project</a>
        @endcanany
        @forelse ($user->my_projects as $my_project)
            <div class="card mb-2">
                <a href="{{ route('admin.projects.show', $my_project->project) }}">
                    <div class="card-header">{{ $my_project->project->name }}</div>
                    <div class="card-body">
                        project manager:
                        <br>
                        @foreach ($my_project->project->manager_name as $manager_name)
                            {{ $manager_name }}
                            @if ($loop->last)
                            @else
                                ,
                            @endif
                        @endforeach
                        <br><br>
                        created at: {{ $my_project->created_at }} <br>
                        updated at: {{ $my_project->updated_at }}
                    </div>
                </a>
            </div>

        @empty
            <div class="card-body">No any project found.</div>
        @endforelse
    </div>
    <div class="mb-2">
        <h1 class="text-2xl mb-2">Shared Projects:</h1>
        @forelse ($user->shared_projects as $shared_project)
            <div class="card mb-2">
                <a href="{{ route('admin.projects.show', $shared_project->project) }}">
                    <div class="card-header">{{ $shared_project->project->name }}</div>
                    <div class="card-body">
                        project manager:
                        <br>
                        @foreach ($shared_project->project->manager_name as $manager_name)
                            {{ $manager_name }}
                            @if ($loop->last)
                            @else
                                ,
                            @endif
                        @endforeach
                        <br><br>
                        created at: {{ $shared_project->created_at }} <br>
                        updated at: {{ $shared_project->updated_at }}
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
                            project manager:
                        <br>
                        @foreach ($project->manager_name as $manager_name)
                            {{ $manager_name }}
                            @if ($loop->last)
                            @else
                                ,
                            @endif
                        @endforeach
                        <br><br>
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
