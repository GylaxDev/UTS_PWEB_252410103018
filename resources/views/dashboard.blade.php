@extends('layouts.app')

@section('title', 'Dashboard')

@section('navbar')
    <x-navbar :username="$username" />
@endsection

@section('content')
<section class="hero">
    <p class="eyebrow">Welcome to</p>
    <h1>Doksli Café</h1>
    <p class="lead">Crafted with doksli.</p>
    <a class="pill" href="{{ route('pengelolaan', ['username' => $username]) }}">View inventory</a>
</section>

<section class="sheet">
    <div class="wrap">
        <div class="stats">
            @foreach ($summary as $item)
                @include('partials.stat-card', ['item' => $item])
            @endforeach
        </div>

        <div class="two-col">
            <div>
                <h2 class="title">Sales Today</h2>
                @foreach ($sales as $s)
                    <div class="meter-row">
                        <span>{{ $s['time'] }}</span>
                        <div class="meter"><i style="width: {{ $s['cups'] / 250 * 100 }}%"></i></div>
                        <b>{{ $s['cups'] }}</b>
                    </div>
                @endforeach
            </div>

            <div>
                <h2 class="title">Most Used Items</h2>
                @foreach ($trending as $t)
                    <div class="trend-row">
                        <div><strong>{{ $t['name'] }}</strong><small>Rp {{ number_format($t['price'], 0, ',', '.') }} / {{ $t['unit'] }}</small></div>
                        <b>{{ $t['used'] }}</b>
                    </div>
                @endforeach
            </div>
        </div>

        <h2 class="title">Recent Restocks</h2>
        <div class="table-wrap">
            <table>
                <thead><tr><th>#</th><th>Order</th><th>Item</th><th>Quantity</th><th>Time</th><th>Total</th><th>Payment</th></tr></thead>
                <tbody>
                    @foreach ($orders as $o)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $o['id'] }}</td>
                            <td>{{ $o['item'] }}</td>
                            <td>{{ $o['qty'] }}</td>
                            <td>{{ $o['time'] }}</td>
                            <td>Rp {{ number_format($o['total'], 0, ',', '.') }}</td>
                            <td>{{ $o['payment'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
