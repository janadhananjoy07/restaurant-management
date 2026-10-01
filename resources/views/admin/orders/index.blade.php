@extends('layouts.admin')

@section('title', 'Manage Orders')
@section('page-title', 'Manage Orders')

@section('styles')

<style>

    .orders-page {
        max-width: 1500px;
        margin: 0 auto;
    }

    /* ---------------------------------------------------------
       HEADER
    --------------------------------------------------------- */

    .orders-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
        margin-bottom: 25px;
    }

    .orders-label {
        color: #f59e0b;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 7px;
    }

    .orders-header h1 {
        margin: 0;
        color: #f5f5f5;
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -.6px;
    }

    .orders-header p {
        margin: 7px 0 0;
        color: #9ca3af;
        font-size: 13px;
    }

    .dashboard-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 8px;
        background: #f59e0b;
        color: #111827;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        transition: .2s ease;
        white-space: nowrap;
    }

    .dashboard-btn:hover {
        background: #fbbf24;
        color: #111827;
        transform: translateY(-1px);
    }


    /* ---------------------------------------------------------
       ALERTS
    --------------------------------------------------------- */

    .alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 13px 15px;
        border-radius: 9px;
        margin-bottom: 20px;
        font-size: 12px;
    }

    .alert-success {
        background: rgba(34, 197, 94, .10);
        border: 1px solid rgba(34, 197, 94, .25);
        color: #86efac;
    }

    .alert-error {
        background: rgba(239, 68, 68, .10);
        border: 1px solid rgba(239, 68, 68, .25);
        color: #fca5a5;
    }

    .alert ul {
        margin: 6px 0 0 18px;
        padding: 0;
    }

    .alert li {
        margin-bottom: 3px;
    }


    /* ---------------------------------------------------------
       SUMMARY
    --------------------------------------------------------- */

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }

    .summary-card {
        background: #191c22;
        border: 1px solid #2a2f38;
        border-radius: 12px;
        padding: 17px;
        transition: .2s ease;
    }

    .summary-card:hover {
        border-color: #3a404b;
        transform: translateY(-1px);
    }

    .summary-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .summary-label {
        color: #9ca3af;
        font-size: 11px;
        font-weight: 600;
    }

    .summary-icon {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: #242830;
        color: #f59e0b;
        font-size: 13px;
    }

    .summary-number {
        color: #f5f5f5;
        font-size: 25px;
        font-weight: 800;
    }


    /* ---------------------------------------------------------
       SEARCH + FILTER PANEL
    --------------------------------------------------------- */

    .filter-panel {
        background: #191c22;
        border: 1px solid #2a2f38;
        border-radius: 13px;
        padding: 18px;
        margin-bottom: 24px;
    }

    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 16px;
    }

    .filter-title {
        display: flex;
        align-items: center;
        gap: 9px;
        color: #f5f5f5;
        font-size: 13px;
        font-weight: 700;
    }

    .filter-title i {
        color: #f59e0b;
    }

    .filter-result {
        color: #9ca3af;
        font-size: 11px;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 12px;
    }

    .filter-field {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .filter-field label {
        color: #9ca3af;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .7px;
    }

    .filter-field input,
    .filter-field select {
        width: 100%;
        box-sizing: border-box;
        padding: 10px 11px;
        background: #20242b;
        border: 1px solid #2a2f38;
        border-radius: 8px;
        color: #e5e7eb;
        outline: none;
        font-size: 11px;
    }

    .filter-field input::placeholder {
        color: #6b7280;
    }

    .filter-field input:focus,
    .filter-field select:focus {
        border-color: #f59e0b;
    }

    .filter-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 9px;
        margin-top: 14px;
    }

    .filter-btn,
    .reset-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 9px 14px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: .2s ease;
    }

    .filter-btn {
        border: 0;
        background: #f59e0b;
        color: #111827;
    }

    .filter-btn:hover {
        background: #fbbf24;
        transform: translateY(-1px);
    }

    .reset-btn {
        background: #20242b;
        border: 1px solid #2a2f38;
        color: #9ca3af;
    }

    .reset-btn:hover {
        color: #f5f5f5;
        border-color: #3a404b;
    }


    /* ---------------------------------------------------------
       FILTER INFO
    --------------------------------------------------------- */

    .active-filter-info {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 1px solid #2a2f38;
    }

    .active-filter-label {
        color: #6b7280;
        font-size: 10px;
    }

    .filter-tag {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 8px;
        border-radius: 6px;
        background: rgba(245, 158, 11, .10);
        color: #fbbf24;
        font-size: 10px;
        font-weight: 600;
    }


    /* ---------------------------------------------------------
       ORDERS
    --------------------------------------------------------- */

    .orders-container {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .order-card {
        background: #191c22;
        border: 1px solid #2a2f38;
        border-radius: 13px;
        overflow: hidden;
        transition: .2s ease;
    }

    .order-card:hover {
        border-color: #3a404b;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 16px 19px;
        background: #1e2229;
        border-bottom: 1px solid #2a2f38;
    }

    .order-heading {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .order-icon {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: rgba(245, 158, 11, .12);
        color: #f59e0b;
    }

    .order-number {
        color: #f5f5f5;
        font-size: 15px;
        font-weight: 700;
    }

    .order-date {
        margin-top: 4px;
        color: #9ca3af;
        font-size: 10px;
    }

    .order-date i {
        margin-right: 4px;
    }


    /* ---------------------------------------------------------
       STATUS
    --------------------------------------------------------- */

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .status-badge i {
        font-size: 7px;
    }

    .status-pending {
        background: rgba(245, 158, 11, .12);
        color: #fbbf24;
    }

    .status-confirmed {
        background: rgba(59, 130, 246, .12);
        color: #60a5fa;
    }

    .status-preparing {
        background: rgba(168, 85, 247, .12);
        color: #c084fc;
    }

    .status-out-for-delivery {
        background: rgba(20, 184, 166, .12);
        color: #2dd4bf;
    }

    .status-completed {
        background: rgba(34, 197, 94, .12);
        color: #4ade80;
    }

    .status-cancelled {
        background: rgba(239, 68, 68, .12);
        color: #f87171;
    }


    /* ---------------------------------------------------------
       BODY
    --------------------------------------------------------- */

    .order-body {
        padding: 19px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
        margin-bottom: 20px;
    }

    .info-box {
        background: #15181d;
        border: 1px solid #2a2f38;
        border-radius: 9px;
        padding: 14px;
    }

    .info-title {
        display: flex;
        align-items: center;
        gap: 7px;
        color: #f59e0b;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .8px;
        margin-bottom: 11px;
    }

    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        margin-bottom: 8px;
        font-size: 11px;
    }

    .info-row:last-child {
        margin-bottom: 0;
    }

    .info-row > i {
        width: 14px;
        color: #6b7280;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .info-row strong {
        color: #e5e7eb;
        font-weight: 600;
    }

    .info-row span {
        color: #9ca3af;
        word-break: break-word;
    }


    /* ---------------------------------------------------------
       ITEMS
    --------------------------------------------------------- */

    .items-title {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 11px;
        color: #f5f5f5;
        font-size: 12px;
        font-weight: 700;
    }

    .items-title i {
        color: #f59e0b;
    }

    .items-list {
        border: 1px solid #2a2f38;
        border-radius: 9px;
        overflow: hidden;
    }

    .item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 12px 14px;
        border-bottom: 1px solid #2a2f38;
    }

    .item-row:last-child {
        border-bottom: 0;
    }

    .item-left {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .item-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #252a32;
        color: #aeb4bf;
        font-size: 11px;
        flex-shrink: 0;
    }

    .item-name {
        color: #e5e7eb;
        font-size: 12px;
        font-weight: 600;
    }

    .item-meta {
        margin-top: 3px;
        color: #9ca3af;
        font-size: 10px;
    }

    .item-total {
        color: #f5f5f5;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }


    /* ---------------------------------------------------------
       FOOTER
    --------------------------------------------------------- */

    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        padding: 16px 19px;
        background: #15181d;
        border-top: 1px solid #2a2f38;
    }

    .total-label {
        color: #9ca3af;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .8px;
    }

    .total {
        margin-top: 3px;
        color: #f59e0b;
        font-size: 22px;
        font-weight: 800;
    }

    .status-form {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .status-form select {
        min-width: 155px;
        padding: 9px 11px;
        background: #20242b;
        border: 1px solid #2a2f38;
        border-radius: 8px;
        color: #e5e7eb;
        outline: none;
        font-size: 11px;
        cursor: pointer;
    }

    .status-form select:focus {
        border-color: #f59e0b;
    }

    .update-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border: 0;
        padding: 9px 13px;
        border-radius: 8px;
        background: #f59e0b;
        color: #111827;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s ease;
    }

    .update-btn:hover {
        background: #fbbf24;
        transform: translateY(-1px);
    }


    /* ---------------------------------------------------------
       PAGINATION
    --------------------------------------------------------- */

    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-top: 24px;
        padding: 15px 17px;
        background: #191c22;
        border: 1px solid #2a2f38;
        border-radius: 11px;
    }

    .pagination-info {
        color: #9ca3af;
        font-size: 11px;
    }

    .pagination-info strong {
        color: #e5e7eb;
    }

    .pagination-links {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .pagination-links a,
    .pagination-links span {
        min-width: 32px;
        height: 32px;
        padding: 0 9px;
        box-sizing: border-box;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 600;
        text-decoration: none;
    }

    .pagination-links a {
        background: #20242b;
        border: 1px solid #2a2f38;
        color: #9ca3af;
        transition: .2s ease;
    }

    .pagination-links a:hover {
        color: #f5f5f5;
        border-color: #f59e0b;
    }

    .pagination-links .active {
        background: #f59e0b;
        border: 1px solid #f59e0b;
        color: #111827;
    }

    .pagination-links .disabled {
        background: #181b20;
        border: 1px solid #252932;
        color: #4b5563;
    }


    /* ---------------------------------------------------------
       EMPTY STATE
    --------------------------------------------------------- */

    .empty-state {
        padding: 70px 25px;
        text-align: center;
        background: #191c22;
        border: 1px solid #2a2f38;
        border-radius: 13px;
    }

    .empty-icon {
        width: 62px;
        height: 62px;
        margin: 0 auto 17px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #20242b;
        color: #6b7280;
        font-size: 23px;
    }

    .empty-state h2 {
        margin: 0 0 7px;
        color: #f5f5f5;
        font-size: 18px;
    }

    .empty-state p {
        margin: 0;
        color: #9ca3af;
        font-size: 12px;
    }


    /* ---------------------------------------------------------
       RESPONSIVE
    --------------------------------------------------------- */

    @media (max-width: 1100px) {

        .filter-grid {
            grid-template-columns: 1fr 1fr;
        }

        .summary-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 800px) {

        .orders-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .pagination-wrapper {
            flex-direction: column;
            align-items: flex-start;
        }

        .pagination-links {
            width: 100%;
            overflow-x: auto;
        }
    }

    @media (max-width: 650px) {

        .filter-grid {
            grid-template-columns: 1fr;
        }

        .filter-actions {
            justify-content: stretch;
            flex-direction: column;
        }

        .filter-btn,
        .reset-btn {
            width: 100%;
        }

        .order-header,
        .order-footer {
            align-items: flex-start;
            flex-direction: column;
        }

        .status-form {
            width: 100%;
            flex-direction: column;
            align-items: stretch;
        }

        .status-form select,
        .update-btn {
            width: 100%;
        }
    }

    @media (max-width: 450px) {

        .summary-grid {
            grid-template-columns: 1fr;
        }

        .order-body,
        .order-footer {
            padding: 15px;
        }

        .order-header {
            padding: 15px;
        }

        .item-row {
            align-items: flex-start;
        }

        .item-total {
            font-size: 11px;
        }
    }

</style>

@endsection


@section('content')

<div class="orders-page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="orders-header">

        <div>

            <div class="orders-label">
                Order Management
            </div>

            <h1>
                Manage Orders
            </h1>

            <p>
                View customer orders, search orders, filter results and update order status.
            </p>

        </div>

        <a
            href="{{ route('admin.dashboard') }}"
            class="dashboard-btn"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Dashboard
        </a>

    </div>


    {{-- =====================================================
         ALERTS
    ====================================================== --}}

    @if (session('success'))

        <div class="alert alert-success">

            <i class="fa-solid fa-circle-check"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    @if (session('error'))

        <div class="alert alert-error">

            <i class="fa-solid fa-circle-exclamation"></i>

            <span>
                {{ session('error') }}
            </span>

        </div>

    @endif


    @if ($errors->any())

        <div class="alert alert-error">

            <i class="fa-solid fa-triangle-exclamation"></i>

            <div>

                <strong>
                    Please check the following:
                </strong>

                <ul>

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

    @endif


    {{-- =====================================================
         SUMMARY
    ====================================================== --}}

    <div class="summary-grid">

        <div class="summary-card">

            <div class="summary-top">

                <div class="summary-label">
                    Total Orders
                </div>

                <div class="summary-icon">
                    <i class="fa-solid fa-receipt"></i>
                </div>

            </div>

            <div class="summary-number">
                {{ $totalOrders }}
            </div>

        </div>


        <div class="summary-card">

            <div class="summary-top">

                <div class="summary-label">
                    Pending
                </div>

                <div class="summary-icon">
                    <i class="fa-solid fa-clock"></i>
                </div>

            </div>

            <div class="summary-number">
                {{ $pendingCount }}
            </div>

        </div>


        <div class="summary-card">

            <div class="summary-top">

                <div class="summary-label">
                    Confirmed
                </div>

                <div class="summary-icon">
                    <i class="fa-solid fa-check"></i>
                </div>

            </div>

            <div class="summary-number">
                {{ $confirmedCount }}
            </div>

        </div>


        <div class="summary-card">

            <div class="summary-top">

                <div class="summary-label">
                    Preparing
                </div>

                <div class="summary-icon">
                    <i class="fa-solid fa-fire-burner"></i>
                </div>

            </div>

            <div class="summary-number">
                {{ $preparingCount }}
            </div>

        </div>


        <div class="summary-card">

            <div class="summary-top">

                <div class="summary-label">
                    Out for Delivery
                </div>

                <div class="summary-icon">
                    <i class="fa-solid fa-motorcycle"></i>
                </div>

            </div>

            <div class="summary-number">
                {{ $outForDeliveryCount }}
            </div>

        </div>


        <div class="summary-card">

            <div class="summary-top">

                <div class="summary-label">
                    Completed
                </div>

                <div class="summary-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>

            </div>

            <div class="summary-number">
                {{ $completedCount }}
            </div>

        </div>


        <div class="summary-card">

            <div class="summary-top">

                <div class="summary-label">
                    Cancelled
                </div>

                <div class="summary-icon">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>

            </div>

            <div class="summary-number">
                {{ $cancelledCount }}
            </div>

        </div>

    </div>


    {{-- =====================================================
         SEARCH + FILTER
    ====================================================== --}}

    <div class="filter-panel">

        <div class="filter-header">

            <div class="filter-title">

                <i class="fa-solid fa-sliders"></i>

                Search & Filter Orders

            </div>

            <div class="filter-result">

                {{ number_format($filteredOrdersCount) }}
                {{ $filteredOrdersCount === 1 ? 'order' : 'orders' }}
                found

            </div>

        </div>


        <form
            action="{{ route('admin.orders') }}"
            method="GET"
        >

            <div class="filter-grid">

                {{-- SEARCH --}}

                <div class="filter-field">

                    <label for="search">
                        Search
                    </label>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Order ID, customer name, email or phone..."
                        autocomplete="off"
                    >

                </div>


                {{-- STATUS --}}

                <div class="filter-field">

                    <label for="status">
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                    >

                        <option value="">
                            All Statuses
                        </option>

                        <option
                            value="pending"
                            {{ $status === 'pending' ? 'selected' : '' }}
                        >
                            Pending
                        </option>

                        <option
                            value="confirmed"
                            {{ $status === 'confirmed' ? 'selected' : '' }}
                        >
                            Confirmed
                        </option>

                        <option
                            value="preparing"
                            {{ $status === 'preparing' ? 'selected' : '' }}
                        >
                            Preparing
                        </option>

                        <option
                            value="out_for_delivery"
                            {{ $status === 'out_for_delivery' ? 'selected' : '' }}
                        >
                            Out for Delivery
                        </option>

                        <option
                            value="completed"
                            {{ $status === 'completed' ? 'selected' : '' }}
                        >
                            Completed
                        </option>

                        <option
                            value="cancelled"
                            {{ $status === 'cancelled' ? 'selected' : '' }}
                        >
                            Cancelled
                        </option>

                    </select>

                </div>


                {{-- DATE FROM --}}

                <div class="filter-field">

                    <label for="date_from">
                        From Date
                    </label>

                    <input
                        type="date"
                        id="date_from"
                        name="date_from"
                        value="{{ $dateFrom }}"
                    >

                </div>


                {{-- DATE TO --}}

                <div class="filter-field">

                    <label for="date_to">
                        To Date
                    </label>

                    <input
                        type="date"
                        id="date_to"
                        name="date_to"
                        value="{{ $dateTo }}"
                    >

                </div>


                {{-- SORT --}}

                <div class="filter-field">

                    <label for="sort">
                        Sort By
                    </label>

                    <select
                        id="sort"
                        name="sort"
                    >

                        <option
                            value="latest"
                            {{ $sort === 'latest' ? 'selected' : '' }}
                        >
                            Newest First
                        </option>

                        <option
                            value="oldest"
                            {{ $sort === 'oldest' ? 'selected' : '' }}
                        >
                            Oldest First
                        </option>

                        <option
                            value="amount_high"
                            {{ $sort === 'amount_high' ? 'selected' : '' }}
                        >
                            Highest Amount
                        </option>

                        <option
                            value="amount_low"
                            {{ $sort === 'amount_low' ? 'selected' : '' }}
                        >
                            Lowest Amount
                        </option>

                    </select>

                </div>

            </div>


            {{-- ACTIONS --}}

            <div class="filter-actions">

                <a
                    href="{{ route('admin.orders') }}"
                    class="reset-btn"
                >
                    <i class="fa-solid fa-rotate-left"></i>
                    Reset
                </a>

                <button
                    type="submit"
                    class="filter-btn"
                >
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Apply Filters
                </button>

            </div>

        </form>


        {{-- ACTIVE FILTERS --}}

        @if (
            $search !== '' ||
            $status !== '' ||
            $dateFrom !== '' ||
            $dateTo !== '' ||
            $sort !== 'latest'
        )

            <div class="active-filter-info">

                <span class="active-filter-label">
                    Active filters:
                </span>


                @if ($search !== '')

                    <span class="filter-tag">

                        <i class="fa-solid fa-magnifying-glass"></i>

                        Search: {{ $search }}

                    </span>

                @endif


                @if ($status !== '')

                    <span class="filter-tag">

                        <i class="fa-solid fa-filter"></i>

                        Status:
                        {{ ucwords(str_replace('_', ' ', $status)) }}

                    </span>

                @endif


                @if ($dateFrom !== '')

                    <span class="filter-tag">

                        <i class="fa-regular fa-calendar"></i>

                        From: {{ $dateFrom }}

                    </span>

                @endif


                @if ($dateTo !== '')

                    <span class="filter-tag">

                        <i class="fa-regular fa-calendar"></i>

                        To: {{ $dateTo }}

                    </span>

                @endif


                @if ($sort !== 'latest')

                    <span class="filter-tag">

                        <i class="fa-solid fa-arrow-down-wide-short"></i>

                        Sort:
                        {{ ucwords(str_replace('_', ' ', $sort)) }}

                    </span>

                @endif

            </div>

        @endif

    </div>


    {{-- =====================================================
         ORDERS
    ====================================================== --}}

    @if ($orders->isEmpty())

        <div class="empty-state">

            <div class="empty-icon">
                <i class="fa-solid fa-receipt"></i>
            </div>

            <h2>
                No Orders Found
            </h2>

            <p>
                No orders match your current search or filter criteria.
            </p>

            <div style="margin-top:18px;">

                <a
                    href="{{ route('admin.orders') }}"
                    class="reset-btn"
                >
                    <i class="fa-solid fa-rotate-left"></i>
                    Clear Filters
                </a>

            </div>

        </div>

    @else

        <div class="orders-container">

            @foreach ($orders as $order)

                @php

                    $statusClass = match ($order->status) {

                        'pending'
                            => 'status-pending',

                        'confirmed'
                            => 'status-confirmed',

                        'preparing'
                            => 'status-preparing',

                        'out_for_delivery'
                            => 'status-out-for-delivery',

                        'completed'
                            => 'status-completed',

                        'cancelled'
                            => 'status-cancelled',

                        default
                            => 'status-pending',
                    };

                    $displayStatus = ucwords(
                        str_replace(
                            '_',
                            ' ',
                            $order->status
                        )
                    );

                @endphp


                <div class="order-card">

                    {{-- ORDER HEADER --}}

                    <div class="order-header">

                        <div class="order-heading">

                            <div class="order-icon">

                                <i class="fa-solid fa-receipt"></i>

                            </div>


                            <div>

                                <div class="order-number">

                                    Order #{{ $order->id }}

                                </div>


                                <div class="order-date">

                                    <i class="fa-regular fa-calendar"></i>

                                    {{ $order->created_at
                                        ? $order->created_at->format('d M Y, h:i A')
                                        : 'Date unavailable'
                                    }}

                                </div>

                            </div>

                        </div>


                        <div class="status-badge {{ $statusClass }}">

                            <i class="fa-solid fa-circle"></i>

                            {{ $displayStatus }}

                        </div>

                    </div>


                    {{-- ORDER BODY --}}

                    <div class="order-body">

                        {{-- CUSTOMER INFORMATION --}}

                        <div class="info-grid">

                            <div class="info-box">

                                <div class="info-title">

                                    <i class="fa-solid fa-user"></i>

                                    Customer Information

                                </div>


                                <div class="info-row">

                                    <i class="fa-solid fa-user"></i>

                                    <strong>
                                        Name:
                                    </strong>

                                    <span>
                                        {{ $order->user->name ?? 'Unknown Customer' }}
                                    </span>

                                </div>


                                <div class="info-row">

                                    <i class="fa-solid fa-envelope"></i>

                                    <strong>
                                        Email:
                                    </strong>

                                    <span>
                                        {{ $order->user->email ?? 'Not available' }}
                                    </span>

                                </div>


                                <div class="info-row">

                                    <i class="fa-solid fa-phone"></i>

                                    <strong>
                                        Phone:
                                    </strong>

                                    <span>
                                        {{ $order->phone ?? 'Not available' }}
                                    </span>

                                </div>

                            </div>


                            {{-- DELIVERY --}}

                            <div class="info-box">

                                <div class="info-title">

                                    <i class="fa-solid fa-location-dot"></i>

                                    Delivery Information

                                </div>


                                <div class="info-row">

                                    <i class="fa-solid fa-location-dot"></i>

                                    <strong>
                                        Address:
                                    </strong>

                                    <span>
                                        {{ $order->address ?? 'Not available' }}
                                    </span>

                                </div>

                            </div>

                        </div>


                        {{-- ORDERED ITEMS --}}

                        <div class="items-title">

                            <i class="fa-solid fa-bowl-food"></i>

                            Ordered Items

                        </div>


                        <div class="items-list">

                            @forelse ($order->items as $item)

                                <div class="item-row">

                                    <div class="item-left">

                                        <div class="item-icon">

                                            <i class="fa-solid fa-utensils"></i>

                                        </div>


                                        <div>

                                            <div class="item-name">

                                                {{ $item->menuItem->name ?? 'Menu Item' }}

                                            </div>


                                            <div class="item-meta">

                                                ₹{{ number_format(
                                                    (float) $item->price,
                                                    2
                                                ) }}

                                                ×

                                                {{ $item->quantity }}

                                            </div>

                                        </div>

                                    </div>


                                    <div class="item-total">

                                        ₹{{ number_format(
                                            (float) $item->price *
                                            (int) $item->quantity,
                                            2
                                        ) }}

                                    </div>

                                </div>

                            @empty

                                <div class="item-row">

                                    <div class="item-meta">

                                        No items found for this order.

                                    </div>

                                </div>

                            @endforelse

                        </div>

                    </div>


                    {{-- ORDER FOOTER --}}

                    <div class="order-footer">

                        <div>

                            <div class="total-label">
                                Order Total
                            </div>

                            <div class="total">

                                ₹{{ number_format(
                                    (float) $order->total_amount,
                                    2
                                ) }}

                            </div>

                        </div>


                        {{-- STATUS UPDATE --}}

                        <form
                            action="{{ route('admin.orders.status', $order->id) }}"
                            method="POST"
                            class="status-form"
                        >

                            @csrf

                            @method('PUT')


                            <select
                                name="status"
                                aria-label="Order status"
                            >

                                <option
                                    value="pending"
                                    {{ $order->status === 'pending' ? 'selected' : '' }}
                                >
                                    Pending
                                </option>

                                <option
                                    value="confirmed"
                                    {{ $order->status === 'confirmed' ? 'selected' : '' }}
                                >
                                    Confirmed
                                </option>

                                <option
                                    value="preparing"
                                    {{ $order->status === 'preparing' ? 'selected' : '' }}
                                >
                                    Preparing
                                </option>

                                <option
                                    value="out_for_delivery"
                                    {{ $order->status === 'out_for_delivery' ? 'selected' : '' }}
                                >
                                    Out for Delivery
                                </option>

                                <option
                                    value="completed"
                                    {{ $order->status === 'completed' ? 'selected' : '' }}
                                >
                                    Completed
                                </option>

                                <option
                                    value="cancelled"
                                    {{ $order->status === 'cancelled' ? 'selected' : '' }}
                                >
                                    Cancelled
                                </option>

                            </select>


                            <button
                                type="submit"
                                class="update-btn"
                            >

                                <i class="fa-solid fa-arrows-rotate"></i>

                                Update Status

                            </button>

                        </form>

                    </div>

                </div>

            @endforeach

        </div>


        {{-- =================================================
             PAGINATION
        ================================================== --}}

        @if ($orders->hasPages())

            <div class="pagination-wrapper">

                <div class="pagination-info">

                    Showing

                    <strong>
                        {{ $orders->firstItem() }}
                    </strong>

                    to

                    <strong>
                        {{ $orders->lastItem() }}
                    </strong>

                    of

                    <strong>
                        {{ $orders->total() }}
                    </strong>

                    orders

                </div>


                <div class="pagination-links">

                    {{-- PREVIOUS --}}

                    @if ($orders->onFirstPage())

                        <span class="disabled">
                            <i class="fa-solid fa-chevron-left"></i>
                        </span>

                    @else

                        <a href="{{ $orders->previousPageUrl() }}">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>

                    @endif


                    {{-- PAGE NUMBERS --}}

                    @foreach ($orders->getUrlRange(
                        max(1, $orders->currentPage() - 2),
                        min(
                            $orders->lastPage(),
                            $orders->currentPage() + 2
                        )
                    ) as $page => $url)

                        @if ($page == $orders->currentPage())

                            <span class="active">
                                {{ $page }}
                            </span>

                        @else

                            <a href="{{ $url }}">
                                {{ $page }}
                            </a>

                        @endif

                    @endforeach


                    {{-- NEXT --}}

                    @if ($orders->hasMorePages())

                        <a href="{{ $orders->nextPageUrl() }}">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>

                    @else

                        <span class="disabled">
                            <i class="fa-solid fa-chevron-right"></i>
                        </span>

                    @endif

                </div>

            </div>

        @endif

    @endif

</div>

@endsection

