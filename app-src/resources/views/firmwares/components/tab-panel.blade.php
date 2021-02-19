@component('components.tab-panel', ['id' => $id, 'active' => $active])
    <ul class="list-group">
        @forelse ($devices as $index => $device)
            <li class="list-group-item">
                <a href="{{ route('admin.manage.firmwares.list', $device) }}">
                    <span class="badge-pill">#{{ $index }}</span>
                    {{ $device->name }}
                    <span class="badge-pill">
                    </span>
                </a>
            </li>
        @empty
            <li class="list-group-item">no any device found.</li>
        @endforelse
    </ul>
@endcomponent
