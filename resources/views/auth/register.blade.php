@extends('layouts.app')

@section('title', __('ui.auth.register_title'))

@section('content')
    <section class="auth-wrap">
        <div class="auth-card">
            <h1 class="page-title">{{ __('ui.auth.register_heading') }}</h1>
            <p class="section-subtitle">{{ __('ui.auth.register_text') }}</p>

            <form action="{{ route('register.store') }}" method="POST" class="auth-form">
                @csrf
                <div class="field">
                    <label for="name">{{ __('ui.common.name') }}</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name">
                </div>
                <div class="field">
                    <label for="email">{{ __('ui.fields.email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                </div>
                <div class="field">
                    <label for="password">{{ __('ui.fields.password') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password">
                </div>
                <div class="field">
                    <label for="password_confirmation">{{ __('ui.fields.password_confirmation') }}</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
                </div>
                <button type="submit" class="btn btn-primary btn-block">{{ __('ui.auth.register_button') }}</button>
            </form>
        </div>
    </section>
@endsection
