@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
<section class="login-page">
    <form class="login-form" method="POST" action="{{ route('login.submit') }}">
        @csrf
        <span class="wordmark">DOKSLI CAFÉ</span>
        <h1>Welcome Suki</h1>

        @if ($errors->any())
            <div class="alert">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <label for="username">Username</label>
        <input id="username" type="text" name="username" value="{{ old('username') }}">

        <label for="password">Password</label>
        <input id="password" type="password" name="password">

        <button type="submit" class="pill">Sign in</button>
    </form>
</section>
@endsection
