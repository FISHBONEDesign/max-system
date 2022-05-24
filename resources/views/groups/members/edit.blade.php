@extends('layouts.admin')

@php
    $action = route('admin.groups.members.update', [$member->group, $member]);
    $update = true;
    $form_parameters = compact('action', 'update', 'member');
@endphp

@section('content')
    <div class="card">
        <div class="card-header">Edit Group</div>
        <div class="card-body">
            @component('groups.members.form', $form_parameters)
            @endcomponent
        </div>
    </div>
@endsection
