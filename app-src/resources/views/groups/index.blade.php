@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl mb-2">Groups:</h1>
    <a href="{{ route('admin.groups.create') }}" class="btn btn-primary mb-2">Create Group</a>
    @forelse ($groups as $group)
        <div class="card mb-2">
            <a href="{{ route('admin.groups.show', $group) }}">
                <div class="card-header">{{ $group->name }}</div>
                <div class="card-body">
                    Model: {{ $group->model }} <br>
                    Object: {{ $group->object }} <br>
                    created at: {{ $group->created_at }} <br>
                    updated at: {{ $group->updated_at }}
                </div>
            </a>
        </div>
    @empty
        <div class="card-body">No any group.</div>
    @endforelse
@endsection
