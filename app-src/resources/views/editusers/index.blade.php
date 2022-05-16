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
                            <div class="card-header">Name: {{ $users->name }}</div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">E-mail: {{ $users->email }} </li>
                                <li class="list-group-item">
                                    Permission:
                                    <select name="userPermission" id="" class="form-control tags" style="width: 200px">
                                        @foreach ($roles as $r)
                                            @php
                                                $selected = $users->role == $r->role ? 'selected' : '';
                                            @endphp
                                            <option {{ $selected }} value="{{ $r->role }}">{{ $r->role }}
                                            </option>
                                        @endforeach
                                    </select>
                                </li>
                                <li class="list-group-item">
                                    Owned Projects:
                                    @foreach ($users->adminProject as $p)
                                        @if ($p->manage)
                                            {{ $p->manage }}
                                            @if ($loop->last)
                                            @else
                                                ,
                                            @endif
                                        @endif
                                    @endforeach
                                </li>
                            </ul>

                            <div class="form-group row m-2">
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
