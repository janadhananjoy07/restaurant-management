@extends('layouts.admin')

@section('title', 'Reservations')
@section('page-title', 'Reservations')

@section('styles')

<style>
    /* =========================================================
       RESERVATIONS PAGE
    ========================================================= */

    .reservation-page {
        animation: pageFadeIn .35s ease;
    }

    @keyframes pageFadeIn {
        from {
            opacity: 0;
            transform: translateY(8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* =========================================================
       HEADER
    ========================================================= */

    .reservation-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 30px;
    }

    .reservation-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #d97706;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .reservation-title {
        margin: 0;
        color: #1c1917;
        font-size: 30px;
        line-height: 1.15;
        font-weight: 800;
        letter-spacing: -.025em;
    }

    .reservation-subtitle {
        margin-top: 8px;
        color: #78716c;
        font-size: 14px;
        line-height: 1.6;
    }

    .booking-page-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        min-height: 44px;
        padding: 0 17px;
        border-radius: 12px;
        background: #1c1917;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        transition: all .2s ease;
        box-shadow: 0 4px 12px rgba(28, 25, 23, .08);
    }

    .booking-page-btn:hover {
        background: #292524;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 7px 18px rgba(28, 25, 23, .13);
    }

    /* =========================================================
       ALERTS
    ========================================================= */

    .reservation-alert {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 14px 16px;
        margin-bottom: 22px;
        border-radius: 14px;
        font-size: 13px;
        font-weight: 600;
        animation: alertIn .3s ease;
    }

    @keyframes alertIn {
        from {
            opacity: 0;
            transform: translateY(-6px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        color: #166534;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
    }

    .alert-error {
        color: #991b1b;
        background: #fef2f2;
        border: 1px solid #fecaca;
    }

    .alert-icon {
        width: 36px;
        height: 36px;
        min-width: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }

    .alert-success .alert-icon {
        background: #dcfce7;
    }

    .alert-error .alert-icon {
        background: #fee2e2;
    }

    .validation-list {
        margin: 4px 0 0;
        padding-left: 17px;
        font-weight: 500;
    }

    /* =========================================================
       STAT CARDS
    ========================================================= */

    .reservation-stat-card {
        position: relative;
        overflow: hidden;
        background: #fff;
        border: 1px solid #e7e5e4;
        border-radius: 16px;
        padding: 20px;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
    }

    .reservation-stat-card::after {
        content: "";
        position: absolute;
        right: -25px;
        bottom: -35px;
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: rgba(245, 158, 11, .035);
        pointer-events: none;
    }

    .reservation-stat-card:hover {
        transform: translateY(-3px);
        border-color: #d6d3d1;
        box-shadow: 0 12px 28px rgba(28, 25, 23, .07);
    }

    .stat-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
    }

    .stat-label {
        color: #78716c;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .01em;
    }

    .stat-number {
        margin-top: 7px;
        color: #1c1917;
        font-size: 30px;
        line-height: 1;
        font-weight: 800;
        letter-spacing: -.03em;
    }

    .stat-description {
        margin-top: 13px;
        color: #a8a29e;
        font-size: 11px;
        font-weight: 500;
    }

    .stat-icon {
        width: 43px;
        height: 43px;
        min-width: 43px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 16px;
    }

    .stat-total .stat-icon {
        color: #44403c;
        background: #f5f5f4;
    }

    .stat-pending .stat-icon {
        color: #d97706;
        background: #fffbeb;
    }

    .stat-confirmed .stat-icon {
        color: #2563eb;
        background: #eff6ff;
    }

    .stat-completed .stat-icon {
        color: #16a34a;
        background: #f0fdf4;
    }

    /* =========================================================
       MAIN RESERVATION PANEL
    ========================================================= */

    .reservation-panel {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e7e5e4;
        border-radius: 18px;
        box-shadow: 0 3px 12px rgba(28, 25, 23, .025);
    }

    .panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 21px 24px;
        border-bottom: 1px solid #e7e5e4;
    }

    .panel-title {
        margin: 0;
        color: #1c1917;
        font-size: 17px;
        font-weight: 800;
    }

    .panel-description {
        margin-top: 4px;
        color: #78716c;
        font-size: 12px;
    }

    .reservation-count {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 11px;
        border-radius: 10px;
        background: #f5f5f4;
        color: #57534e;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    /* =========================================================
       TABLE
    ========================================================= */

    .reservation-table {
        width: 100%;
        border-collapse: collapse;
    }

    .reservation-table thead {
        background: #fafaf9;
    }

    .reservation-table th {
        padding: 13px 22px;
        color: #78716c;
        border-bottom: 1px solid #e7e5e4;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
        text-align: left;
        white-space: nowrap;
    }

    .reservation-table td {
        padding: 17px 22px;
        border-bottom: 1px solid #f5f5f4;
        vertical-align: middle;
    }

    .reservation-table tbody tr {
        transition: background-color .18s ease;
    }

    .reservation-table tbody tr:hover {
        background: #fcfcfb;
    }

    .reservation-table tbody tr:last-child td {
        border-bottom: 0;
    }

    /* Reservation identity */

    .reservation-id-wrap {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .reservation-icon {
        width: 39px;
        height: 39px;
        min-width: 39px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        background: #fffbeb;
        color: #d97706;
        font-size: 14px;
    }

    .reservation-id {
        color: #1c1917;
        font-size: 13px;
        font-weight: 800;
    }

    .reservation-created {
        margin-top: 3px;
        color: #a8a29e;
        font-size: 10px;
    }

    /* Customer */

    .customer-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 180px;
    }

    .customer-avatar {
        width: 37px;
        height: 37px;
        min-width: 37px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #292524;
        color: #fff;
        font-size: 12px;
        font-weight: 800;
    }

    .customer-name {
        max-width: 175px;
        overflow: hidden;
        color: #292524;
        font-size: 12px;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .customer-email {
        max-width: 175px;
        margin-top: 2px;
        overflow: hidden;
        color: #a8a29e;
        font-size: 10px;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Details */

    .reservation-detail {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #44403c;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .reservation-detail i {
        color: #a8a29e;
        font-size: 12px;
    }

    /* Guests */

    .guest-count {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #44403c;
        font-size: 12px;
        font-weight: 700;
    }

    .guest-count i {
        color: #a8a29e;
    }

    /* =========================================================
       STATUS
    ========================================================= */

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 10px;
        line-height: 1;
        font-weight: 800;
        white-space: nowrap;
    }

    .status-pending {
        color: #b45309;
        background: #fef3c7;
    }

    .status-confirmed {
        color: #1d4ed8;
        background: #dbeafe;
    }

    .status-completed {
        color: #15803d;
        background: #dcfce7;
    }

    .status-cancelled {
        color: #b91c1c;
        background: #fee2e2;
    }

    .status-unknown {
        color: #57534e;
        background: #f5f5f4;
    }

    /* =========================================================
       STATUS SELECT
    ========================================================= */

    .status-form {
        margin: 0;
    }

    .status-select {
        min-width: 125px;
        height: 37px;
        padding: 0 30px 0 11px;
        border: 1px solid #e7e5e4;
        border-radius: 10px;
        outline: none;
        background-color: #fff;
        color: #44403c;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        transition: all .2s ease;
    }

    .status-select:hover {
        border-color: #d6d3d1;
        background-color: #fafaf9;
    }

    .status-select:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, .1);
    }

    /* =========================================================
       MOBILE CARDS
    ========================================================= */

    .mobile-reservation {
        padding: 18px;
        border-bottom: 1px solid #f5f5f4;
    }

    .mobile-reservation:last-child {
        border-bottom: 0;
    }

    .mobile-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 16px;
    }

    .mobile-id-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }

    .mobile-reservation-icon {
        width: 42px;
        height: 42px;
        min-width: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #fffbeb;
        color: #d97706;
    }

    .mobile-id {
        color: #1c1917;
        font-size: 13px;
        font-weight: 800;
    }

    .mobile-created {
        margin-top: 3px;
        color: #a8a29e;
        font-size: 10px;
    }

    .mobile-customer {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px;
        margin-bottom: 13px;
        border-radius: 12px;
        background: #fafaf9;
        border: 1px solid #f5f5f4;
    }

    .mobile-customer .customer-avatar {
        width: 38px;
        height: 38px;
        min-width: 38px;
    }

    .mobile-details {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 9px;
        margin-bottom: 15px;
    }

    .mobile-detail-box {
        padding: 11px;
        border-radius: 11px;
        background: #fafaf9;
        border: 1px solid #f5f5f4;
    }

    .mobile-detail-label {
        margin-bottom: 5px;
        color: #a8a29e;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .mobile-detail-value {
        color: #292524;
        font-size: 11px;
        font-weight: 800;
    }

    .mobile-status-label {
        display: block;
        margin-bottom: 7px;
        color: #78716c;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .mobile-status-select {
        width: 100%;
        height: 42px;
    }

    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .empty-state {
        padding: 75px 25px;
        text-align: center;
    }

    .empty-icon {
        width: 72px;
        height: 72px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        border-radius: 18px;
        background: #f5f5f4;
        color: #a8a29e;
        font-size: 27px;
    }

    .empty-title {
        color: #292524;
        font-size: 17px;
        font-weight: 800;
    }

    .empty-description {
        max-width: 420px;
        margin: 7px auto 0;
        color: #78716c;
        font-size: 12px;
        line-height: 1.6;
    }

    /* =========================================================
       FOOTER
    ========================================================= */

    .reservation-footer {
        margin-top: 25px;
        padding-bottom: 5px;
        color: #a8a29e;
        font-size: 10px;
        text-align: center;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 767px) {
        .reservation-header {
            align-items: stretch;
            flex-direction: column;
            margin-bottom: 24px;
            gap: 16px;
        }

        .reservation-title {
            font-size: 25px;
        }

        .booking-page-btn {
            width: 100%;
        }

        .panel-header {
            align-items: flex-start;
            flex-direction: column;
            padding: 18px;
        }

        .reservation-count {
            align-self: flex-start;
        }

        .reservation-stat-card {
            padding: 17px;
        }

        .stat-number {
            font-size: 27px;
        }
    }
