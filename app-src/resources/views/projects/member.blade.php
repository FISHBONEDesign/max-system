<div class="card mb-2">
    <div class="card-header">
        <span>Group Member</span>
    </div>

    {{-- <div class="card-body"> --}}

    @foreach ($project->member as $member)
        <div class="card m-2 ">
            <div class="card-body ">
                <div class="mb-2">
                    {{ ($project->admin_id == $member->admin_id) ? "Project Owner: " : "Name: " }}
                    {{ $member->name }} <br>
                    Editable: {{ $member->edit ? 'can' : "can't" }}<br>
                    created at: {{ $member->created_at }} <br>
                    updated at: {{ $member->updated_at }}
                </div>
            </div>
        </div>
    @endforeach
    {{-- </div> --}}
</div>
