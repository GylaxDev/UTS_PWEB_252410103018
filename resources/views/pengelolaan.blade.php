@extends('layouts.app')

@section('title', 'Inventory')

@section('navbar')
    <x-navbar :username="$username" />
@endsection

@section('content')
<section class="hero short">
    <p class="eyebrow">Management</p>
    <h1>The Inventory</h1>
    <p class="lead">Manage your doksli</p>
</section>

<section class="sheet">
    <div class="wrap">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>#</th><th>Code</th><th>Item</th><th>Category</th><th>Stock</th><th>Price</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['code'] }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['category'] }}</td>
                            <td>{{ $item['stock'] }} {{ $item['unit'] }}</td>
                            <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td>
                                @if ($item['status'] === 'In Stock')
                                    <span class="tag ok">In Stock</span>
                                @else
                                    <span class="tag warn">{{ $item['status'] }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
