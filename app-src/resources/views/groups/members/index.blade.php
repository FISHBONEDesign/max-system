@extends('layouts.admin')

@section('content')
    @component('groups.show-component', compact('group'))
    @endcomponent
    @component('groups.members.index-component', compact('group'))
    @endcomponent
@endsection