</style>

@endsection

@section('content')

@php
$pendingCount = $reservations->where('status', 'pending')->count();
$confirmedCount = $reservations->where('status', 'confirmed')->count();
$completedCount = $reservations->where('status', 'completed')->count();
$cancelledCount = $reservations->where('status', 'cancelled')->count();
$totalCount = $reservations->count();
@endphp

<div class="reservation-page">


{{-- =====================================================
     PAGE HEADER
====================================================== --}}

<div class="reservation-header">

    <div>
        <div class="reservation-eyebrow">
            <i class="fa-solid fa-calendar-check"></i>
            Table Management
        </div>

        <h1 class="reservation-title">
            Reservations
        </h1>

        <p class="reservation-subtitle">
            Manage customer table bookings and reservation status.
        </p>
    </div>

    <a
        href="{{ route('user.book-table') }}"
        target="_blank"
        rel="noopener noreferrer"
        class="booking-page-btn"
    >
        <i class="fa-solid fa-arrow-up-right-from-square"></i>
        View Booking Page
    </a>

</div>


{{-- =====================================================
     SUCCESS MESSAGE
====================================================== --}}

@if(session('success'))

    <div class="reservation-alert alert-success">

        <div class="alert-icon">
            <i class="fa-solid fa-check"></i>
        </div>

        <div>
            {{ session('success') }}
        </div>

    </div>

