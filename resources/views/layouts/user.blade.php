<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>@yield('title', 'Restaurant') | BenStoke</title>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --dark: #17130f;
        --dark-soft: #211b15;
        --gold: #c9a45c;
        --gold-light: #e1c27a;
        --cream: #f7f1e6;
        --white: #ffffff;
        --muted: #a9a095;
        --border: rgba(201, 164, 92, 0.18);
        --danger: #c94c4c;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        background: var(--cream);
        color: var(--dark);
        min-height: 100vh;
    }

    /* =========================================
       SIDEBAR
    ========================================= */

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 260px;
        height: 100vh;

        background:
            linear-gradient(
                180deg,
                rgba(33, 27, 21, 0.98),
                rgba(23, 19, 15, 0.99)
            );

        border-right: 1px solid var(--border);

        color: var(--white);
        padding: 24px 16px;

        display: flex;
        flex-direction: column;

        z-index: 1000;
        overflow-y: auto;
    }

    /* Brand */

    .brand {
        text-align: center;
        padding: 8px 5px 25px;
        margin-bottom: 12px;
        border-bottom: 1px solid var(--border);
    }

    .brand-icon {
        width: 54px;
        height: 54px;

        margin: 0 auto 10px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 50%;

        background: rgba(201, 164, 92, 0.12);
        border: 1px solid rgba(201, 164, 92, 0.30);

        font-size: 25px;
    }

    .brand h2 {
        color: var(--gold-light);
        font-size: 21px;
        letter-spacing: 1px;
        margin-bottom: 5px;
    }

    .brand p {
        color: var(--muted);
        font-size: 11px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    /* User */

    .user-box {
        display: flex;
        align-items: center;
        gap: 11px;

        padding: 12px;
        margin: 5px 0 18px;

        background: rgba(255, 255, 255, 0.035);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 12px;
    }

    .user-avatar {
        width: 38px;
        height: 38px;

        flex-shrink: 0;

        display: flex;
        align-items: center;
        justify-content: center;

        background: var(--gold);
        color: var(--dark);

        border-radius: 50%;
        font-size: 17px;
        font-weight: bold;
    }

    .user-info {
        min-width: 0;
    }

    .user-info strong {
        display: block;
        color: var(--white);
        font-size: 14px;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-info span {
        display: block;
        color: var(--muted);
        font-size: 11px;
        margin-top: 3px;
    }

    /* Navigation title */

    .nav-title {
        color: #81786d;
        font-size: 10px;
        font-weight: bold;
        letter-spacing: 1.5px;
        text-transform: uppercase;

        padding: 0 12px 8px;
    }

    /* Navigation */

    .nav {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .nav a {
        position: relative;

        display: flex;
        align-items: center;
        gap: 12px;

        color: #d5cec5;
        text-decoration: none;

        padding: 12px 13px;

        border-radius: 10px;

        font-size: 14px;
        font-weight: 500;

        transition:
            background 0.2s ease,
            color 0.2s ease,
            transform 0.2s ease;
    }

    .nav a:hover {
        background: rgba(201, 164, 92, 0.09);
        color: var(--gold-light);
        transform: translateX(2px);
    }

    .nav a.active {
        background:
            linear-gradient(
                90deg,
                rgba(201, 164, 92, 0.20),
                rgba(201, 164, 92, 0.07)
            );

        color: var(--gold-light);

        border: 1px solid rgba(201, 164, 92, 0.20);
    }

    .nav a.active::before {
        content: "";

        position: absolute;
        left: 0;
        top: 20%;
        width: 3px;
        height: 60%;

        background: var(--gold);
        border-radius: 0 5px 5px 0;
    }

    .nav-icon {
        width: 24px;
        text-align: center;
        font-size: 17px;
    }

    .nav-label {
        flex: 1;
    }

    /* Logout */

    .logout-area {
        margin-top: auto;
        padding-top: 18px;
    }

    .logout {
        width: 100%;
    }

    .logout button {
        width: 100%;

        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;

        padding: 12px;

        border: 1px solid rgba(201, 76, 76, 0.25);
        border-radius: 10px;

        background: rgba(201, 76, 76, 0.09);
        color: #e98b8b;

        cursor: pointer;

        font-size: 14px;
        font-weight: 600;

        transition: all 0.2s ease;
    }

    .logout button:hover {
        background: rgba(201, 76, 76, 0.18);
        color: #ffaaaa;
    }

    /* =========================================
       MAIN CONTENT
    ========================================= */

    .main {
        margin-left: 260px;
        min-height: 100vh;
        padding: 30px;
    }

    /* =========================================
       MOBILE TOP BAR
    ========================================= */

    .mobile-header {
        display: none;
    }

    /* =========================================
       SCROLLBAR
    ========================================= */

    .sidebar::-webkit-scrollbar {
        width: 5px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(201, 164, 92, 0.25);
        border-radius: 10px;
    }

    /* =========================================
       TABLET
    ========================================= */

    @media (max-width: 900px) {

        .sidebar {
            width: 220px;
        }

        .main {
            margin-left: 220px;
            padding: 24px;
        }
    }

    /* =========================================
       MOBILE
    ========================================= */

    @media (max-width: 700px) {

        .sidebar {
            position: relative;

            width: 100%;
            height: auto;

            min-height: auto;

            border-right: none;
            border-bottom: 1px solid var(--border);

            padding: 15px;
        }

        .brand {
            display: flex;
            align-items: center;
            text-align: left;

            padding: 5px 5px 15px;
        }

        .brand-icon {
            width: 42px;
            height: 42px;

            margin: 0 10px 0 0;

            font-size: 20px;
        }

        .brand h2 {
            font-size: 18px;
        }

        .brand p {
            font-size: 9px;
        }

        .user-box {
            margin-bottom: 12px;
        }

        .nav-title {
            display: none;
        }

        .nav {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 6px;
        }

        .nav a {
            padding: 11px 9px;
            font-size: 12px;
            gap: 7px;
        }

        .nav-icon {
            font-size: 15px;
            width: 20px;
        }

        .logout-area {
            margin-top: 10px;
            padding-top: 10px;
        }

        .main {
            margin-left: 0;
            padding: 18px;
        }
    }

    @media (max-width: 420px) {

        .nav {
            grid-template-columns: 1fr;
        }

        .nav a {
            padding: 12px;
        }

        .main {
            padding: 14px;
        }
    }
</style>

@yield('styles')


</head>

<body>


<!-- =========================================
     USER SIDEBAR / NAVIGATION
========================================== -->

<aside class="sidebar">

    <!-- BRAND -->

    <div class="brand">

        <div class="brand-icon">
            🍽️
        </div>

        <div>
            <h2>BenStoke</h2>
            <p>Restaurant & Dining</p>
        </div>

    </div>


    <!-- USER -->

    @auth

        <div class="user-box">

            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>

            <div class="user-info">

                <strong>
                    {{ auth()->user()->name ?? 'Guest' }}
                </strong>

                <span>
                    {{ auth()->user()->role === 'admin' ? 'Administrator' : 'Restaurant Member' }}
                </span>

            </div>

        </div>

    @endauth


    <!-- NAVIGATION -->

    <div class="nav-title">
        Main Menu
    </div>

    <nav class="nav">

        <!-- Dashboard -->

        <a href="{{ route('user.dashboard') }}"
           class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">

            <span class="nav-icon">🏠</span>
            <span class="nav-label">Dashboard</span>

        </a>


        <!-- Menu -->

        <a href="{{ route('user.menu') }}"
           class="{{ request()->routeIs('user.menu') ? 'active' : '' }}">

            <span class="nav-icon">🍽️</span>
            <span class="nav-label">Menu</span>

        </a>


        <!-- Cart -->

        <a href="{{ route('user.cart') }}"
           class="{{ request()->routeIs('user.cart') ? 'active' : '' }}">

            <span class="nav-icon">🛒</span>
            <span class="nav-label">My Cart</span>

        </a>


        <!-- Orders -->

        <a href="{{ route('user.orders') }}"
           class="{{ request()->routeIs('user.orders') ? 'active' : '' }}">

            <span class="nav-icon">📦</span>
            <span class="nav-label">My Orders</span>

        </a>


        <!-- Book Table -->

        <a href="{{ route('user.book-table') }}"
           class="{{ request()->routeIs('user.book-table') ? 'active' : '' }}">

            <span class="nav-icon">🪑</span>
            <span class="nav-label">Book a Table</span>

        </a>


        <!-- Reservations -->

        <a href="{{ route('user.reservations') }}"
           class="{{ request()->routeIs('user.reservations') ? 'active' : '' }}">

            <span class="nav-icon">📅</span>
            <span class="nav-label">Reservations</span>

        </a>


        <!-- Profile -->

        <a href="{{ route('user.profile') }}"
           class="{{ request()->routeIs('user.profile') ? 'active' : '' }}">

            <span class="nav-icon">👤</span>
            <span class="nav-label">Profile</span>

        </a>

    </nav>


    <!-- LOGOUT -->

    <div class="logout-area">

        <form action="{{ route('logout') }}"
              method="POST"
              class="logout">

            @csrf

            <button type="submit">

                <span>🚪</span>
                <span>Logout</span>

            </button>

        </form>

    </div>

</aside>


<!-- =========================================
     MAIN PAGE CONTENT
========================================== -->

<main class="main">

    @yield('content')

</main>


@yield('scripts')


</body>

</html>
