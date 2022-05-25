<h1 class="text-2xl mb-2">Project Member</h1>

@canany(['manager', 'admin'])
    @if (Gate::allows('admin') || $project->isProjectManager(auth('admin')->user()->id))
        <a href="{{ route('admin.member.create', $project->id) }}" class="btn btn-primary mb-2">Add
            Member</a>
    @endif
@endcanany

@foreach ($project->adminProject as $member)
    @if (Gate::allows('admin'))
    <div class="card mb-2">
        <a href="{{ route('admin.member.edit', [$member->project, $member]) }}">
            <div class="card-header">
                {{ $member->owner ? 'Project Owner: ' : 'Name: ' }}
                {{ $member->name }} <br>
            </div>
            <div class="card-body">
                Editable: {{ $member->edit ? 'can' : "can't" }}<br>
                created at: {{ $member->created_at }} <br>
                updated at: {{ $member->updated_at }}
            </div>
        </a>
        @php
            $delete_form_id = "group-{$member->project->id}-member-{$member->id}-delete";
        @endphp
        <button type="button" class="btn btn-danger ml-4 mb-4" style="width: 200px"
            onclick="if (window.confirm('are you sure remove {{ addslashes($member->name) }} from {{ addslashes($member->project->name) }}?')) document.querySelector('form#{{ $delete_form_id }}').submit();">
            <i class="fas fa-trash-alt"></i> Remove User
        </button>
        <form id="{{ $delete_form_id }}" method="post"
            action="{{ route('admin.member.destroy', [$member->project, $member]) }}">
            @csrf
            @method('delete')
        </form>
    </div>
    @elseif($project->isProjectManager(auth('admin')->user()->id))
        @if ($member->admin_id == auth('admin')->user()->id || $member->admin->isAdmin() || $member->owner)
        @else
            <div class="card mb-2">
                <a href="{{ route('admin.member.edit', [$member->project, $member]) }}">
                    <div class="card-header">
                        {{ $member->owner ? 'Project Owner: ' : 'Name: ' }}
                        {{ $member->name }} <br>
                    </div>
                    <div class="card-body">
                        Editable: {{ $member->edit ? 'can' : "can't" }}<br>
                        created at: {{ $member->created_at }} <br>
                        updated at: {{ $member->updated_at }}
                    </div>
                </a>
                @php
                    $delete_form_id = "group-{$member->project->id}-member-{$member->id}-delete";
                @endphp
                <button type="button" class="btn btn-danger ml-4 mb-4" style="width: 200px"
                    onclick="if (window.confirm('are you sure remove {{ addslashes($member->name) }} from {{ addslashes($member->project->name) }}?')) document.querySelector('form#{{ $delete_form_id }}').submit();">
                    <i class="fas fa-trash-alt"></i> Remove User
                </button>
                <form id="{{ $delete_form_id }}" method="post"
                    action="{{ route('admin.member.destroy', [$member->project, $member]) }}">
                    @csrf
                    @method('delete')
                </form>
            </div>
        @endif
    @else
        @if ($member->owner)
        @else
            <div class="card mb-2">
                <div class="card-header">
                    {{ $member->owner ? 'Project Owner: ' : 'Name: ' }}
                    {{ $member->name }} <br>
                </div>
                <div class="card-body">
                    Editable: {{ $member->edit ? 'can' : "can't" }}<br>
                    created at: {{ $member->created_at }} <br>
                    updated at: {{ $member->updated_at }}
                </div>
            </div>
        @endif
    @endif
@endforeach