@endif


{{-- =====================================================
     ERROR MESSAGE
====================================================== --}}

@if(session('error'))

    <div class="reservation-alert alert-error">

        <div class="alert-icon">
            <i class="fa-solid fa-circle-exclamation"></i>
        </div>

        <div>
            {{ session('error') }}
        </div>

    </div>

@endif


{{-- =====================================================
     VALIDATION ERRORS
====================================================== --}}

@if($errors->any())

    <div class="reservation-alert alert-error">

        <div class="alert-icon">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>

        <div>
            <div>Please check the following:</div>

            <ul class="validation-list">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

    </div>

@endif


{{-- =====================================================
     STATISTICS
====================================================== --}}

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-7">

    {{-- Total --}}
    <div class="reservation-stat-card stat-total">

        <div class="stat-top">

            <div>
                <div class="stat-label">
                    Total Reservations
                </div>

                <div class="stat-number">
                    {{ $totalCount }}
                </div>
            </div>

            <div class="stat-icon">
                <i class="fa-solid fa-calendar-days"></i>
            </div>

        </div>

        <div class="stat-description">
            All customer bookings
        </div>

    </div>


    {{-- Pending --}}
    <div class="reservation-stat-card stat-pending">

        <div class="stat-top">

            <div>
                <div class="stat-label">
                    Pending
                </div>

                <div class="stat-number text-amber-600">
                    {{ $pendingCount }}
                </div>
            </div>

            <div class="stat-icon">
                <i class="fa-solid fa-clock"></i>
            </div>

        </div>

        <div class="stat-description">
            Awaiting confirmation
        </div>

    </div>


    {{-- Confirmed --}}
    <div class="reservation-stat-card stat-confirmed">

        <div class="stat-top">

            <div>
                <div class="stat-label">
                    Confirmed
                </div>

                <div class="stat-number text-blue-600">
                    {{ $confirmedCount }}
                </div>
            </div>

            <div class="stat-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>

        </div>

        <div class="stat-description">
            Approved bookings
        </div>

    </div>


    {{-- Completed --}}
    <div class="reservation-stat-card stat-completed">

        <div class="stat-top">

            <div>
                <div class="stat-label">
                    Completed
                </div>

                <div class="stat-number text-green-600">
                    {{ $completedCount }}
                </div>
            </div>

            <div class="stat-icon">
                <i class="fa-solid fa-check-double"></i>
            </div>

        </div>

        <div class="stat-description">
            Finished reservations
        </div>

    </div>

