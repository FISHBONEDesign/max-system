@php
$ext_class = $active ? 'active' : '';
@endphp
<li class="nav-item" role="presentation">
    <a class="nav-link {{ $ext_class }}" id="{{ $id }}-tab" data-toggle="tab" href="#{{ $id }}"
        role="tab" aria-controls="{{ $id }}" aria-selected="true">{{ $name }}</a>
</li>
