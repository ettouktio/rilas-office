@extends('layouts.app')

@section('title', __('ui.auth.login_title'))

@section('content')
    <section class="auth-wrap">
        <div class="auth-card">
            <h1 class="page-title">{{ __('ui.auth.login_heading') }}</h1>
            <p class="section-subtitle">{{ __('ui.auth.login_text') }}</p>

            <form action="{{ route('login.attempt') }}" method="POST" class="auth-form">
                @csrf
                <div class="field">
                    <label for="email">{{ __('ui.fields.email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                </div>
                <div class="field">
                    <label for="password">{{ __('ui.fields.password') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password">
                </div>
                <div class="checkbox-row">
                    <input id="remember" type="checkbox" name="remember" value="1" @checked(old('remember'))>
                    <label for="remember">{{ __('ui.fields.remember') }}</label>
                </div>
                <button type="submit" class="btn btn-primary btn-block">{{ __('ui.auth.login_button') }}</button>
            </form>
        </div>
    </section>
@endsection
