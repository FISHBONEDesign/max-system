@extends('layouts.admin')

@php
    $action = route('admin.member.update', [$member->project, $member]);
    $update = true;
    $form_parameters = compact('action', 'update', 'member');
@endphp

@section('content')
    <div class="card">
        <div class="card-header">Edit Member Permission</div>
        <div class="card-body">
            @component('projectmembers.form', $form_parameters)
            @endcomponent
        </div>
    </div>
@endsection
