<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Panel') | Restaurant Management</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --primary: #f59e0b;
            --primary-dark: #d97706;
            --sidebar: #111827;
            --sidebar-light: #1f2937;
            --sidebar-text: #cbd5e1;
            --bg: #f8fafc;
            --white: #fff;
            --text: #1f2937;
            --muted: #64748b;
            --border: #e5e7eb;
            --danger: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        a {
            text-decoration: none;
        }

        button, input, select, textarea {
            font: inherit;
        }

        /* SIDEBAR */

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 265px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 22px 16px 18px;
            color: var(--white);
            background: linear-gradient(180deg, #111827, #172033);
            border-right: 1px solid rgba(255,255,255,.06);
            z-index: 1000;
            overflow-y: auto;
            transition: transform .25s ease;
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 7px 9px 23px;
            margin-bottom: 25px;
            border-bottom: 1px solid rgba(255,255,255,.09);
        }

        .brand-icon {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            display: grid;
            place-items: center;
            border-radius: 14px;
            color: #111827;
            font-size: 21px;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            box-shadow: 0 7px 18px rgba(245,158,11,.22);
        }

        .brand-text h2 {
            font-size: 16px;
            font-weight: 750;
            letter-spacing: -.3px;
        }

        .brand-text span {
            display: block;
            margin-top: 5px;
            color: #94a3b8;
            font-size: 10px;
            letter-spacing: 1.2px;
        }

        .sidebar-section-title {
            padding: 0 12px;
            margin-bottom: 11px;
            color: #718096;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.4px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .sidebar-nav a {
            position: relative;
            display: flex;
            align-items: center;
            gap: 13px;
            min-height: 46px;
            padding: 11px 13px;
            border: 1px solid transparent;
            border-radius: 11px;
            color: var(--sidebar-text);
            font-size: 13.5px;
            font-weight: 500;
            transition: background .2s, color .2s, transform .2s;
        }

        .sidebar-nav a:hover {
            background: rgba(255,255,255,.07);
            color: #fff;
            transform: translateX(2px);
        }

        .sidebar-nav a.active {
            color: #fbbf24;
            background: linear-gradient(
                90deg,
                rgba(245,158,11,.17),
                rgba(245,158,11,.07)
            );
            border-color: rgba(245,158,11,.12);
            font-weight: 650;
        }

        .sidebar-nav a.active::before {
            content: "";
            position: absolute;
            left: -1px;
            top: 9px;
            bottom: 9px;
            width: 3px;
            border-radius: 0 5px 5px 0;
            background: var(--primary);
        }

        .nav-icon {
            width: 21px;
            text-align: center;
            font-size: 16px;
            color: #94a3b8;
        }

        .sidebar-nav a.active .nav-icon {
            color: #fbbf24;
        }

        .add-menu-link {
            margin-top: 4px;
            background: rgba(245,158,11,.08);
        }

        /* SIDEBAR FOOTER */

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 22px;
        }

        .admin-divider {
            height: 1px;
            background: rgba(255,255,255,.09);
            margin-bottom: 16px;
        }

        .sidebar-admin {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 7px 16px;
        }

        .sidebar-admin-avatar {
            width: 35px;
            height: 35px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border-radius: 11px;
            background: rgba(245,158,11,.15);
            color: #fbbf24;
        }

        .sidebar-admin-name {
            color: #f8fafc;
            font-size: 12px;
            font-weight: 650;
            overflow-wrap: anywhere;
        }

        .sidebar-admin-role {
            color: #94a3b8;
            font-size: 10px;
            margin-top: 3px;
        }

        .logout {
            margin: 0;
        }

        .logout button {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 11px 14px;
            border: 1px solid rgba(239,68,68,.24);
            border-radius: 10px;
            background: rgba(239,68,68,.08);
            color: #fca5a5;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: .2s ease;
        }

        .logout button:hover {
            background: var(--danger);
            border-color: var(--danger);
            color: white;
        }

        /* MAIN AREA */

        .main-wrapper {
            min-height: 100vh;
            margin-left: 265px;
            display: flex;
            flex-direction: column;
        }

        /* TOPBAR */

        .topbar {
            position: sticky;
            top: 0;
            z-index: 900;
            min-height: 76px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 12px 30px;
            background: rgba(255,255,255,.96);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 3px 12px rgba(15,23,42,.025);
            backdrop-filter: blur(12px);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .topbar-title {
            color: #111827;
            font-size: 19px;
            font-weight: 750;
            letter-spacing: -.45px;
        }

        .topbar-subtitle {
            margin-top: 4px;
            color: var(--muted);
            font-size: 11.5px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 6px 12px 6px 7px;
            border: 1px solid #edf0f4;
            border-radius: 13px;
            background: #fff;
        }

        .admin-avatar {
            width: 39px;
            height: 39px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            border-radius: 12px;
            color: #78350f;
            background: linear-gradient(135deg, #fde68a, #f59e0b);
            font-size: 16px;
            font-weight: 800;
        }

        .admin-profile-name {
            max-width: 170px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: #111827;
            font-size: 12.5px;
            font-weight: 700;
        }

        .admin-profile-role {
            margin-top: 4px;
            color: var(--muted);
            font-size: 10.5px;
        }

        .mobile-menu-btn {
            display: none;
            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: #fff;
            color: #1f2937;
            cursor: pointer;
            font-size: 17px;
        }

        /* CONTENT */

        .main {
            width: 100%;
            flex: 1;
            padding: 28px 30px;
        }

        .admin-alert {
            padding: 14px 17px;
            margin-bottom: 22px;
            border: 1px solid transparent;
            border-radius: 11px;
            font-size: 13px;
        }

        .admin-alert-success {
            color: #166534;
            background: #f0fdf4;
            border-color: #bbf7d0;
        }

        .admin-alert-error {
            color: #991b1b;
            background: #fef2f2;
            border-color: #fecaca;
        }

        /* MOBILE OVERLAY */

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 950;
            background: rgba(15,23,42,.58);
            backdrop-filter: blur(2px);
        }

        /* SCROLLBAR */

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }

        /* RESPONSIVE */

        @media (max-width: 1000px) {
            .sidebar {
                width: 250px;
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;
            }

            .main-wrapper {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: inline-flex;
            }

            .topbar {
                padding: 12px 20px;
            }

            .main {
                padding: 22px 20px;
            }
        }

        @media (max-width: 600px) {
            .topbar {
                min-height: 65px;
                padding: 10px 14px;
            }

            .topbar-title {
                font-size: 16px;
            }

            .topbar-subtitle {
                display: none;
            }

            .admin-profile {
                padding: 0;
                border: 0;
                background: transparent;
            }

            .admin-profile-info {
                display: none;
            }

            .admin-avatar {
                width: 36px;
                height: 36px;
            }

            .main {
                padding: 17px 14px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                transition-duration: .01ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>

    @yield('styles')
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="adminSidebar" aria-label="Admin navigation">

        <div class="admin-brand">
            <div class="brand-icon">
                <i class="fa-solid fa-utensils"></i>
            </div>

            <div class="brand-text">
                <h2>Restaurant Admin</h2>
                <span>MANAGEMENT SYSTEM</span>
            </div>
        </div>

        <div class="sidebar-section-title">Main Menu</div>

        <nav class="sidebar-nav">

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-house"></i></span>
                <span>Dashboard</span>
            </a>

            <!-- Menu -->
            <a href="{{ route('admin.menu') }}"
               class="{{ request()->routeIs('admin.menu') || request()->routeIs('admin.menu.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-burger"></i></span>
                <span>Manage Menu</span>
            </a>

            <!-- Add Menu Item -->
            <a href="{{ route('admin.menu.create') }}"
               class="add-menu-link {{ request()->routeIs('admin.menu.create') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-circle-plus"></i></span>
                <span>Add Menu Item</span>
            </a>

            <!-- Orders -->
            <a href="{{ route('admin.orders') }}"
               class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-box-open"></i></span>
                <span>Manage Orders</span>
            </a>

            <!-- Reservations -->
            @if (Route::has('admin.reservations'))
                <a href="{{ route('admin.reservations') }}"
                   class="{{ request()->routeIs('admin.reservations*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-regular fa-calendar-check"></i></span>
                    <span>Reservations</span>
                </a>
            @endif

            <!-- Customer Reviews -->
            @if (Route::has('admin.feedback.index'))
                <a href="{{ route('admin.feedback.index') }}"
                   class="{{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-star"></i></span>
                    <span>Customer Reviews</span>
                </a>
            @endif


            
            <a href="{{ route('admin.staff-requests.index') }}"
            class="{{ request()->routeIs('admin.staff-requests.*') ? 'active' : '' }}">

            <i class="fa-solid fa-users-gear"></i>

            <span>
                 Staff Management
            </span>

            </a>





        </nav>

        <!-- SIDEBAR FOOTER -->
        <div class="sidebar-bottom">

            <div class="admin-divider"></div>

            <div class="sidebar-admin">
                <div class="sidebar-admin-avatar">
                    <i class="fa-solid fa-user-shield"></i>
                </div>

                <div>
                    <div class="sidebar-admin-name">
                        {{ auth()->user()?->name ?? 'Administrator' }}
                    </div>
                    <div class="sidebar-admin-role">System Administrator</div>
                </div>
            </div>

            <form action="{{ route('admin.logout') }}"
                  method="POST"
                  class="logout">
                @csrf

                <button type="submit">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            </form>

        </div>
    </aside>

    <!-- MOBILE OVERLAY -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">

        <!-- TOPBAR -->
        <header class="topbar">

            <div class="topbar-left">

                <button type="button"
                        class="mobile-menu-btn"
                        id="mobileMenuBtn"
                        aria-label="Open admin menu"
                        aria-controls="adminSidebar"
                        aria-expanded="false">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div>
                    <div class="topbar-title">
                        @yield('page-title', 'Admin Dashboard')
                    </div>

                    <div class="topbar-subtitle">
                        Restaurant Management System
                    </div>
                </div>

            </div>

            <div class="topbar-right">
                <div class="admin-profile">

                    <div class="admin-avatar">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <div class="admin-profile-info">
                        <div class="admin-profile-name">
                            {{ auth()->user()?->name ?? 'Administrator' }}
                        </div>

                        <div class="admin-profile-role">
                            <i class="fa-solid fa-circle"
                               style="font-size:7px;color:#22c55e;margin-right:4px;"></i>
                            Administrator
                        </div>
                    </div>

                </div>
            </div>

        </header>

        <!-- PAGE CONTENT -->
        <main class="main">

            @if (session('success'))
                <div class="admin-alert admin-alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="admin-alert admin-alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="admin-alert admin-alert-error">
                    Please check the form for errors.
                </div>
            @endif

            @yield('content')

        </main>
    </div>

    <!-- JAVASCRIPT -->
    <script>
        const sidebar = document.getElementById('adminSidebar');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            sidebar.classList.add('open');
            sidebarOverlay.classList.add('show');
            mobileMenuBtn.setAttribute('aria-expanded', 'true');
            mobileMenuBtn.setAttribute('aria-label', 'Close admin menu');
            mobileMenuBtn.innerHTML = '<i class="fa-solid fa-xmark"></i>';
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            sidebarOverlay.classList.remove('show');
            mobileMenuBtn.setAttribute('aria-expanded', 'false');
            mobileMenuBtn.setAttribute('aria-label', 'Open admin menu');
            mobileMenuBtn.innerHTML = '<i class="fa-solid fa-bars"></i>';
            document.body.style.overflow = '';
        }

        mobileMenuBtn.addEventListener('click', function () {
            sidebar.classList.contains('open')
                ? closeSidebar()
                : openSidebar();
        });

        sidebarOverlay.addEventListener('click', closeSidebar);

        document.querySelectorAll('.sidebar-nav a').forEach(function (link) {
            link.addEventListener('click', closeSidebar);
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') closeSidebar();
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 1000) closeSidebar();
        });
    </script>

    @yield('scripts')

</body>
</html>
