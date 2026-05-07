@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container admin-layout">
            @include('partials.admin-sidebar')

            <div class="admin-main">
                @yield('admin_content')
            </div>
        </div>
    </section>
@endsection
