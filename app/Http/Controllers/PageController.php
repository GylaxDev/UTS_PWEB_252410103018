<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    private function inventory(): array
    {
        return [
            ['code' => 'KP-001', 'name' => 'Kintamuani Arabica Beans', 'category' => 'Coffee Beans', 'stock' => 42, 'unit' => 'kg', 'price' => 185000, 'status' => 'In Stock'],
            ['code' => 'KP-002', 'name' => 'Amba Specials', 'category' => 'Coffee Beans', 'stock' => 8, 'unit' => 'kg', 'price' => 95000, 'status' => 'Low Stock'],
            ['code' => 'SU-001', 'name' => 'Susu Murni Nasional', 'category' => 'Dairy', 'stock' => 25, 'unit' => 'litre', 'price' => 22000, 'status' => 'In Stock'],
            ['code' => 'SR-001', 'name' => 'Sirup Asli Mas Rusdi', 'category' => 'Syrup', 'stock' => 5, 'unit' => 'bottle', 'price' => 68000, 'status' => 'Low Stock'],
            ['code' => 'SR-002', 'name' => 'Sirup Fuad 45', 'category' => 'Syrup', 'stock' => 14, 'unit' => 'bottle', 'price' => 70000, 'status' => 'In Stock'],
            ['code' => 'PK-001', 'name' => 'Paper Cup 8oz', 'category' => 'Packaging', 'stock' => 300, 'unit' => 'pcs', 'price' => 650, 'status' => 'In Stock'],
            ['code' => 'PK-002', 'name' => 'Plastic Cup 16oz', 'category' => 'Packaging', 'stock' => 3, 'unit' => 'pack', 'price' => 38000, 'status' => 'Critical'],
        ];
    }

    private function username(Request $request): string
    {
        return $request->query('username', 'Guest');
    }

    public function login()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|min:3',
            'password' => 'required|min:4',
        ]);

        return redirect()->route('dashboard', ['username' => $data['username']]);
    }

    public function dashboard(Request $request)
{
    $items = $this->inventory();
    $byCode = array_column($items, null, 'code');

    $sales = [
        ['time' => '09:00', 'cups' => 70],
        ['time' => '11:00', 'cups' => 110],
        ['time' => '13:00', 'cups' => 95],
        ['time' => '15:00', 'cups' => 150],
        ['time' => '17:00', 'cups' => 230],
        ['time' => '19:00', 'cups' => 160],
    ];

    $usage = ['KP-001' => 240, 'SU-001' => 220, 'SR-001' => 200, 'KP-002' => 100];

    $trending = [];
    foreach ($items as $item) {
        if (isset($usage[$item['code']])) {
            $trending[] = [
                'name' => $item['name'],
                'price' => $item['price'],
                'unit' => $item['unit'],
                'used' => $usage[$item['code']],
            ];
        }
    }

    usort($trending, fn ($a, $b) => $b['used'] <=> $a['used']);

    $restocks = [
        ['id' => '#RS-1042', 'code' => 'KP-002', 'qty' => 10, 'time' => '09:12', 'payment' => 'Cash'],
        ['id' => '#RS-1043', 'code' => 'SU-001', 'qty' => 20, 'time' => '09:40', 'payment' => 'Card'],
        ['id' => '#RS-1044', 'code' => 'SR-001', 'qty' => 6, 'time' => '10:05', 'payment' => 'E-Wallet'],
    ];

    $orders = [];
    foreach ($restocks as $r) {
        $stockItem = $byCode[$r['code']];
        $orders[] = [
            'id' => $r['id'],
            'item' => $stockItem['name'],
            'qty' => $r['qty'] . ' ' . $stockItem['unit'],
            'time' => $r['time'],
            'total' => $stockItem['price'] * $r['qty'],
            'payment' => $r['payment'],
        ];
    }

    $needRestock = count(array_filter($items, fn ($item) => $item['status'] !== 'In Stock'));

    $summary = [
        ['icon' => 'package', 'label' => 'Total Items', 'value' => count($items)],
        ['icon' => 'triangle-alert', 'label' => 'Need Restock', 'value' => $needRestock],
        ['icon' => 'receipt', 'label' => 'Restocks Today', 'value' => count($orders)],
    ];

    return view('dashboard', [
        'username' => $this->username($request),
        'summary' => $summary,
        'sales' => $sales,
        'trending' => $trending,
        'orders' => $orders,
    ]);
}

    public function pengelolaan(Request $request)
    {
        return view('pengelolaan', [
            'username' => $this->username($request),
            'items' => $this->inventory(),
        ]);
    }

    public function profile(Request $request)
    {
        $username = $this->username($request);

        return view('profile', [
            'username' => $username,
            'info' => [
                'Role' => 'Head Barista',
                'House' => 'Perumahan Amba, Ngawi',
                'Member since' => 'January 2026',
                'Email' => strtolower($username) . '@doksli.com',
            ],
        ]);
    }
}
