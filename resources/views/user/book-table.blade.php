@extends('layouts.user')

@section('title', 'Book a Table')

@section('styles')

<style>
    .booking-page {
        max-width: 1050px;
        margin: 0 auto;
    }

    .booking-hero {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #211b16 0%, #3a2c20 55%, #181411 100%);
        color: #fff;
        padding: 42px 45px;
        border-radius: 22px;
        margin-bottom: 24px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, .14);
    }

    .booking-hero::before {
        content: "";
        position: absolute;
        width: 230px;
        height: 230px;
        border: 1px solid rgba(212, 166, 92, .25);
        border-radius: 50%;
        right: -70px;
        top: -100px;
    }

    .booking-hero::after {
        content: "";
        position: absolute;
        width: 150px;
        height: 150px;
        border: 1px solid rgba(212, 166, 92, .15);
        border-radius: 50%;
        right: 40px;
        bottom: -90px;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 700px;
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
        margin-bottom: 12px;
    }

    .booking-hero h1 {
        margin: 0 0 10px;
        font-size: 38px;
        line-height: 1.15;
        letter-spacing: -.8px;
    }

    .booking-hero p {
        margin: 0;
        color: #d9d0c6;
        font-size: 16px;
        line-height: 1.7;
    }

    .booking-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.45fr) minmax(280px, .75fr);
        gap: 24px;
        align-items: start;
    }

    .booking-card,
    .info-card {
        background: #fff;
        border: 1px solid #eee6dc;
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(50, 38, 25, .07);
    }

    .booking-card {
        padding: 32px;
    }

    .card-heading {
        margin-bottom: 26px;
    }

    .card-heading h2 {
        margin: 0 0 7px;
        color: #211b16;
        font-size: 23px;
    }

    .card-heading p {
        margin: 0;
        color: #84796e;
        font-size: 14px;
    }

    .alert {
        padding: 14px 16px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 14px;
        line-height: 1.5;
    }

    .success {
        background: #edf8f0;
        color: #24613a;
        border: 1px solid #ccebd4;
    }

    .error {
        background: #fff1f0;
        color: #8b3029;
        border: 1px solid #f2d0cc;
    }

    .error div {
        margin-bottom: 5px;
    }

    .error div:last-child {
        margin-bottom: 0;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #332b24;
        font-size: 13px;
        font-weight: 800;
    }

    .required {
        color: #b8873d;
    }

    .input-wrap {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 17px;
        pointer-events: none;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        min-height: 50px;
        padding: 13px 14px 13px 45px;
        border: 1px solid #ded6cc;
        border-radius: 11px;
        background: #fcfaf8;
        color: #29231e;
        font-size: 14px;
        box-sizing: border-box;
        transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .form-group input[type="date"],
    .form-group input[type="time"] {
        padding-right: 14px;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        background: #fff;
        border-color: #c99a52;
        box-shadow: 0 0 0 4px rgba(201, 154, 82, .12);
    }

    .field-hint {
        margin-top: 7px;
        color: #968b80;
        font-size: 12px;
    }

    .submit-btn {
        width: 100%;
        min-height: 53px;
        border: 0;
        border-radius: 11px;
        background: linear-gradient(135deg, #c9974d, #a97836);
        color: #fff;
        font-size: 15px;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 8px 18px rgba(169, 120, 54, .22);
        transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
    }

    .submit-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 11px 24px rgba(169, 120, 54, .28);
        filter: brightness(1.04);
    }

    .submit-btn:active {
        transform: translateY(0);
    }

    .info-card {
        padding: 27px;
    }

    .info-card h3 {
        margin: 0 0 18px;
        color: #211b16;
        font-size: 19px;
    }

    .info-list {
        display: grid;
        gap: 16px;
    }

    .info-item {
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .info-icon {
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f7efe3;
        border-radius: 10px;
        font-size: 17px;
    }

    .info-item strong {
        display: block;
        margin-bottom: 3px;
        color: #382f27;
        font-size: 13px;
    }

    .info-item span {
        display: block;
        color: #897d71;
        font-size: 12px;
        line-height: 1.5;
    }

    .reservation-link {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 18px;
        padding: 13px;
        border: 1px solid #dfd1bf;
        border-radius: 11px;
        color: #8d652e;
        background: #fffaf3;
        text-decoration: none;
        font-size: 13px;
        font-weight: 800;
        transition: background .2s ease, border-color .2s ease;
    }

    .reservation-link:hover {
        background: #f9f0e3;
        border-color: #cda263;
    }

    .booking-note {
        margin-top: 20px;
        padding: 14px 16px;
        border-radius: 12px;
        background: #f8f5f1;
        color: #756a60;
        font-size: 12px;
        line-height: 1.6;
    }

    @media (max-width: 800px) {
        .booking-layout {
            grid-template-columns: 1fr;
        }

        .booking-hero {
            padding: 34px 28px;
        }

        .booking-hero h1 {
            font-size: 31px;
        }
    }

    @media (max-width: 560px) {
        .booking-page {
            width: 100%;
        }

        .booking-hero {
            padding: 30px 22px;
            border-radius: 17px;
        }

        .booking-hero h1 {
            font-size: 27px;
        }

        .booking-card,
        .info-card {
            padding: 22px;
            border-radius: 15px;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .form-group.full-width {
            grid-column: auto;
        }
    }
</style>

@endsection

@section('content')

<div class="booking-page">


{{-- Hero --}}
<div class="booking-hero">
    <div class="hero-content">
        <div class="eyebrow">
            ✦ Reserve your experience
        </div>

        <h1>Book a Table</h1>

        <p>
            Choose your preferred date, time, and number of guests.
            We'll have your table ready when you arrive.
        </p>
    </div>
</div>

<div class="booking-layout">

    {{-- Booking Form --}}
    <div class="booking-card">

        <div class="card-heading">
            <h2>Reservation Details</h2>
            <p>Please provide the details for your dining reservation.</p>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert success">
                ✓ {{ session('success') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="alert error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form
            action="{{ route('user.book-table.store') }}"
            method="POST"
        >
            @csrf

            <div class="form-grid">

                {{-- Guests --}}
                <div class="form-group">
                    <label for="guests">
                        Number of Guests <span class="required">*</span>
                    </label>

                    <div class="input-wrap">
                        <span class="input-icon">👥</span>

                        <select
                            id="guests"
                            name="guests"
                            required
                        >
                            <option value="">Select guests</option>

                            @for($i = 1; $i <= 20; $i++)
                                <option
                                    value="{{ $i }}"
                                    {{ old('guests') == $i ? 'selected' : '' }}
                                >
                                    {{ $i }}
                                    {{ $i == 1 ? 'Guest' : 'Guests' }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="field-hint">
                        Tables are available for 1–20 guests.
                    </div>
                </div>

                {{-- Date --}}
                <div class="form-group">
                    <label for="date">
                        Date <span class="required">*</span>
                    </label>

                    <div class="input-wrap">
                        <span class="input-icon">📅</span>

                        <input
                            type="date"
                            id="date"
                            name="date"
                            value="{{ old('date') }}"
                            min="{{ date('Y-m-d') }}"
                            required
                        >
                    </div>

                    <div class="field-hint">
                        Same-day and future reservations are available.
                    </div>
                </div>

                {{-- Time --}}
                <div class="form-group full-width">
                    <label for="time">
                        Preferred Time <span class="required">*</span>
                    </label>

                    <div class="input-wrap">
                        <span class="input-icon">🕐</span>

                        <input
                            type="time"
                            id="time"
                            name="time"
                            value="{{ old('time') }}"
                            required
                        >
                    </div>
                </div>

            </div>

            <button
                type="submit"
                class="submit-btn"
            >
                🪑 Confirm Table Reservation
            </button>
        </form>

        <div class="booking-note">
            <strong>Good to know:</strong>
            Your reservation request will be submitted to the restaurant.
            You can view your reservation status from your reservations page.
        </div>

    </div>

    {{-- Information Sidebar --}}
    <aside class="info-card">

        <h3>Reservation Guide</h3>

        <div class="info-list">

            <div class="info-item">
                <div class="info-icon">👥</div>

                <div>
                    <strong>Choose your party size</strong>
                    <span>
                        Select the number of guests joining you.
                    </span>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">📅</div>

                <div>
                    <strong>Select your date</strong>
                    <span>
                        Pick today or any future date available.
                    </span>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">🕐</div>

                <div>
                    <strong>Select your time</strong>
                    <span>
                        Choose the time that works best for your visit.
                    </span>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">✓</div>

                <div>
                    <strong>Track your reservation</strong>
                    <span>
                        Check your booking status anytime from your account.
                    </span>
                </div>
            </div>

        </div>

        <a
            href="{{ route('user.reservations') }}"
            class="reservation-link"
        >
            📋 View My Reservations
        </a>

    </aside>

</div>


</div>

@endsection
