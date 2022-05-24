<div class="sidebar-wrapper bg-light border-right">
    <div class="sidebar-heading">{{ config('app.name', 'Laravel') }} Menu</div>
    <div class="list-group list-group-flush">
        <a href="{{ route('admin.home') }}"
            class="list-group-item list-group-item-action @if (request()->is('admin/projects')) active @else bg-light @endif">Dashboard</a>

        {{-- Projects --}}
        <div>
            <p class="list-group-item bg-secondary" style="color: white"><b>My Projects</b></p>
            @forelse (auth('admin')->user()->my_projects as $my_project)
                @php
                    $name = $my_project->project->name;
                    $path = route('admin.projects.show', $my_project->project);
                    $isActive = request()->is(preg_replace('/^\/?(.*)$/', '$1/*', route('admin.projects.show', $my_project->project, false)));
                @endphp
                <a href="{{ $path }}"
                    class="list-group-item list-group-item-action @if ($isActive) active @else bg-light @endif">{{ $name }}</a>
            @empty
                <p class="list-group-item list-group-item-action bg-light text-muted">No any project</p>
            @endforelse
        </div>

        {{-- Shared Projects --}}
        <p class="list-group-item bg-secondary" style="color: white"><b>Shared Project</b></p>
        @forelse (auth('admin')->user()->shared_projects as $shared_project)
            @php
                $name = $shared_project->project->name;
                $path = route('admin.projects.show', $shared_project->project);
                $isActive = request()->is(preg_replace('/^\/?(.*)$/', '$1/*', route('admin.projects.show', $shared_project->project, false)));
            @endphp
            <a href="{{ $path }}"
                class="list-group-item list-group-item-action @if ($isActive) active @else bg-light @endif">{{ $name }}</a>
        @empty
            <p class="list-group-item list-group-item-action bg-light text-muted">No any shared project</p>
        @endforelse

        {{-- Users --}}
        @if (auth('admin')->user()->isSupervisor)
            @php
                $isActive = request()->routeIs('admin.groups.*');
            @endphp
            <a href="{{ route('admin.users.index') }}"
                class="list-group-item list-group-item-action @if ($isActive) active @else bg-light @endif">Users</a>
        @endif
    </div>
</div>
