@php
    $parameters = [$folder->project];
    if ($folder->parent) $parameters[] = $folder->parent;
@endphp

@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Create New Folder</div>
        <div class="card-body">
            @component('projects.folders.form', [
                'action' => route('admin.projects.folders.store', $parameters),
                'update' => false,
                'folder' => $folder
            ])
            @endcomponent
        </div>
    </div>
@endsection
