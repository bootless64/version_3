@extends('master')

@section('meta')
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('master_content')
    <div id="app">

        <main>
            @yield('content')
        </main>

    </div>
@endsection

@section('script')
    
@endsection
