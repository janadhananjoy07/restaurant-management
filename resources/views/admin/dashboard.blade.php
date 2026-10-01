
@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('styles')
<style>
    :root {
        --admin-bg: #171412;
        --admin-card: #1c1917;
        --admin-card-light: #292524;
        --admin-border: #34302c;
        --admin-gold: #f59e0b;
        --admin-gold-light: #fbbf24;
        --admin-text: #fafaf9;
        --admin-muted: #a8a29e;
    }

    .dashboard-header {
        padding: 28px;
        margin-bottom: 26px;
        border: 1px solid rgba(245,158,11,.16);
        border-radius: 18px;
        background:
            radial-gradient(ellipse at top right, rgba(245,158,11,.10), transparent 48%),
            linear-gradient(135deg, #1c1917, #171412);
    }

    .dashboard-header h1 {
        color: var(--admin-text);
        font-size: clamp(24px, 3vw, 32px);
        font-weight: 800;
        letter-spacing: -1px;
        line-height: 1.2;
        margin-bottom: 8px;
    }

    .dashboard-header p {
        color: var(--admin-muted);
        font-size: 14px;
        line-height: 1.7;
        margin-bottom: 0;
    }

    .dashboard-header p strong {
        color: var(--admin-text);
    }

    .system-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 12px;
        margin-bottom: 14px;
        border: 1px solid rgba(34,197,94,.18);
        border-radius: 999px;
        background: rgba(34,197,94,.08);
        color: #86efac;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .8px;
        text-transform: uppercase;
    }

    .system-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #22c55e;
        box-shadow: 0 0 10px rgba(34,197,94,.6);
    }

    .dashboard-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 22px;
    }

    .dashboard-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 42px;
        padding: 11px 16px;
        border: 1px solid transparent;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s ease;
    }

    .dashboard-btn-primary {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: #1c1917;
        box-shadow: 0 5px 15px rgba(245,158,11,.12);
    }

    .dashboard-btn-primary:hover {
        color: #1c1917;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(245,158,11,.2);
    }

    .dashboard-btn-secondary {
        color: #e7e5e4;
        background: rgba(255,255,255,.035);
        border-color: #44403c;
    }

    .dashboard-btn-secondary:hover {
        color: #fff;
        border-color: #78716c;
        background: rgba(255,255,255,.07);
    }

    /* Statistics */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        position: relative;
        overflow: hidden;
        padding: 23px;
        border: 1px solid var(--admin-border);
        border-radius: 17px;
        background: linear-gradient(145deg, #211e1b, #191613);
        box-shadow: 0 5px 18px rgba(0,0,0,.10);
        transition: .25s ease;
    }

    .stat-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        opacity: .85;
        background: linear-gradient(90deg, #f59e0b, #fbbf24, transparent);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        border-color: rgba(245,158,11,.42);
        box-shadow: 0 14px 30px rgba(0,0,0,.20);
    }

    .stat-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
    }

    .stat-label {
        color: var(--admin-muted);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1.1px;
        text-transform: uppercase;
    }

    .stat-value {
        display: block;
        margin-top: 8px;
        color: var(--admin-text);
        font-size: clamp(24px, 2.3vw, 30px);
        font-weight: 900;
        letter-spacing: -.7px;
        line-height: 1.2;
        overflow-wrap: anywhere;
    }

    .stat-description {
        margin-top: 9px;
        color: var(--admin-muted);
        font-size: 11px;
        line-height: 1.5;
    }

    .stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 48px;
        height: 48px;
        border: 1px solid rgba(245,158,11,.12);
        border-radius: 14px;
        background: rgba(245,158,11,.09);
        color: var(--admin-gold-light);
        font-size: 18px;
    }

    .green { color: #34d399 !important; }
    .blue { color: #60a5fa !important; }
    .purple { color: #c084fc !important; }
    .yellow { color: #fbbf24 !important; }
    .orange { color: #fb923c !important; }

    /* Panels */

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 24px;
    }

    .panel {
        overflow: hidden;
        margin-bottom: 22px;
        border: 1px solid var(--admin-border);
        border-radius: 17px;
        background: var(--admin-card);
        box-shadow: 0 5px 20px rgba(0,0,0,.08);
    }

    .dashboard-grid .panel {
        margin-bottom: 0;
    }

    .panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 21px 23px;
        border-bottom: 1px solid var(--admin-border);
        background: rgba(255,255,255,.015);
    }

    .panel-title {
        color: var(--admin-text);
        font-size: 16px;
        font-weight: 800;
        letter-spacing: -.2px;
    }

    .panel-subtitle {
        margin-top: 4px;
        color: var(--admin-muted);
        font-size: 12px;
        line-height: 1.5;
    }

    .view-all {
        padding: 7px 10px;
        border-radius: 8px;
        background: rgba(245,158,11,.07);
        color: var(--admin-gold-light);
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        transition: .2s ease;
    }

    .view-all:hover {
        background: rgba(245,158,11,.13);
        color: #fde68a;
    }

    /* Order status */

    .status-content {
        padding: 24px;
    }

    .status-item {
        margin-bottom: 21px;
    }

    .status-item:last-child {
        margin-bottom: 0;
    }

    .status-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 8px;
    }

    .status-name {
        color: #d6d3d1;
        font-size: 13px;
        font-weight: 500;
    }

    .status-number {
        font-size: 14px;
        font-weight: 800;
    }

    .progress {
        width: 100%;
        height: 8px;
        overflow: hidden;
        border-radius: 99px;
        background: #34302c;
    }

    .progress-bar {
        height: 100%;
        min-width: 0;
        border-radius: 99px;
        transition: width .5s ease;
    }

    .progress-yellow { background: #f59e0b; }
    .progress-blue { background: #3b82f6; }
    .progress-purple { background: #a855f7; }
    .progress-orange { background: #f97316; }
    .progress-green { background: #10b981; }
    .progress-red { background: #ef4444; }

    /* Reservation status */

    .reservation-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        padding: 23px;
    }

    .reservation-box {
        padding: 18px;
        border: 1px solid #3f3a37;
        border-radius: 14px;
        background: linear-gradient(145deg, #292524, #211e1b);
        transition: .2s ease;
    }

    .reservation-box:hover {
        transform: translateY(-2px);
        border-color: rgba(245,158,11,.28);
    }

    .reservation-label {
        margin-bottom: 8px;
        color: var(--admin-muted);
        font-size: 11px;
        font-weight: 600;
    }

    .reservation-value {
        color: var(--admin-text);
        font-size: 27px;
        font-weight: 900;
        letter-spacing: -.5px;
    }

    /* Quick actions */

    .quick-actions-panel {
        margin-bottom: 22px;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        padding: 23px;
    }

    .quick-action {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        width: 100%;
        min-width: 0;
        min-height: 112px;
        gap: 2px;
        padding: 15px;
        border: 1px solid #3f3a37;
        border-radius: 14px;
        background: #25211e;
        color: #d6d3d1;
        text-align: center;
        text-decoration: none;
        transition: .2s ease;
    }

    .quick-action:hover {
        transform: translateY(-2px);
        border-color: rgba(245,158,11,.38);
        background: #2d2824;
        color: #fff;
        box-shadow: 0 8px 18px rgba(0,0,0,.12);
    }

    .quick-action i {
        display: grid;
        place-items: center;
        width: 43px;
        height: 43px;
        margin-bottom: 10px;
        border-radius: 12px;
        background: rgba(245,158,11,.09);
        color: var(--admin-gold-light);
        font-size: 20px;
    }

    .quick-action span {
        font-size: 12px;
        font-weight: 700;
        line-height: 1.4;
    }

    /* Tables */

    .table-wrapper {
        overflow-x: auto;
        scrollbar-width: thin;
        scrollbar-color: #57534e #1c1917;
    }

    .admin-table {
        width: 100%;
        min-width: 720px;
        border-collapse: collapse;
    }

    .admin-table th {
        padding: 15px 20px;
        background: #211e1b;
        color: var(--admin-muted);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .8px;
        text-align: left;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .admin-table td {
        padding: 17px 20px;
        border-top: 1px solid #302b27;
        color: #d6d3d1;
        font-size: 12px;
        vertical-align: middle;
    }

    .admin-table tbody tr {
        transition: .2s ease;
    }

    .admin-table tbody tr:hover {
        background: rgba(255,255,255,.025);
    }

    .order-id {
        color: var(--admin-gold-light);
        font-weight: 800;
        white-space: nowrap;
    }

    .customer {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .customer-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 34px;
        height: 34px;
        border: 1px solid #44403c;
        border-radius: 50%;
        background: #302b27;
        color: var(--admin-gold-light);
    }

    .customer-name {
        color: #f5f5f4;
        font-size: 12px;
        font-weight: 700;
    }

    .customer-email {
        margin-top: 2px;
        color: var(--admin-muted);
        font-size: 10px;
    }

    .amount {
        color: #f5f5f4;
        font-weight: 800;
        white-space: nowrap;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 11px;
        border: 1px solid transparent;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .2px;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .status-pending {
        color: #fbbf24;
        background: rgba(245,158,11,.10);
        border-color: rgba(245,158,11,.20);
    }

    .status-confirmed {
        color: #60a5fa;
        background: rgba(59,130,246,.10);
        border-color: rgba(59,130,246,.20);
    }

    .status-preparing {
        color: #c084fc;
        background: rgba(168,85,247,.10);
        border-color: rgba(168,85,247,.20);
    }

    .status-out_for_delivery {
        color: #fb923c;
        background: rgba(249,115,22,.10);
        border-color: rgba(249,115,22,.20);
    }

    .status-completed {
        color: #34d399;
        background: rgba(16,185,129,.10);
        border-color: rgba(16,185,129,.20);
    }

    .status-cancelled {
        color: #f87171;
        background: rgba(239,68,68,.10);
        border-color: rgba(239,68,68,.20);
    }

    .empty-state {
        padding: 42px 20px;
        color: #78716c;
        text-align: center;
    }

    .empty-state i {
        display: block;
        margin-bottom: 12px;
        color: #78716c;
        font-size: 30px;
    }

    .empty-state strong {
        display: block;
        margin-bottom: 4px;
        color: #e7e5e4;
        font-size: 13px;
    }

    .empty-state span {
        font-size: 11px;
    }

    /* Responsive */

    @media (max-width: 1100px) {
        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .quick-actions {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 800px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .dashboard-header {
            padding: 19px;
            border-radius: 14px;
        }

        .dashboard-actions {
            display: grid;
            grid-template-columns: 1fr;
        }

        .dashboard-btn {
            width: 100%;
            box-sizing: border-box;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .stat-card {
            padding: 19px;
        }

        .panel {
            border-radius: 14px;
        }

        .panel-header {
            padding: 17px;
        }

        .status-content {
            padding: 18px;
        }

        .reservation-grid {
            gap: 10px;
            padding: 16px;
        }

        .reservation-box {
            padding: 14px;
        }

        .quick-actions {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            padding: 16px;
        }

        .quick-action {
            min-height: 105px;
            padding: 12px;
        }
    }

    @media (max-width: 400px) {
        .reservation-grid,
        .quick-actions {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')

{{-- DASHBOARD HEADER --}}
<section class="dashboard-header">

    <div class="system-status">
        <span class="system-dot"></span>
        System Online
    </div>

    <h1>Administration Dashboard</h1>

    <p>
        Welcome back,
        <strong>{{ Auth::user()->name ?? 'Administrator' }}</strong>.
        Manage your restaurant operations from one place.
    </p>

    <div class="dashboard-actions">
        <a href="{{ route('admin.menu.create') }}"
           class="dashboard-btn dashboard-btn-primary">
            <i class="fa-solid fa-plus"></i>
            Add Menu Item
        </a>

        <a href="{{ route('admin.orders') }}"
           class="dashboard-btn dashboard-btn-secondary">
            <i class="fa-solid fa-receipt"></i>
            Manage Orders
        </a>

        <a href="{{ route('admin.reservations') }}"
           class="dashboard-btn dashboard-btn-secondary">
            <i class="fa-solid fa-calendar-check"></i>
            Reservations
        </a>
    </div>
</section>


{{-- STATISTICS --}}
<section class="stats-grid">

    <div class="stat-card">
        <div class="stat-top">
            <div>
                <span class="stat-label">Total Orders</span>
                <strong class="stat-value">
                    {{ number_format($totalOrders ?? 0) }}
                </strong>
                <div class="stat-description yellow">
                    <i class="fa-solid fa-clock"></i>
                    {{ number_format($pendingOrders ?? 0) }} pending
                </div>
            </div>

            <div class="stat-icon">
                <i class="fa-solid fa-receipt"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div>
                <span class="stat-label">Total Revenue</span>
                <strong class="stat-value">
                    ₹{{ number_format((float) ($totalRevenue ?? 0), 2) }}
                </strong>
                <div class="stat-description green">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                    Completed orders
                </div>
            </div>

            <div class="stat-icon">
                <i class="fa-solid fa-indian-rupee-sign"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div>
                <span class="stat-label">Customers</span>
                <strong class="stat-value">
                    {{ number_format($totalUsers ?? 0) }}
                </strong>
                <div class="stat-description blue">
                    <i class="fa-solid fa-users"></i>
                    Registered users
                </div>
            </div>

            <div class="stat-icon">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div>
                <span class="stat-label">Reservations</span>
                <strong class="stat-value">
                    {{ number_format($totalReservations ?? 0) }}
                </strong>
                <div class="stat-description purple">
                    <i class="fa-solid fa-calendar-check"></i>
                    {{ number_format($pendingReservations ?? 0) }} pending
                </div>
            </div>

            <div class="stat-icon">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
        </div>
    </div>

</section>


{{-- ORDER AND RESERVATION OVERVIEW --}}
<section class="dashboard-grid">

    {{-- ORDER OVERVIEW --}}
    <div class="panel">
        <div class="panel-header">
            <div>
                <div class="panel-title">Order Overview</div>
                <div class="panel-subtitle">
                    Current order status
                </div>
            </div>

            <a href="{{ route('admin.orders') }}" class="view-all">
                View All →
            </a>
        </div>

        <div class="status-content">

            @php
                $orderTotal = max((int) ($totalOrders ?? 0), 1);

                $orderStatuses = [
                    [
                        'name' => 'Pending',
                        'count' => $pendingOrders ?? 0,
                        'color' => 'yellow',
                        'bar' => 'progress-yellow',
                    ],
                    [
                        'name' => 'Confirmed',
                        'count' => $confirmedOrders ?? 0,
                        'color' => 'blue',
                        'bar' => 'progress-blue',
                    ],
                    [
                        'name' => 'Preparing',
                        'count' => $preparingOrders ?? 0,
                        'color' => 'purple',
                        'bar' => 'progress-purple',
                    ],
                    [
                        'name' => 'Out for Delivery',
                        'count' => $outForDeliveryOrders ?? 0,
                        'color' => 'orange',
                        'bar' => 'progress-orange',
                    ],
                    [
                        'name' => 'Completed',
                        'count' => $completedOrders ?? 0,
                        'color' => 'green',
                        'bar' => 'progress-green',
                    ],
                    [
                        'name' => 'Cancelled',
                        'count' => $cancelledOrders ?? 0,
                        'color' => '',
                        'bar' => 'progress-red',
                    ],
                ];
            @endphp

            @foreach ($orderStatuses as $status)
                @php
                    $percentage = min(
                        100,
                        ((int) $status['count'] / $orderTotal) * 100
                    );
                @endphp

                <div class="status-item">
                    <div class="status-heading">
                        <span class="status-name">
                            {{ $status['name'] }}
                        </span>

                        <strong class="status-number {{ $status['color'] }}"
                            @if ($status['name'] === 'Cancelled')
                                style="color:#f87171;"
                            @endif>
                            {{ number_format((int) $status['count']) }}
                        </strong>
                    </div>

                    <div class="progress">
                        <div class="progress-bar {{ $status['bar'] }}"
                             style="width: {{ $percentage }}%;">
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>


    {{-- RESERVATION OVERVIEW --}}
    <div class="panel">
        <div class="panel-header">
            <div>
                <div class="panel-title">Reservation Overview</div>
                <div class="panel-subtitle">
                    Current table reservation status
                </div>
            </div>

            <a href="{{ route('admin.reservations') }}" class="view-all">
                View All →
            </a>
        </div>

        <div class="reservation-grid">

            <div class="reservation-box">
                <div class="reservation-label yellow">
                    <i class="fa-solid fa-clock"></i> Pending
                </div>
                <div class="reservation-value">
                    {{ number_format($pendingReservations ?? 0) }}
                </div>
            </div>

            <div class="reservation-box">
                <div class="reservation-label blue">
                    <i class="fa-solid fa-circle-check"></i> Confirmed
                </div>
                <div class="reservation-value">
                    {{ number_format($confirmedReservations ?? 0) }}
                </div>
            </div>

            <div class="reservation-box">
                <div class="reservation-label green">
                    <i class="fa-solid fa-check-double"></i> Completed
                </div>
                <div class="reservation-value">
                    {{ number_format($completedReservations ?? 0) }}
                </div>
            </div>

            <div class="reservation-box">
                <div class="reservation-label" style="color:#f87171;">
                    <i class="fa-solid fa-ban"></i> Cancelled
                </div>
                <div class="reservation-value">
                    {{ number_format($cancelledReservations ?? 0) }}
                </div>
            </div>

        </div>
    </div>

</section>


{{-- QUICK ACTIONS --}}
<section class="panel quick-actions-panel">

    <div class="panel-header">
        <div>
            <div class="panel-title">Quick Actions</div>
            <div class="panel-subtitle">
                Quickly access important administration tools.
            </div>
        </div>
    </div>

    <div class="quick-actions">

        <a href="{{ route('admin.orders') }}" class="quick-action">
            <i class="fa-solid fa-receipt"></i>
            <span>Manage Orders</span>
        </a>

        @if (Route::has('admin.reservations'))
            <a href="{{ route('admin.reservations') }}" class="quick-action">
                <i class="fa-solid fa-calendar-check"></i>
                <span>Reservations</span>
            </a>
        @endif

        <a href="{{ route('admin.menu') }}" class="quick-action">
            <i class="fa-solid fa-utensils"></i>
            <span>Manage Menu</span>
        </a>

        <a href="{{ route('admin.menu.create') }}" class="quick-action">
            <i class="fa-solid fa-plus"></i>
            <span>Add Menu Item</span>
        </a>

    </div>
</section>


{{-- RECENT ORDERS --}}
<section class="panel">

    <div class="panel-header">
        <div>
            <div class="panel-title">Recent Orders</div>
            <div class="panel-subtitle">
                Latest restaurant orders
            </div>
        </div>

        <a href="{{ route('admin.orders') }}" class="view-all">
            View All →
        </a>
    </div>

    <div class="table-wrapper">
        <table class="admin-table">

            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                @forelse (($recentOrders ?? collect()) as $order)
                    <tr>
                        <td>
                            <span class="order-id">#{{ $order->id }}</span>
                        </td>

                        <td>
                            <div class="customer">
                                <div class="customer-avatar">
                                    <i class="fa-solid fa-user"></i>
                                </div>

                                <div>
                                    <div class="customer-name">
                                        {{ $order->user->name ?? 'Unknown Customer' }}
                                    </div>

                                    <div class="customer-email">
                                        {{ $order->user->email ?? '' }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="amount">
                                ₹{{ number_format((float) ($order->total_amount ?? 0), 2) }}
                            </span>
                        </td>

                        <td>
                            @php
                                $orderStatus = strtolower(
                                    str_replace(' ', '_', $order->status ?? 'pending')
                                );
                            @endphp

                            <span class="status-badge status-{{ $orderStatus }}">
                                {{ str_replace('_', ' ', $order->status ?? 'Pending') }}
                            </span>
                        </td>

                        <td>
                            {{ $order->created_at
                                ? $order->created_at->format('d M Y')
                                : '—'
                            }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="fa-solid fa-receipt"></i>
                                <strong>No orders found</strong>
                                <span>
                                    New customer orders will appear here.
                                </span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</section>


{{-- RECENT RESERVATIONS --}}
<section class="panel">

    <div class="panel-header">
        <div>
            <div class="panel-title">Recent Reservations</div>
            <div class="panel-subtitle">
                Latest table bookings
            </div>
        </div>

        <a href="{{ route('admin.reservations') }}" class="view-all">
            View All →
        </a>
    </div>

    <div class="table-wrapper">
        <table class="admin-table">

            <thead>
                <tr>
                    <th>Reservation</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Guests</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse (($recentReservations ?? collect()) as $reservation)
                    <tr>
                        <td>
                            <span class="order-id">
                                #{{ $reservation->id }}
                            </span>
                        </td>

                        <td>
                            <div class="customer">
                                <div class="customer-avatar">
                                    <i class="fa-solid fa-user"></i>
                                </div>

                                <div class="customer-name">
                                    {{ $reservation->user->name ?? 'Unknown Customer' }}
                                </div>
                            </div>
                        </td>

                        <td>
                            {{ $reservation->date
                                ? \Carbon\Carbon::parse($reservation->date)->format('d M Y')
                                : '—'
                            }}
                        </td>

                        <td>{{ $reservation->time ?? '—' }}</td>

                        <td>
                            <i class="fa-solid fa-users"></i>
                            {{ $reservation->guests ?? '—' }}
                        </td>

                        <td>
                            @php
                                $reservationStatus = strtolower(
                                    str_replace(' ', '_', $reservation->status ?? 'pending')
                                );
                            @endphp

                            <span class="status-badge status-{{ $reservationStatus }}">
                                {{ str_replace('_', ' ', $reservation->status ?? 'Pending') }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fa-solid fa-calendar-xmark"></i>
                                <strong>No reservations found</strong>
                                <span>
                                    New table reservations will appear here.
                                </span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</section>

@endsection
