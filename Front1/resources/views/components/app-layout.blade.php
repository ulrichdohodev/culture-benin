@extends('layouts.app')

@section('content')
    @includeIf('layouts.navigation')

    {{ $slot }}
@endsection
