<div class="sidebar-wrapper bg-light border-right">
    <div class="sidebar-heading">Max System Admin</div>
    <div class="list-group list-group-flush">
        <a href="{{ route('admin.home') }}" class="list-group-item list-group-item-action @if (request()->is('admin')) active @else bg-light @endif">Dashboard</a>
        @forelse (auth()->user()->projects as $project)
            @php
                $name = $project->name;
                $path = route('admin.projects.show', $project);
                $isActive = request()->is(preg_replace('/^\/?(.*)$/', '$1/*', route('admin.projects.show', $project, false)));
            @endphp
            <a href="{{ $path }}" class="list-group-item list-group-item-action @if ($isActive) active @else bg-light @endif">{{ $name }}</a>
        @empty

        @endforelse
        <a href="{{ route('admin.manage.devices.index') }}" class="list-group-item list-group-item-action @if (request()->routeIs('admin.manage.devices.*') ||
        request()->routeIs('admin.manage.firmwares.*')) active @else bg-light @endif">Devices & Firmwares</a>
    </div>
</div>
