<div class="sidebar-wrapper bg-light border-right">
    <div class="sidebar-heading">Max System Admin</div>
    <div class="list-group list-group-flush">
        <a href="{{ route('admin.home') }}" class="list-group-item list-group-item-action @if (request()->is('admin')) active @else bg-light @endif">Dashboard</a>
        <a href="{{ route('admin.manage.devices.index') }}" class="list-group-item list-group-item-action @if (request()->routeIs('admin.manage.devices.*') ||
        request()->routeIs('admin.manage.firmwares.*')) active @else bg-light @endif">Devices & Firmwares</a>
    </div>
</div>
