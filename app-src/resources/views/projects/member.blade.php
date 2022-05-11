@canany(['manager', 'admin'])
    @if (auth('admin')->user()->id !== $project->owner->id)
    @else
        <a href="{{ route('admin.groups.members.create', $project->group->id) }}" class="btn btn-primary mb-2">Add
            Member</a>
    @endif
@endcanany

<div class="card mb-2">
    {{-- <div class="card-body"> --}}
    @foreach ($project->member as $member)
        <div class="card">
            <div class="card-body">
                <div>
                    {{ $project->admin_id == $member->admin_id ? 'Project Owner: ' : 'Name: ' }}
                    {{ $member->name }} <br>
                    Editable: {{ $member->edit ? 'can' : "can't" }}<br>
                    created at: {{ $member->created_at }} <br>
                    updated at: {{ $member->updated_at }}
                </div>
                @if ($project->admin_id == $member->admin_id || auth('admin')->user()->id == $member->admin_id)
                @else
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
            </div>
        </div>
    @endforeach
    {{-- </div> --}}
</div>
