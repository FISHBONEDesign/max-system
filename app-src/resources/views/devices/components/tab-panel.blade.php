@component('components.tab-panel', ['id' => $id, 'active' => $active])
    <ul class="list-group">
        @forelse ($devices as $index => $device)
            <li class="list-group-item">
                <span class="badge-pill">#{{ $index }}</span>
                {{ $device->name }}
                <span class="badge-pill">
                    <a href="{{ route('admin.manage.devices.edit', $device->id) }}" class="btn text-success">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" class="btn text-danger"
                        onclick="event.preventDefault();document.getElementById('delete-device-{{ $device->id }}').submit();console.log();">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <form id="delete-device-{{ $device->id }}" class="d-none" method="post"
                        action="{{ route('admin.manage.devices.destroy', $device->id) }}">
                        @csrf
                        @method('delete')
                    </form>
                </span>
            </li>
        @empty
            <li class="list-group-item">no any device found.</li>
        @endforelse
    </ul>
@endcomponent
