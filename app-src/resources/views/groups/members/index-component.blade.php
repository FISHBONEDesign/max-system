<h1 class="text-2xl mb-2">Group Members:</h1>
<a href="{{ route('admin.groups.members.create', $group) }}" class="btn btn-primary mb-2">Add Member</a>
@forelse ($group->members as $member)
    <div class="card mb-2">
        <div class="card-body">
            <div class="mb-2">
                <a href="{{ route('admin.groups.members.edit', [$member->group, $member]) }}">
                    Name: {{ $member->name }} <br>
                    Editable: {{ $member->edit }} <br>
                    created at: {{ $member->created_at }} <br>
                    updated at: {{ $member->updated_at }}
                </a>
            </div>
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
        </div>
    </div>
@empty
    <div class="card-body">No any member.</div>
@endforelse
