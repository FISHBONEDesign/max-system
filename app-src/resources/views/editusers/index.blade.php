@extends('layouts.admin')

@section('content')
    @if (auth('admin')->user()->isSupervisor)
        <h1 class="text-2xl mb-2">Users: </h1>
        <div class="mb-2">

            @forelse ($users as $users)
                <form action="{{ route('admin.users.update', $users) }}" method="post">
                    @csrf
                    @method('PATCH')
                    @if ($users->id == 1)
                    @else
                        <div class="card mb-2">
                            <div class="card-header">{{ $users->name }}</div>
                            <div class="card-body">
                                email: {{ $users->email }} <br>
                                role: {{ $users->role }}
                            </div>
                            <div class="col-sm-10 mb-4" style="width: 200px;">

                                <select name="userPermission" id="" class="form-control tags">
                                    <option value="admin">admin</option>
                                    <option value="manager">manager</option>
                                    <option value="user" selected>user</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('admin.home') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
            @empty
                <div class="card-body">No any project found.</div>
            @endforelse
        </div>
    @endif
@endsection
