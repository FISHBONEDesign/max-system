<div class="sidebar-wrapper bg-light border-right">
    <div class="sidebar-heading">{{ config('app.name', 'Laravel') }} Menu</div>
    <div class="list-group list-group-flush">
        <a href="{{ route('admin.home') }}"
            class="list-group-item list-group-item-action @if (request()->is('admin/projects')) active @else bg-light @endif">Dashboard</a>

        {{-- Projects --}}
        <div>
            <p class="list-group-item bg-secondary" style="color: white"><b>My Projects</b></p>
            @forelse (auth('admin')->user()->projects as $project)
                @php
                    $name = $project->name;
                    $path = route('admin.projects.show', $project);
                    $isActive = request()->is(preg_replace('/^\/?(.*)$/', '$1/*', route('admin.projects.show', $project, false)));
                @endphp
                <a href="{{ $path }}"
                    class="list-group-item list-group-item-action @if ($isActive) active @else bg-light @endif">{{ $name }}</a>
            @empty
                <p class="list-group-item list-group-item-action bg-light text-muted">No any project</p>
            @endforelse
        </div>

        {{-- Shared Projects --}}
        <p class="list-group-item bg-secondary" style="color: white"><b>Shared Project</b></p>
        @forelse (auth('admin')->user()->shared_projects as $project)
            @php
                $name = $project->name;
                $path = route('admin.projects.show', $project);
                $isActive = request()->is(preg_replace('/^\/?(.*)$/', '$1/*', route('admin.projects.show', $project, false)));
            @endphp
            <a href="{{ $path }}"
                class="list-group-item list-group-item-action @if ($isActive) active @else bg-light @endif">{{ $name }}</a>
        @empty
            <p class="list-group-item list-group-item-action bg-light text-muted">No any shared project</p>
        @endforelse

        {{-- Other Projects --}}
        {{-- @php
            $user = auth()->user();
        @endphp
        @if (auth('admin')->user()->isSupervisor)
            <p class="list-group-item bg-secondary" style="color: white"><b>Other Project</b></p>
            @forelse ($projects->diff($user->projects)->diff($user->shared_projects) as $project)
                @php
                    $name = $project->name;
                    $path = route('admin.projects.show', $project);
                    $isActive = request()->is(preg_replace('/^\/?(.*)$/', '$1/*', route('admin.projects.show', $project, false)));
                @endphp
                <a href="{{ $path }}"
                    class="list-group-item list-group-item-action @if ($isActive) active @else bg-light @endif">{{ $name }}</a>
            @empty
                <p class="list-group-item list-group-item-action bg-light text-muted">No any project</p>
            @endforelse
        @endif --}}

        {{-- Groups --}}
        {{-- <p class="list-group-item">Groups</p> --}}
        {{-- @php
            $isActive = request()->routeIs('admin.groups.*');
        @endphp
        <a href="{{ route('admin.groups.index') }}"
            class="list-group-item list-group-item-action @if ($isActive) active @else bg-light @endif">Groups</a> --}}

        {{-- <a href="{{ route('admin.projects.devices.index') }}" class="list-group-item list-group-item-action @if (request()->routeIs('admin.manage.devices.*') || request()->routeIs('admin.manage.firmwares.*')) active @else bg-light @endif">Devices & Firmwares</a> --}}
    </div>
</div>
