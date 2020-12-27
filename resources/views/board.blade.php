@extends('layouts.app')

@section('title', config('app.name'))

@section('content')

    <router-view></router-view>

@endsection

@push('script')
    <script src="{{ mix('js/board.js') }}" defer></script>
    <script>
        @auth
            window.User = {!! Auth::user() !!};
            window.Settings = {!! $settings !!};
        @else
            window.User = null;
            window.Settings = {!! $settings !!};
        @endauth
    </script>  
@endpush