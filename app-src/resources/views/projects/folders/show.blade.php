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
    {{-- 專案名稱 --}}
    <h1 class="text-2xl mb-2">Project Name</h1>
    @include('projects.show')

    {{-- 專案內容 --}}
    <h1 class="text-2xl mb-2">Project Content</h1>
    <div class="card mb-2">
        <div class="card-header">Folders & Devices</div>
        <div class="card-body">
            <div class="mb-2">
                @can('update', $folder->project)
                    <a href="{{ route('admin.projects.folders.create', $router_parameters) }}"
                        class="btn btn-sm btn-primary">Add Folder</a>
<<<<<<< HEAD
                    @if ($folder->replicate()->parent_id !== null)
                        <a href="{{ route('admin.projects.devices.create', $router_parameters) }}"
                            class="btn btn-sm btn-primary">Add Device</a>
                    @endif
=======
                    <a href="{{ route('admin.projects.devices.create', $router_parameters) }}"
                        class="btn btn-sm btn-primary">Add
                        Device</a>
>>>>>>> feature/fix_device_in_base_folder
                @endcan
            </div>
            <div class="m-2">
                @foreach ($breadcrumbs as $index => $breadcrumb)
                    <a {{ $breadcrumb->href ? "href={$breadcrumb->href}" : '' }}>{{ $breadcrumb->name }}</a>
                    @if (!$loop->last)
                        >
                    @endif
                @endforeach
            </div>
            <ul class="list-group">
                @forelse ($folder->contents as $content)
                    <li class="list-group-item">
                        @if ($content->type === 'folder')
                            <a href="{{ route('admin.projects.folders.show', [$content->project, $content]) }}">
                                <i class="fas fa-folder"></i> {{ $content->name }}
                            </a>
                            @can('update', $content->project)
                                <span class="badge-pill">
                                    <a href="{{ route('admin.projects.folders.edit', [$content->project, $content]) }}"
                                        class="text-success"><i class="fas fa-edit"></i></a>
                                </span>
                                <span class="badge-pill">
                                    <button class="text-danger"
                                        onclick="event.preventDefault(); if (window.confirm('are you sure to delete the folder and contents?')) document.getElementById('delete-folder-{{ $content->id }}').submit();"><i
                                            class="fas fa-trash-alt"></i></button>
                                </span>
                                <form id="delete-folder-{{ $content->id }}"
                                    action="{{ route('admin.projects.folders.destroy', [$content->project, $content]) }}"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                </form>
                            @endcan
                        @endif
                        @if ($content->type === 'device')
                            <a href="{{ route('admin.projects.firmwares.list', [$content->project, $content]) }}">
                                <i class="fas fa-microchip"></i> {{ $content->name }}
                            </a>
                            @can('update', $content->project)
                                <span class="badge-pill">
                                    <a href="{{ route('admin.projects.devices.edit', [$content->project, $content]) }}"
                                        class="text-success"><i class="fas fa-edit"></i></a>
                                </span>
                                <span class="badge-pill">
                                    <button class="text-danger"
                                        onclick="event.preventDefault(); if (window.confirm('are you sure to delete the device?')) document.getElementById('delete-device-{{ $content->id }}').submit();"><i
                                            class="fas fa-trash-alt"></i></button>
                                </span>
                                <form id="delete-device-{{ $content->id }}"
                                    action="{{ route('admin.projects.devices.destroy', [$content->project, $content]) }}"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                </form>
                            @endcan
                        @endif
                    </li>
                @empty
                    <li class="list-group-item">
                        @if ($folder->id === 0)
                            this project is empry.
                        @else
                            this folder is empry.
                        @endif
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- 專案成員 --}}
    <h1 class="text-2xl mb-2">Project Member</h1>
    @include('projects.member')
@endsection
