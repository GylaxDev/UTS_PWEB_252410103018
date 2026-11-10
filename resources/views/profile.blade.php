@extends('layouts.app')

@section('title', 'Profile')

@section('navbar')
    <x-navbar :username="$username" />
@endsection

@section('content')
<section class="hero short">
    <p class="eyebrow">Profile</p>
    <h1>{{ $username }}</h1>
</section>

<section class="sheet">
    <dl class="profile">
        @foreach ($info as $label => $value)
            <dt>{{ $label }}</dt>
            <dd>{{ $value }}</dd>
        @endforeach
    </dl>
</section>
@endsection
