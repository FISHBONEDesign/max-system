<h1 class="text-2xl mb-2">Group Members:</h1>
@can('update', $group)
    <a href="{{ route('admin.groups.members.create', $group) }}" class="btn btn-primary mb-2">Add Member</a>
@endcan
@forelse ($group->members as $member)
    <div class="card mb-2">
        <div class="card-body">
            <div class="mb-2">
                @can('update', $group)
                    @if ($group->projects->admin_id == $member->admin_id || auth('admin')->user()->id == $member->admin_id)
                        {{ ($group->projects->admin_id === $member->admin_id) ? 'Project Owner: ': 'Name: '}}
                        {{ $member->name }} <br>
                        Editable: {{ $member->edit ? 'true' : 'false' }} <br>
                        created at: {{ $member->created_at }} <br>
                        updated at: {{ $member->updated_at }}
                    @else
                        <a href="{{ route('admin.groups.members.edit', [$member->group, $member]) }}">
                            Name: {{ $member->name }} <br>
                            Editable: {{ $member->edit ? 'true' : 'false' }} <br>
                            created at: {{ $member->created_at }} <br>
                            updated at: {{ $member->updated_at }}
                        </a>
                        <br>
                        @php
                            $delete_form_id = "group-{$member->group->id}-member-{$member->id}-delete";
                        @endphp
                        <button type="button" class="btn btn-danger"
                            onclick="if (window.confirm('are you sure remove {{ addslashes($member->name) }} from {{ addslashes($member->group->name) }}?')) document.querySelector('form#{{ $delete_form_id }}').submit();">
                            <i class="fas fa-trash-alt"></i> Remove User
                        </button>
                        <form id="{{ $delete_form_id }}" method="post"
                            action="{{ route('admin.groups.members.destroy', [$member->group, $member]) }}">
                            @csrf
                            @method('delete')
                        </form>
                    @endif
                @elsecan('view', $group)
                    Name: {{ $member->name }} <br>
                    Editable: {{ $member->edit ? 'true' : 'false' }} <br>
                    created at: {{ $member->created_at }} <br>
                    updated at: {{ $member->updated_at }}
                @endcan
            </div>
            @can('update', $group)
            @endcan
        </div>
    </div>
@empty
    <div class="card-body">No any member.</div>
@endforelse
