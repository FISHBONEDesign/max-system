@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Profile <a href="{{ route('auth.admin.profile.edit') }}"
                class="ml-2 text-success"><i class="fas fa-edit"></i></a></div>
        <div class="card-body">
            Name: {{ $user->name }}<br>
            E-mail: {{ $user->email }}<br>
            Created at: {{ $user->created_at }}<br>
            Updated at: {{ $user->updated_at }}
        </div>
    </div>
@endsection
