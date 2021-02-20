@extends('layouts.admin')

@section('content')
    <div class="card mb-2">
        <div class="card-header">{{ $project->name }}</div>

        <div class="card-body">
            created at: {{ $project->created_at }} <br>
            updated at: {{ $project->updated_at }} <br>
        </div>
    </div>
    <div class="card">
        <div class="card-header">Folders & Devices</div>
        <div class="card-body">
            <div class="mb-2">
                <a href="{{ route('admin.projects.folders.create', $project) }}" class="btn btn-sm btn-primary">Add
                    Folder</a>
                <a href="" class="btn btn-sm btn-primary">Add Device</a>
            </div>
            <ul class="list-group">
                @forelse ($project->contents as $content)
                    <li class="list-group-item">
                        {{ $content->type }} {{ $content->name }}
                    </li>
                @empty
                    <li class="list-group-item">this project is empry.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
