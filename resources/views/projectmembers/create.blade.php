@extends('layouts.admin')

@php
    $action = route('admin.member.store', $member->project);
    $update = false;
    $form_parameters = compact('action', 'update', 'member');
@endphp

@section('content')
    <div class="card">
        <div class="card-header">Add New Member</div>
        <div class="card-body">
            @component('projectmembers.form', $form_parameters)
            @endcomponent
        </div>
    </div>
@endsection
