@props(['username' => 'Guest'])

<input type="checkbox" id="nav-toggle" class="nav-toggle">

<header class="topbar">
    <label for="nav-toggle" class="menu-btn"><span class="bars"></span><span class="menu-text">Menu</span></label>
    <a class="wordmark" href="{{ route('dashboard', ['username' => $username]) }}">Doksli Café</a>
    <a class="topbar-link" href="{{ route('login') }}"><span class="menu-text">Sign out</span><i data-lucide="log-out"></i></a>
</header>

<nav class="drawer">
    <a href="{{ route('dashboard', ['username' => $username]) }}"><i data-lucide="layout-dashboard"></i>Dashboard</a>
    <a href="{{ route('pengelolaan', ['username' => $username]) }}"><i data-lucide="package"></i>Inventory</a>
    <a href="{{ route('profile', ['username' => $username]) }}"><i data-lucide="user-round"></i>Profile</a>
</nav>
<label for="nav-toggle" class="scrim"></label>
