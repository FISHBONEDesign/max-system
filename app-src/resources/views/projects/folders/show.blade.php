@extends('layouts.admin')

@php
$tmp_folder = $folder->replicate();
$tmp_folder->id = $folder->id;
$breadcrumbs = [(object) ['name' => $tmp_folder->name, 'href' => null]];
$counter = 0;
while ($tmp_folder->id !== null && $tmp_folder->id !== 0 && $counter < 3) {
    if ($tmp_folder->parent === null) {
        $breadcrumbs[] = (object) ['name' => $tmp_folder->project->name, 'href' => route('admin.projects.folders.show', $tmp_folder->project)];
        $tmp_folder->id = 0;
    } else {
        $tmp_folder = $tmp_folder->parent;
        $breadcrumbs[] = (object) ['name' => $tmp_folder->name, 'href' => route('admin.projects.folders.show', [$tmp_folder->project, $tmp_folder])];
    }
}
$breadcrumbs = collect(array_reverse($breadcrumbs));
$router_parameters = [$project];
if ($folder && $folder->id !== 0) {
    $router_parameters[] = $folder;
}
@endphp

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
                <a href="{{ route('admin.projects.folders.create', $router_parameters) }}"
                    class="btn btn-sm btn-primary">Add
                    Folder</a>
                <a href="" class="btn btn-sm btn-primary">Add Device</a>
            </div>
            @foreach ($breadcrumbs as $index => $breadcrumb)
                <a {{ $breadcrumb->href ? "href={$breadcrumb->href}" : '' }}>{{ $breadcrumb->name }}</a>
                @if (!$loop->last)
                    >
                @endif
            @endforeach
            <ul class="list-group">
                @forelse ($folder->contents as $content)
                    <li class="list-group-item">
                        @if ($content->type === 'folder')
                            <a href="{{ route('admin.projects.folders.show', [$content->project, $content]) }}">
                                <i class="fas fa-folder"></i> {{ $content->name }}
                            </a>
                        @endif
                    </li>
                @empty
                    <li class="list-group-item">this project is empry.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
