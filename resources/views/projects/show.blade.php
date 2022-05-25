<h1 class="text-2xl mb-2">Project Name</h1>
<div class="card mb-2">
    <div class="card-header">{{ $project->name }} &nbsp;&nbsp;&nbsp;
        @canany(['admin', 'manager'])
            @if (Gate::allows('admin') || $project->isProjectManager(auth('admin')->user()->id))
                <a href="{{ route('admin.projects.edit', $project) }}" class="text-success">
                    <i class="fas fa-edit"></i>
                </a>
            @endif
        @endcanany
        @can('admin')
            <button type="button" class="text-danger"
                onclick="event.preventDefault(); if (window.confirm('are you sure to delete the project and contents?')) document.getElementById('delete-project-{{ $project->id }}').submit();">
                <i class="fas fa-trash-alt"></i>
            </button>
        @endcan
        <form id="delete-project-{{ $project->id }}" method="post"
            action="{{ route('admin.projects.destroy', $project) }}">
            @csrf
            @method('delete')
        </form>
    </div>

    <div class="card-body">
        project manager:
        <br>
        @foreach ($project->adminProject as $member)
            @if ($member->owner)
                {{ $member->name }}
                @if ($loop->last)
                @else
                    ,
                @endif
            @endif
        @endforeach
        <br><br>
        created at: {{ $project->created_at }} <br>
        updated at: {{ $project->updated_at }} <br>
    </div>
</div>
