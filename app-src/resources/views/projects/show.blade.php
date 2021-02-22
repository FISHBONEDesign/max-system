<div class="card mb-2">
    <div class="card-header">{{ $project->name }} &nbsp;&nbsp;&nbsp;
        <a href="{{ route('admin.projects.edit', $project) }}" class="text-success">
            <i class="fas fa-edit"></i>
        </a>
        <button type="button" class="text-danger"
            onclick="event.preventDefault(); if (window.confirm('are you sure to delete the project and contents?')) document.getElementById('delete-project-{{ $project->id }}').submit();">
            <i class="fas fa-trash-alt"></i>
        </button>
        <form id="delete-project-{{ $project->id }}" method="post" action="{{ route('admin.projects.destroy', $project) }}">
            @csrf
            @method('delete')
        </form>
    </div>

    <div class="card-body">
        created at: {{ $project->created_at }} <br>
        updated at: {{ $project->updated_at }} <br>
    </div>
</div>
