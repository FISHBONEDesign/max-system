<a href="{{ route('admin.groups.index') }}" class="btn btn-outline-dark mb-2">{{ '< Groups' }}</a>
<div class="card mb-2">
    <div class="card-header">{{ $group->name }} &nbsp;&nbsp;&nbsp;
        <a href="{{ route('admin.groups.edit', $group) }}" class="text-success">
            <i class="fas fa-edit"></i>
        </a>
        <button type="button" class="text-danger"
            onclick="event.preventDefault(); if (window.confirm('are you sure to delete the group and contents?')) document.getElementById('delete-group-{{ $group->id }}').submit();">
            <i class="fas fa-trash-alt"></i>
        </button>
        <form id="delete-group-{{ $group->id }}" method="post"
            action="{{ route('admin.groups.destroy', $group) }}">
            @csrf
            @method('delete')
        </form>
    </div>

    <div class="card-body">
        created at: {{ $group->created_at }} <br>
        updated at: {{ $group->updated_at }} <br>
    </div>
</div>
