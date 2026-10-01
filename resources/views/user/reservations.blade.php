@extends('layouts.user')

@section('title', 'My Reservations')

@section('styles')

<style>
    .reservations-page {
        max-width: 1050px;
        margin: 0 auto;
    }

    /* Hero */
    .reservations-hero {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #211b16 0%, #3a2c20 55%, #181411 100%);
        color: #fff;
        padding: 40px 44px;
        border-radius: 22px;
        margin-bottom: 24px;
        box-shadow: 0 15px 40px rgba(50, 38, 25, .14);
    }

    .reservations-hero::before {
        content: "";
        position: absolute;
        width: 240px;
        height: 240px;
        right: -80px;
        top: -110px;
        border: 1px solid rgba(216, 177, 106, .25);
        border-radius: 50%;
    }

    .reservations-hero::after {
        content: "";
        position: absolute;
        width: 150px;
        height: 150px;
        right: 50px;
        bottom: -100px;
        border: 1px solid rgba(216, 177, 106, .15);
        border-radius: 50%;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #d8b16a;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .reservations-hero h1 {
        margin: 0 0 9px;
        font-size: 36px;
        line-height: 1.15;
        letter-spacing: -.7px;
    }

    .reservations-hero p {
        margin: 0;
        color: #d9d0c6;
        font-size: 15px;
        line-height: 1.7;
        max-width: 650px;
    }

    .hero-action {
        position: absolute;
        right: 38px;
        bottom: 32px;
        z-index: 3;
    }

    .new-booking-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 17px;
        border-radius: 10px;
        background: #d1a35b;
        color: #211b16;
        text-decoration: none;
        font-size: 13px;
        font-weight: 800;
        transition: transform .2s ease, background .2s ease;
    }

    .new-booking-btn:hover {
        background: #e0b873;
        transform: translateY(-1px);
    }

    /* Alerts */
    .alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 14px 16px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 14px;
        line-height: 1.5;
    }

    .alert-success {
        background: #edf8f0;
        color: #24613a;
        border: 1px solid #ccebd4;
    }

    .alert-error {
        background: #fff1f0;
        color: #8b3029;
        border: 1px solid #f2d0cc;
    }

    /* Reservation list */
    .section-heading {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 15px;
        margin: 0 0 15px;
    }

    .section-heading h2 {
        margin: 0;
        color: #211b16;
        font-size: 22px;
    }

    .section-heading span {
        color: #918579;
        font-size: 12px;
    }

    .reservation-card {
        background: #fff;
        border: 1px solid #eee6dc;
        border-radius: 18px;
        margin-bottom: 18px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(50, 38, 25, .07);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .reservation-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(50, 38, 25, .10);
    }

    .reservation-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 21px 24px;
        border-bottom: 1px solid #f0eae3;
        flex-wrap: wrap;
    }

    .reservation-id-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .reservation-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f7efe3;
        border-radius: 11px;
        font-size: 19px;
    }

    .reservation-id {
        color: #211b16;
        font-size: 16px;
        font-weight: 800;
    }

    .reservation-created {
        margin-top: 3px;
        color: #958a7f;
        font-size: 11px;
    }

    /* Status */
    .status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 800;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .status::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-pending {
        background: #fff5df;
        color: #9a6a19;
    }

    .status-confirmed {
        background: #eaf6f7;
        color: #17636b;
    }

    .status-completed {
        background: #edf8f0;
        color: #287044;
    }

    .status-cancelled {
        background: #fff0ef;
        color: #a03b33;
    }

    .status-default {
        background: #f1efed;
        color: #6c6259;
    }

    /* Details */
    .reservation-body {
        padding: 22px 24px;
    }

    .reservation-details {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 13px;
    }

    .detail {
        background: #faf8f6;
        border: 1px solid #f0e9e1;
        padding: 16px;
        border-radius: 12px;
    }

    .detail-label {
        display: block;
        color: #91867a;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .7px;
        margin-bottom: 7px;
    }

    .detail-value {
        color: #322a23;
        font-size: 15px;
        font-weight: 800;
    }

    .reservation-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-top: 20px;
        padding-top: 18px;
        border-top: 1px solid #f0eae3;
    }

    .booking-message {
        color: #8d8277;
        font-size: 12px;
    }

    .cancel-form {
        margin: 0;
    }

    .cancel-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #fff;
        color: #a13b33;
        border: 1px solid #e4c8c4;
        padding: 10px 14px;
        border-radius: 9px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 800;
        transition: background .2s ease, border-color .2s ease;
    }

    .cancel-btn:hover {
        background: #fff3f2;
        border-color: #d9aaa5;
    }

    /* Empty state */
    .empty-state {
        background: #fff;
        border: 1px solid #eee6dc;
        padding: 65px 25px;
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(50, 38, 25, .07);
        text-align: center;
    }

    .empty-icon {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        background: #f8f0e5;
        border-radius: 50%;
        font-size: 30px;
    }

    .empty-state h2 {
        margin: 0 0 8px;
        color: #29221c;
        font-size: 22px;
    }

    .empty-state p {
        color: #8c8176;
        margin: 0 auto 23px;
        font-size: 14px;
    }

    .book-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #c9974d, #a97836);
        color: #fff;
        text-decoration: none;
        padding: 12px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 800;
        box-shadow: 0 7px 17px rgba(169, 120, 54, .2);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .book-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 22px rgba(169, 120, 54, .27);
    }

    @media (max-width: 800px) {
        .reservations-hero {
            padding: 34px 28px;
        }

        .reservations-hero h1 {
            font-size: 31px;
        }

        .hero-action {
            position: static;
            margin-top: 20px;
        }

        .reservation-details {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 560px) {
        .reservations-hero {
            padding: 28px 21px;
            border-radius: 17px;
        }

        .reservations-hero h1 {
            font-size: 27px;
        }

        .reservation-top,
        .reservation-body {
            padding: 18px;
        }

        .reservation-top {
            align-items: flex-start;
        }

        .reservation-footer {
            align-items: stretch;
            flex-direction: column;
        }

        .cancel-btn {
            width: 100%;
            justify-content: center;
        }

        .section-heading {
            align-items: flex-start;
            flex-direction: column;
            gap: 5px;
        }
    }
</style>

@endsection

@section('content')

<div class="reservations-page">


{{-- Hero --}}
<div class="reservations-hero">

    <div class="hero-content">

        <div class="eyebrow">
            ✦ Your dining plans
        </div>

        <h1>My Reservations</h1>

        <p>
            Keep track of your table bookings and manage your upcoming
            restaurant visits from one place.
        </p>

        <div class="hero-action">
            <a
                href="{{ route('user.book-table') }}"
                class="new-booking-btn"
            >
                🪑 Book Another Table
            </a>
        </div>

    </div>

</div>

{{-- Success --}}
@if(session('success'))
    <div class="alert alert-success">
        <span>✓</span>
        <span>{{ session('success') }}</span>
    </div>
@endif

{{-- Error --}}
@if(session('error'))
    <div class="alert alert-error">
        <span>!</span>
        <span>{{ session('error') }}</span>
    </div>
@endif

@if($reservations->count())

    <div class="section-heading">
        <h2>Your Bookings</h2>

        <span>
            {{ $reservations->count() }}
            {{ $reservations->count() === 1 ? 'reservation' : 'reservations' }}
        </span>
    </div>

@endif

{{-- Reservations --}}
@forelse($reservations as $reservation)

    <div class="reservation-card">

        <div class="reservation-top">

            <div class="reservation-id-wrap">

                <div class="reservation-icon">
                    🪑
                </div>

                <div>
                    <div class="reservation-id">
                        Reservation #{{ $reservation->id }}
                    </div>

                    <div class="reservation-created">
                        Restaurant table booking
                    </div>
                </div>

            </div>

            @php
                $status = strtolower($reservation->status ?? 'pending');

                $statusClass = in_array($status, [
                    'pending',
                    'confirmed',
                    'completed',
                    'cancelled'
                ]) ? $status : 'default';
            @endphp

            <span class="status status-{{ $statusClass }}">
                {{ $reservation->status ?? 'Pending' }}
            </span>

        </div>

        <div class="reservation-body">

            <div class="reservation-details">

                {{-- Guests --}}
                <div class="detail">

                    <span class="detail-label">
                        Guests
                    </span>

                    <span class="detail-value">
                        👥 {{ $reservation->guests }}
                        {{ $reservation->guests == 1 ? 'Guest' : 'Guests' }}
                    </span>

                </div>

                {{-- Date --}}
                <div class="detail">

                    <span class="detail-label">
                        Date
                    </span>

                    <span class="detail-value">
                        📅
                        @if($reservation->date)
                            {{ \Carbon\Carbon::parse($reservation->date)->format('d M Y') }}
                        @else
                            —
                        @endif
                    </span>

                </div>

                {{-- Time --}}
                <div class="detail">

                    <span class="detail-label">
                        Time
                    </span>

                    <span class="detail-value">
                        🕐
                        @if($reservation->time)
                            {{ \Carbon\Carbon::parse($reservation->time)->format('h:i A') }}
                        @else
                            —
                        @endif
                    </span>

                </div>

            </div>

            <div class="reservation-footer">

                @if($status === 'pending')
                    <div class="booking-message">
                        ⏳ Your reservation is waiting for confirmation.
                    </div>
                @elseif($status === 'confirmed')
                    <div class="booking-message">
                        ✓ Your table has been confirmed. We look forward to seeing you!
                    </div>
                @elseif($status === 'completed')
                    <div class="booking-message">
                        ✓ This reservation has been completed.
                    </div>
                @elseif($status === 'cancelled')
                    <div class="booking-message">
                        This reservation has been cancelled.
                    </div>
                @else
                    <div class="booking-message">
                        Reservation status: {{ $reservation->status }}
                    </div>
                @endif

                {{-- Cancel Button --}}
                @if($status === 'pending')

                    <form
                        action="{{ route('user.reservations.cancel', $reservation->id) }}"
                        method="POST"
                        class="cancel-form"
                        onsubmit="return confirm('Are you sure you want to cancel this reservation?');"
                    >
                        @csrf
                        @method('PUT')

                        <button
                            type="submit"
                            class="cancel-btn"
                        >
                            ✕ Cancel Reservation
                        </button>

                    </form>

                @endif

            </div>

        </div>

    </div>

@empty

    <div class="empty-state">

        <div class="empty-icon">
            🪑
        </div>

        <h2>No Reservations Yet</h2>

        <p>
            You haven't booked a table yet.
            Reserve your next dining experience in just a few clicks.
        </p>

        <a
            href="{{ route('user.book-table') }}"
            class="book-btn"
        >
            🪑 Book a Table
        </a>

    </div>

@endforelse


</div>

@endsection
