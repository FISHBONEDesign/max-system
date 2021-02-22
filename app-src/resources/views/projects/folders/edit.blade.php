@php
    $parameters = [$folder->project, $folder];
@endphp

@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Edit Folder</div>
        <div class="card-body">
            @component('projects.folders.form', [
                'action' => route('admin.projects.folders.update', $parameters),
                'update' => true,
                'folder' => $folder
                ])
            @endcomponent
        </div>
    </div>
@endsection
