@extends('layouts.app')
@section('main')
    <div id="app">
        @include('main-navbar')
        <section class="section has-background-light">
            <div class="container">
                @yield('admin-content-top')
            </div>
            <div class="box container mt-3">
                @yield('admin-content')
            </div>
            <div class="container">
                @yield('admin-content-bottom')
            </div>
        </section>
    </div>
@endsection
@section('footer')
    @stack('footer-top')
@endsection