</div>


{{-- =====================================================
     RESERVATIONS PANEL
====================================================== --}}

<div class="reservation-panel">

    {{-- Panel Header --}}
    <div class="panel-header">

        <div>
            <h2 class="panel-title">
                All Reservations
            </h2>

            <p class="panel-description">
                Review customer bookings and update their status.
            </p>
        </div>

        <div class="reservation-count">
            <i class="fa-solid fa-calendar-check"></i>

            {{ $totalCount }}

            reservation{{ $totalCount !== 1 ? 's' : '' }}
        </div>

    </div>


    @if($totalCount > 0)

        {{-- =================================================
             DESKTOP TABLE
        ================================================== --}}

        <div class="hidden md:block overflow-x-auto">

            <table class="reservation-table">

                <thead>
                    <tr>

                        <th>Reservation</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Guests</th>
                        <th>Status</th>
                        <th>Update</th>

                    </tr>
                </thead>

                <tbody>

                    @foreach($reservations as $reservation)

                        <tr>

                            {{-- Reservation --}}
                            <td>

                                <div class="reservation-id-wrap">

                                    <div class="reservation-icon">
                                        <i class="fa-solid fa-calendar-check"></i>
                                    </div>

                                    <div>

                                        <div class="reservation-id">
                                            #{{ $reservation->id }}
                                        </div>

                                        <div class="reservation-created">
                                            {{ $reservation->created_at?->format('d M Y') ?? '—' }}
                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- Customer --}}
                            <td>

                                <div class="customer-wrap">

                                    <div class="customer-avatar">
                                        {{ strtoupper(substr($reservation->user->name ?? 'U', 0, 1)) }}
                                    </div>

                                    <div class="min-w-0">

                                        <div class="customer-name">
                                            {{ $reservation->user->name ?? 'Unknown Customer' }}
                                        </div>

                                        <div class="customer-email">
                                            {{ $reservation->user->email ?? 'No email' }}
                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- Date --}}
                            <td>

                                <div class="reservation-detail">

                                    <i class="fa-regular fa-calendar"></i>

                                    @if($reservation->date)
                                        {{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }}
                                    @else
                                        —
                                    @endif

                                </div>

                            </td>


                            {{-- Time --}}
                            <td>

                                <div class="reservation-detail">

                                    <i class="fa-regular fa-clock"></i>

                                    @if($reservation->time)
                                        {{ \Carbon\Carbon::parse($reservation->time)->format('h:i A') }}
                                    @else
                                        —
                                    @endif

                                </div>

                            </td>


                            {{-- Guests --}}
                            <td>

                                <div class="guest-count">

                                    <i class="fa-solid fa-users"></i>

                                    {{ $reservation->guests }}

                                </div>

                            </td>


                            {{-- Status --}}
                            <td>

                                @if($reservation->status === 'pending')

                                    <span class="status-badge status-pending">
                                        <i class="fa-solid fa-clock"></i>
                                        Pending
                                    </span>

                                @elseif($reservation->status === 'confirmed')

                                    <span class="status-badge status-confirmed">
                                        <i class="fa-solid fa-check"></i>
                                        Confirmed
                                    </span>

                                @elseif($reservation->status === 'completed')

                                    <span class="status-badge status-completed">
                                        <i class="fa-solid fa-check-double"></i>
                                        Completed
                                    </span>

                                @elseif($reservation->status === 'cancelled')

                                    <span class="status-badge status-cancelled">
                                        <i class="fa-solid fa-xmark"></i>
                                        Cancelled
                                    </span>

                                @else

                                    <span class="status-badge status-unknown">
                                        {{ ucfirst($reservation->status ?? 'Unknown') }}
                                    </span>

                                @endif

                            </td>


                            {{-- Update --}}
                            <td>

                                <form
                                    action="{{ route('admin.reservations.status', $reservation->id) }}"
                                    method="POST"
                                    class="status-form"
                                >

                                    @csrf
                                    @method('PUT')

                                    <select
                                        name="status"
                                        onchange="this.form.submit()"
                                        class="status-select"
                                        aria-label="Update reservation status"
                                    >

                                        <option
                                            value="pending"
                                            {{ $reservation->status === 'pending' ? 'selected' : '' }}
                                        >
                                            Pending
                                        </option>

                                        <option
                                            value="confirmed"
                                            {{ $reservation->status === 'confirmed' ? 'selected' : '' }}
                                        >
                                            Confirmed
                                        </option>

                                        <option
                                            value="completed"
                                            {{ $reservation->status === 'completed' ? 'selected' : '' }}
                                        >
                                            Completed
                                        </option>

                                        <option
                                            value="cancelled"
                                            {{ $reservation->status === 'cancelled' ? 'selected' : '' }}
                                        >
                                            Cancelled
                                        </option>

                                    </select>

                                </form>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- =================================================
             MOBILE CARDS
        ================================================== --}}

        <div class="md:hidden">

            @foreach($reservations as $reservation)

                <div class="mobile-reservation">

                    {{-- Top --}}
                    <div class="mobile-top">

                        <div class="mobile-id-wrap">

                            <div class="mobile-reservation-icon">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>

                            <div class="min-w-0">

                                <div class="mobile-id">
                                    Reservation #{{ $reservation->id }}
                                </div>

                                <div class="mobile-created">
                                    {{ $reservation->created_at?->format('d M Y') ?? '—' }}
                                </div>

                            </div>

                        </div>


                        {{-- Mobile Status --}}
                        @if($reservation->status === 'pending')

                            <span class="status-badge status-pending">
                                Pending
                            </span>

                        @elseif($reservation->status === 'confirmed')

                            <span class="status-badge status-confirmed">
                                Confirmed
                            </span>

                        @elseif($reservation->status === 'completed')

                            <span class="status-badge status-completed">
                                Completed
                            </span>

                        @elseif($reservation->status === 'cancelled')

                            <span class="status-badge status-cancelled">
                                Cancelled
                            </span>

                        @else

                            <span class="status-badge status-unknown">
                                {{ ucfirst($reservation->status ?? 'Unknown') }}
                            </span>

                        @endif

                    </div>


                    {{-- Customer --}}
                    <div class="mobile-customer">

                        <div class="customer-avatar">
                            {{ strtoupper(substr($reservation->user->name ?? 'U', 0, 1)) }}
                        </div>

                        <div class="min-w-0">

                            <div class="customer-name">
                                {{ $reservation->user->name ?? 'Unknown Customer' }}
                            </div>

                            <div class="customer-email">
                                {{ $reservation->user->email ?? 'No email' }}
                            </div>

                        </div>

                    </div>


                    {{-- Details --}}
                    <div class="mobile-details">

                        <div class="mobile-detail-box">

                            <div class="mobile-detail-label">
                                Date
                            </div>

                            <div class="mobile-detail-value">
                                @if($reservation->date)
                                    {{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }}
                                @else
                                    —
                                @endif
                            </div>

                        </div>


                        <div class="mobile-detail-box">

                            <div class="mobile-detail-label">
                                Time
                            </div>

                            <div class="mobile-detail-value">
                                @if($reservation->time)
                                    {{ \Carbon\Carbon::parse($reservation->time)->format('h:i A') }}
                                @else
                                    —
                                @endif
                            </div>

                        </div>


                        <div class="mobile-detail-box">

                            <div class="mobile-detail-label">
                                Guests
                            </div>

                            <div class="mobile-detail-value">
                                <i class="fa-solid fa-users mr-1 text-stone-400"></i>
                                {{ $reservation->guests }}
                            </div>

                        </div>


                        <div class="mobile-detail-box">

                            <div class="mobile-detail-label">
                                Booking ID
                            </div>

                            <div class="mobile-detail-value">
                                #{{ $reservation->id }}
                            </div>

                        </div>

                    </div>


                    {{-- Status Update --}}
                    <form
                        action="{{ route('admin.reservations.status', $reservation->id) }}"
                        method="POST"
                        class="status-form"
                    >

                        @csrf
                        @method('PUT')

                        <label class="mobile-status-label">
                            Update Status
                        </label>

                        <select
                            name="status"
                            onchange="this.form.submit()"
                            class="status-select mobile-status-select"
                        >

                            <option
                                value="pending"
                                {{ $reservation->status === 'pending' ? 'selected' : '' }}
                            >
                                Pending
                            </option>

                            <option
                                value="confirmed"
                                {{ $reservation->status === 'confirmed' ? 'selected' : '' }}
                            >
                                Confirmed
                            </option>

                            <option
                                value="completed"
                                {{ $reservation->status === 'completed' ? 'selected' : '' }}
                            >
                                Completed
                            </option>

                            <option
                                value="cancelled"
                                {{ $reservation->status === 'cancelled' ? 'selected' : '' }}
                            >
                                Cancelled
                            </option>

                        </select>

                    </form>

                </div>

            @endforeach

        </div>

    @else

        {{-- =================================================
             EMPTY STATE
        ================================================== --}}

        <div class="empty-state">

            <div class="empty-icon">
                <i class="fa-regular fa-calendar-xmark"></i>
            </div>

            <div class="empty-title">
                No Reservations Yet
            </div>

            <p class="empty-description">
                Customer table reservations will appear here once someone books a table.
            </p>

            <a
                href="{{ route('user.book-table') }}"
                target="_blank"
                rel="noopener noreferrer"
                class="booking-page-btn mt-6"
            >
                <i class="fa-solid fa-calendar-plus"></i>
                View Booking Page
            </a>

        </div>

    @endif

</div>


{{-- =====================================================
     FOOTER
====================================================== --}}

<div class="reservation-footer">
    Restaurant Management System &bull; Admin Panel
</div>


</div>

@endsection
