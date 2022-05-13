@canany(['manager', 'admin'])
    @if (Gate::allows('admin') || $project->isProjectManager(auth('admin')->user()->id))
        <a href="{{ route('admin.member.create', $project->id) }}" class="btn btn-primary mb-2">Add
            Member</a>
    @endif
@endcanany
<div class="card mb-2">
    {{-- <div class="card-body"> --}}
    @foreach ($project->adminProject as $member)
        <div class="card">
            <div class="card-body">
                @if (Gate::allows('admin') || $project->isProjectManager(auth('admin')->user()->id))
                    @if ($member->admin_id == auth('admin')->user()->id || $member->admin->isAdmin())
                        <div>
                            {{ $member->owner ? 'Project Owner: ' : 'Name: ' }}
                            {{ $member->name }} <br>
                            Editable: {{ $member->edit ? 'can' : "can't" }}<br>
                            created at: {{ $member->created_at }} <br>
                            updated at: {{ $member->updated_at }}
                        </div>
                    @else
                        <div>
                            <a href="{{ route('admin.member.edit', [$member->project, $member]) }}">
                                {{ $member->owner ? 'Project Owner: ' : 'Name: ' }}
                                {{ $member->name }} <br>
                                Editable: {{ $member->edit ? 'can' : "can't" }}<br>
                                created at: {{ $member->created_at }} <br>
                                updated at: {{ $member->updated_at }}
                            </a>
                        </div>
                        @php
                            $delete_form_id = "group-{$member->project->id}-member-{$member->id}-delete";
                        @endphp
                        <button type="button" class="btn btn-danger"
                            onclick="if (window.confirm('are you sure remove {{ addslashes($member->name) }} from {{ addslashes($member->project->name) }}?')) document.querySelector('form#{{ $delete_form_id }}').submit();">
                            <i class="fas fa-trash-alt"></i> Remove User
                        </button>
                        <form id="{{ $delete_form_id }}" method="post"
                            action="{{ route('admin.member.destroy', [$member->project, $member]) }}">
                            @csrf
                            @method('delete')
                        </form>
                    @endif
                @else
                    <div>
                        {{ $member->owner ? 'Project Owner: ' : 'Name: ' }}
                        {{ $member->name }} <br>
                        Editable: {{ $member->edit ? 'can' : "can't" }}<br>
                        created at: {{ $member->created_at }} <br>
                        updated at: {{ $member->updated_at }}
                    </div>
                @endif
            </div>
        </div>
    @endforeach
    {{-- </div> --}}
</div>
