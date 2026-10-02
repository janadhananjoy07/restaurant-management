@extends('layouts.user')

@section('title', 'My Orders')

@section('styles')

<style>

    :root {
        --orders-dark: #1c1917;
        --orders-dark-2: #292524;
        --orders-text: #292524;
        --orders-muted: #78716c;
        --orders-light-muted: #a8a29e;

        --orders-gold: #b7791f;
        --orders-gold-light: #fbf3e5;
        --orders-gold-soft: #fffaf0;

        --orders-border: #e7e2da;
        --orders-bg: #f7f5f1;
        --orders-white: #ffffff;

        --green: #15803d;
        --green-bg: #f0fdf4;
        --green-border: #bbf7d0;

        --blue: #1d4ed8;
        --blue-bg: #eff6ff;
        --blue-border: #bfdbfe;

        --purple: #9333ea;
        --purple-bg: #faf5ff;

        --teal: #0f766e;
        --teal-bg: #f0fdfa;

        --yellow: #a16207;
        --yellow-bg: #fff7df;

        --red: #b91c1c;
        --red-bg: #fef2f2;
        --red-border: #fecaca;
    }


    /* =========================================================
       PAGE
    ========================================================= */

    .orders-page {
        width: 100%;
        color: var(--orders-text);
        padding-bottom: 40px;
    }


    /* =========================================================
       HEADER
    ========================================================= */

    .orders-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 25px;
        margin-bottom: 30px;
    }

    .orders-eyebrow {
        margin-bottom: 8px;
        color: var(--orders-gold);
        font-size: 10px;
        font-weight: 900;
        letter-spacing: 2.5px;
        text-transform: uppercase;
    }

    .orders-header h1 {
        margin: 0 0 8px;
        color: var(--orders-dark);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 40px;
        line-height: 1.1;
    }

    .orders-header p {
        margin: 0;
        color: var(--orders-muted);
        font-size: 14px;
        line-height: 1.6;
    }

    .order-food-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 44px;
        padding: 0 18px;
        border-radius: 9px;
        background: var(--orders-dark);
        color: white;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
        transition:
            transform .25s ease,
            background .25s ease,
            box-shadow .25s ease;
    }

    .order-food-btn:hover {
        color: white;
        background: var(--orders-gold);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(183, 121, 31, .18);
    }


    /* =========================================================
       ALERTS
    ========================================================= */

    .alert {
        display: flex;
        align-items: center;
        gap: 11px;
        margin-bottom: 22px;
        padding: 14px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
    }

    .alert-success {
        background: var(--green-bg);
        border: 1px solid var(--green-border);
        color: #166534;
    }

    .alert-error {
        background: var(--red-bg);
        border: 1px solid var(--red-border);
        color: #991b1b;
    }

    .alert-icon {
        width: 25px;
        height: 25px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: currentColor;
        color: white;
        font-size: 12px;
    }


    /* =========================================================
       ORDER CARD
    ========================================================= */

    .order-card {
        margin-bottom: 24px;
        overflow: hidden;
        background: white;
        border: 1px solid var(--orders-border);
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(28, 25, 23, .035);
        transition:
            border-color .25s ease,
            box-shadow .25s ease,
            transform .25s ease;
    }

    .order-card:hover {
        border-color: #d8c9b4;
        box-shadow: 0 12px 35px rgba(28, 25, 23, .07);
        transform: translateY(-1px);
    }


    /* =========================================================
       ORDER HEADER
    ========================================================= */

    .order-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        padding: 21px 24px;
        background: linear-gradient(
            135deg,
            #faf9f7,
            #fdfcfb
        );
        border-bottom: 1px solid var(--orders-border);
    }

    .order-heading {
        min-width: 0;
    }

    .order-label {
        margin-bottom: 5px;
        color: var(--orders-gold);
        font-size: 9px;
        font-weight: 900;
        letter-spacing: 1.8px;
        text-transform: uppercase;
    }

    .order-heading h2 {
        margin: 0 0 5px;
        color: var(--orders-dark);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 22px;
    }

    .order-date {
        color: var(--orders-muted);
        font-size: 11px;
    }

    .order-header-right {
        display: flex;
        align-items: center;
        gap: 9px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }


    /* =========================================================
       STATUS
    ========================================================= */

    .status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 11px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 900;
        letter-spacing: .6px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-pending {
        background: var(--yellow-bg);
        color: var(--yellow);
    }

    .status-confirmed {
        background: var(--blue-bg);
        color: var(--blue);
    }

    .status-preparing {
        background: rgba(168, 85, 247, .12);
        color: #9333ea;
    }

    .status-out-for-delivery {
        background: rgba(20, 184, 166, .12);
        color: #0f766e;
    }

    .status-completed {
        background: var(--green-bg);
        color: var(--green);
    }

    .status-cancelled {
        background: var(--red-bg);
        color: var(--red);
    }

    .status-default {
        background: #f5f5f4;
        color: #57534e;
    }


    /* =========================================================
       PAYMENT STATUS
    ========================================================= */

    .payment-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 11px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 900;
        letter-spacing: .5px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .payment-paid {
        background: var(--green-bg);
        color: var(--green);
    }

    .payment-pending {
        background: var(--yellow-bg);
        color: var(--yellow);
    }

    .payment-failed {
        background: var(--red-bg);
        color: var(--red);
    }

    .payment-unpaid {
        background: #f5f5f4;
        color: #57534e;
    }


    /* =========================================================
       BODY
    ========================================================= */

    .order-body {
        padding: 24px;
    }


    /* =========================================================
       TRACKING
    ========================================================= */

    .tracking-section {
        margin-bottom: 25px;
        padding: 18px;
        border: 1px solid var(--orders-border);
        border-radius: 12px;
        background: #fdfcfb;
    }

    .tracking-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }

    .tracking-title strong {
        color: var(--orders-dark);
        font-size: 12px;
    }

    .tracking-title span {
        color: var(--orders-muted);
        font-size: 10px;
    }

    .tracking {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 0;
    }

    .tracking-step {
        position: relative;
        text-align: center;
    }

    .tracking-step:not(:last-child)::after {
        content: "";
        position: absolute;
        top: 15px;
        left: 50%;
        width: 100%;
        height: 2px;
        background: #e7e5e4;
        z-index: 0;
    }

    .tracking-step.active:not(:last-child)::after {
        background: var(--orders-gold);
    }

    .tracking-icon {
        position: relative;
        z-index: 1;
        width: 30px;
        height: 30px;
        margin: 0 auto 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #f5f5f4;
        color: #a8a29e;
        border: 2px solid white;
        font-size: 11px;
        box-shadow: 0 0 0 1px #e7e5e4;
    }

    .tracking-step.active .tracking-icon {
        background: var(--orders-gold);
        color: white;
        box-shadow:
            0 0 0 1px var(--orders-gold),
            0 4px 12px rgba(183, 121, 31, .18);
    }

    .tracking-step.current .tracking-icon {
        animation: trackingPulse 1.8s infinite;
    }

    .tracking-label {
        display: block;
        color: var(--orders-muted);
        font-size: 9px;
        font-weight: 700;
        line-height: 1.3;
    }

    .tracking-step.active .tracking-label {
        color: var(--orders-dark);
    }

    @keyframes trackingPulse {

        0% {
            box-shadow:
                0 0 0 1px var(--orders-gold),
                0 0 0 0 rgba(183, 121, 31, .35);
        }

        70% {
            box-shadow:
                0 0 0 1px var(--orders-gold),
                0 0 0 8px rgba(183, 121, 31, 0);
        }

        100% {
            box-shadow:
                0 0 0 1px var(--orders-gold),
                0 0 0 0 rgba(183, 121, 31, 0);
        }
    }


    /* =========================================================
       CANCELLED
    ========================================================= */

    .cancelled-message {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 25px;
        padding: 12px 14px;
        border: 1px solid var(--red-border);
        border-radius: 9px;
        background: var(--red-bg);
        color: var(--red);
        font-size: 11px;
        font-weight: 700;
    }


    /* =========================================================
       DELIVERY
    ========================================================= */

    .delivery-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 25px;
    }

    .delivery-card {
        padding: 14px 16px;
        border: 1px solid var(--orders-border);
        border-radius: 10px;
        background: white;
    }

    .delivery-label {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 6px;
        color: var(--orders-muted);
        font-size: 9px;
        font-weight: 900;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .delivery-label i {
        color: var(--orders-gold);
    }

    .delivery-value {
        color: var(--orders-dark);
        font-size: 12px;
        line-height: 1.5;
        word-break: break-word;
    }


    /* =========================================================
       ITEMS
    ========================================================= */

    .items-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .items-title strong {
        color: var(--orders-dark);
        font-size: 12px;
    }

    .items-count {
        color: var(--orders-muted);
        font-size: 10px;
    }

    .items {
        border-top: 1px solid var(--orders-border);
    }

    .item {
        display: grid;
        grid-template-columns: 56px minmax(0, 1fr) auto;
        gap: 14px;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px solid var(--orders-border);
    }

    .item:last-child {
        border-bottom: 0;
    }

    .item-image {
        width: 56px;
        height: 54px;
        overflow: hidden;
        border-radius: 9px;
        background: #eee9e1;
    }

    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #a8a29e;
        font-size: 21px;
    }

    .item-info {
        min-width: 0;
    }

    .item-name {
        margin-bottom: 4px;
        color: var(--orders-dark);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 15px;
        font-weight: 700;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .item-meta {
        color: var(--orders-muted);
        font-size: 10px;
    }

    .item-price {
        color: var(--orders-dark);
        font-size: 13px;
        font-weight: 900;
        white-space: nowrap;
    }


    /* =========================================================
       FOOTER
    ========================================================= */

    .order-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        padding: 18px 24px;
        border-top: 1px solid var(--orders-border);
        background: #faf9f7;
    }

    .payment-area {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .payment-note {
        color: var(--orders-muted);
        font-size: 10px;
    }

    .pay-now-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 38px;
        padding: 0 15px;
        border: 0;
        border-radius: 8px;
        background: linear-gradient(
            135deg,
            #f59e0b,
            #d97706
        );
        color: #1c1917;
        font-size: 11px;
        font-weight: 900;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(245, 158, 11, .18);
        transition:
            transform .2s ease,
            box-shadow .2s ease,
            filter .2s ease;
    }

    .pay-now-btn:hover {
        color: #1c1917;
        transform: translateY(-2px);
        filter: brightness(1.05);
        box-shadow: 0 8px 20px rgba(245, 158, 11, .25);
    }

    .paid-label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 12px;
        border-radius: 8px;
        background: var(--green-bg);
        color: var(--green);
        font-size: 10px;
        font-weight: 900;
    }

    .payment-failed-label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 12px;
        border-radius: 8px;
        background: var(--red-bg);
        color: var(--red);
        font-size: 10px;
        font-weight: 900;
    }

    .total-area {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    .total-label {
        color: var(--orders-muted);
        font-size: 10px;
        font-weight: 700;
    }

    .order-total {
        color: var(--orders-gold);
        font-size: 22px;
        font-weight: 900;
    }


    /* =========================================================
       EMPTY
    ========================================================= */

    .empty {
        padding: 80px 25px;
        background: white;
        border: 1px solid var(--orders-border);
        border-radius: 16px;
        text-align: center;
    }

    .empty-icon {
        width: 90px;
        height: 90px;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #f5eee4;
        font-size: 40px;
    }

    .empty h2 {
        margin: 0 0 8px;
        color: var(--orders-dark);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 28px;
    }

    .empty p {
        max-width: 420px;
        margin: 0 auto 23px;
        color: var(--orders-muted);
        font-size: 13px;
        line-height: 1.7;
    }

    .menu-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 0 20px;
        border-radius: 8px;
        background: var(--orders-dark);
        color: white;
        font-size: 12px;
        font-weight: 900;
        text-decoration: none;
        transition: .25s ease;
    }

    .menu-btn:hover {
        background: var(--orders-gold);
        color: white;
        transform: translateY(-2px);
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 800px) {

        .orders-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .order-food-btn {
            width: 100%;
        }

        .tracking {
            grid-template-columns: repeat(5, minmax(65px, 1fr));
            overflow-x: auto;
        }

        .tracking-step {
            min-width: 70px;
        }
    }


    @media (max-width: 650px) {

        .orders-header h1 {
            font-size: 32px;
        }

        .order-top {
            padding: 18px;
            align-items: flex-start;
            flex-direction: column;
        }

        .order-header-right {
            justify-content: flex-start;
        }

        .order-body {
            padding: 18px;
        }

        .delivery-section {
            grid-template-columns: 1fr;
        }

        .order-footer {
            align-items: flex-start;
            flex-direction: column;
        }

        .payment-area {
            width: 100%;
        }

        .pay-now-btn {
            width: 100%;
        }

        .total-area {
            width: 100%;
            justify-content: space-between;
        }
    }


    @media (max-width: 450px) {

        .order-card {
            border-radius: 12px;
        }

        .item {
            grid-template-columns: 48px minmax(0, 1fr);
        }

        .item-image {
            width: 48px;
            height: 46px;
        }

        .item-price {
            grid-column: 2;
            margin-top: -4px;
        }

        .tracking-section {
            padding: 13px;
        }

        .tracking-label {
            font-size: 8px;
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

            <div class="orders-eyebrow">
                Your dining history
            </div>

            <h1>
                My Orders
            </h1>

            <p>
                Track your food, payment and delivery status in one place.
            </p>

        </div>

        <a
            href="{{ route('user.menu') }}"
            class="order-food-btn"
        >
            <span>ðŸ½ï¸</span>
            Order Food
        </a>

    </div>


    {{-- =====================================================
         SUCCESS MESSAGE
    ====================================================== --}}

    @if(session('success'))

        <div class="alert alert-success">

            <div class="alert-icon">
                âœ“
            </div>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    {{-- =====================================================
         ERROR MESSAGE
    ====================================================== --}}

    @if(session('error'))

        <div class="alert alert-error">

            <div class="alert-icon">
                !
            </div>

            <span>
                {{ session('error') }}
            </span>

        </div>

    @endif


    {{-- =====================================================
         ORDERS
    ====================================================== --}}

    @if($orders->count() > 0)

        @foreach($orders as $order)

            @php

                /*
                |--------------------------------------------------------------------------
                | ORDER STATUS
                |--------------------------------------------------------------------------
                */

                $currentStatus = strtolower(
                    trim((string) $order->status)
                );

                $statusClass = match ($currentStatus) {

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
                        => 'status-default',
                };


                /*
                |--------------------------------------------------------------------------
                | PAYMENT STATUS
                |--------------------------------------------------------------------------
                */

                $paymentStatus = strtolower(
                    trim((string) ($order->payment_status ?? 'unpaid'))
                );

$paymentClass = match ($paymentStatus) {

                    'paid'
                        => 'payment-paid',

                    'pending'
                        => 'payment-pending',

                    'failed'
                        => 'payment-failed',

                    default
                        => 'payment-unpaid',
                };


                /*
                |--------------------------------------------------------------------------
                | TRACKING
                |--------------------------------------------------------------------------
                */

                $trackingStatuses = [
                    'pending',
                    'confirmed',
                    'preparing',
                    'out_for_delivery',
                    'completed',
                ];

                $currentIndex = array_search(
                    $currentStatus,
                    $trackingStatuses,
                    true
                );

                if ($currentIndex === false) {
                    $currentIndex = -1;
                }


                /*
                |--------------------------------------------------------------------------
                | TRACKING STEPS
                |--------------------------------------------------------------------------
                */

                $steps = [

                    [
                        'key' => 'pending',
                        'label' => 'Placed',
                        'icon' => 'ðŸ“',
                    ],

                    [
                        'key' => 'confirmed',
                        'label' => 'Confirmed',
                        'icon' => 'âœ“',
                    ],

                    [
                        'key' => 'preparing',
                        'label' => 'Preparing',
                        'icon' => 'ðŸ‘¨â€ðŸ³',
                    ],

                    [
                        'key' => 'out_for_delivery',
                        'label' => 'On the way',
                        'icon' => 'ðŸ›µ',
                    ],

                    [
                        'key' => 'completed',
                        'label' => 'Delivered',
                        'icon' => 'ðŸ½ï¸',
                    ],

                ];

            @endphp


            {{-- =================================================
                 ORDER CARD
            ================================================== --}}

            <div class="order-card">


                {{-- =================================================
                     ORDER HEADER
                ================================================== --}}

                <div class="order-top">

                    <div class="order-heading">

                        <div class="order-label">
                            Restaurant Order
                        </div>

                        <h2>
                            #{{ $order->id }}
                        </h2>

                        <div class="order-date">
                            {{ optional($order->created_at)->format('d M Y, h:i A') }}
                        </div>

                    </div>


                    <div class="order-header-right">

                        {{-- ORDER STATUS --}}

                        <span class="status {{ $statusClass }}">

                            <span class="status-dot"></span>

                            @if($currentStatus === 'out_for_delivery')

                                Out for Delivery

                            @else

                                {{ ucfirst(str_replace('_', ' ', $currentStatus)) }}

                            @endif

                        </span>


                        {{-- PAYMENT STATUS --}}

                        <span class="payment-status {{ $paymentClass }}">

                            @if($paymentStatus === 'paid')

                                âœ“ Paid

                            @elseif($paymentStatus === 'pending')

                                â—· Payment Pending

                            @elseif($paymentStatus === 'failed')

                                âœ• Payment Failed

                            @else

                                Payment Unpaid

                            @endif

                        </span>

                    </div>

                </div>


                {{-- =================================================
                     ORDER BODY
                ================================================== --}}

                <div class="order-body">


                    {{-- =================================================
                         ORDER TRACKING
                    ================================================== --}}

                    @if($currentStatus !== 'cancelled')

                        <div class="tracking-section">

                            <div class="tracking-title">

                                <strong>
                                    Order Progress
                                </strong>

                                <span>
                                    {{ ucfirst(str_replace('_', ' ', $currentStatus)) }}
                                </span>

                            </div>


                            <div class="tracking">

                                @foreach($steps as $index => $step)

                                    @php

                                        $stepActive =
                                            $currentIndex >= $index;

                                        $stepCurrent =
                                            $currentIndex === $index;

                                    @endphp

                                    <div
                                        class="
                                            tracking-step
                                            {{ $stepActive ? 'active' : '' }}
                                            {{ $stepCurrent ? 'current' : '' }}
                                        "
                                    >

                                        <div class="tracking-icon">
                                            {{ $step['icon'] }}
                                        </div>

                                        <span class="tracking-label">
                                            {{ $step['label'] }}
                                        </span>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    @else

                        <div class="cancelled-message">

                            <span>âœ•</span>

                            <span>
                                This order has been cancelled.
                            </span>

                        </div>

                    @endif


                    {{-- =================================================
                         DELIVERY INFORMATION
                    ================================================== --}}

                    <div class="delivery-section">

                        <div class="delivery-card">

                            <div class="delivery-label">

                                <i class="fa-solid fa-location-dot"></i>

                                Delivery Address

                            </div>

                            <div class="delivery-value">

                                {{ $order->address ?: 'Not provided' }}

                            </div>

                        </div>


                        <div class="delivery-card">

                            <div class="delivery-label">

                                <i class="fa-solid fa-phone"></i>

                                Contact Number

                            </div>

                            <div class="delivery-value">

                                {{ $order->phone ?: 'Not provided' }}

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         ORDER ITEMS
                    ================================================== --}}

                    <div class="items-title">

                        <strong>
                            Order Items
                        </strong>

                        <span class="items-count">

                            {{ $order->items->sum('quantity') }}

                            {{ $order->items->sum('quantity') == 1 ? 'item' : 'items' }}

                        </span>

                    </div>


                    <div class="items">

                        @foreach($order->items as $item)

                            @php

                                $menuItem = $item->menuItem;

                                $imagePath = null;

                                if ($menuItem && $menuItem->image) {

                                    $storedImage = ltrim(
                                        $menuItem->image,
                                        '/'
                                    );

                                    if (
                                        str_starts_with(
                                            $storedImage,
                                            'storage/'
                                        )
                                    ) {

                                        $imagePath = asset(
                                            $storedImage
                                        );

                                    } else {

                                        $imagePath = asset(
                                            'storage/' . $storedImage
                                        );
                                    }
                                }

                            @endphp


                            <div class="item">


                                {{-- IMAGE --}}

                                <div class="item-image">

                                    @if($imagePath)

                                        <img
                                            src="{{ $imagePath }}"
                                            alt="{{ $menuItem->name ?? 'Food item' }}"
                                            loading="lazy"
                                            onerror="
                                                this.style.display='none';

                                                const placeholder =
                                                    this.parentElement.querySelector('.item-placeholder');

                                                if (placeholder) {
                                                    placeholder.style.display='flex';
                                                }
                                            "
                                        >

                                        <div
                                            class="item-placeholder"
                                            style="display:none;"
                                        >
                                            ðŸ½ï¸
                                        </div>

                                    @else

                                        <div class="item-placeholder">
                                            ðŸ½ï¸
                                        </div>

                                    @endif

                                </div>


                                {{-- INFO --}}

                                <div class="item-info">

                                    <div class="item-name">

                                        {{ $menuItem->name ?? 'Menu Item' }}

                                    </div>

                                    <div class="item-meta">

                                        â‚¹{{ number_format((float) $item->price, 2) }}

                                        Ã—

                                        {{ $item->quantity }}

                                    </div>

                                </div>


                                {{-- ITEM TOTAL --}}

                                <div class="item-price">

                                    â‚¹{{ number_format(
                                        (float) $item->price *
                                        (int) $item->quantity,
                                        2
                                    ) }}

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>


                {{-- =================================================
                     FOOTER
                ================================================== --}}

                <div class="order-footer">


                    {{-- =================================================
                         PAYMENT AREA
                    ================================================== --}}

                    <div class="payment-area">


                        {{-- =================================================
                             PAID
                        ================================================== --}}

                        @if($paymentStatus === 'paid')

                            <div class="paid-label">

                                âœ“ Payment Successful

                            </div>

                            @if(!empty($order->payment_id))

                                <span class="payment-note">

                                    Payment ID:
                                    {{ $order->payment_id }}

                                </span>

                            @endif


                        {{-- =================================================
                             PENDING
                        ================================================== --}}

                        @elseif($paymentStatus === 'pending')

                            <span class="payment-note">

                                â—· Payment is pending

                            </span>

                            @if(
                                $currentStatus !== 'cancelled' &&
                                $currentStatus !== 'completed'
                            )

                                <form
                                    action="{{ route('payment.cashfree.create') }}"
                                    method="POST"
                                >

                                    @csrf

                                    <input
                                        type="hidden"
                                        name="order_id"
                                        value="{{ $order->id }}"
                                    >

                                    <button
                                        type="submit"
                                        class="pay-now-btn"
                                    >

                                        <span>ðŸ’³</span>

                                        Check / Pay Again

                                    </button>

                                </form>

                            @endif


                        {{-- =================================================
                             FAILED / UNPAID
                        ================================================== --}}

                        @elseif(
                            $paymentStatus === 'failed' ||
                            $paymentStatus === 'unpaid'
                        )

                            @if(
                                $currentStatus !== 'cancelled' &&
                                $currentStatus !== 'completed'
                            )

                                <form
                                    action="{{ route('payment.cashfree.create') }}"
                                    method="POST"
                                >

                                    @csrf

                                    <input
                                        type="hidden"
                                        name="order_id"
                                        value="{{ $order->id }}"
                                    >

                                    <button
                                        type="submit"
                                        class="pay-now-btn"
                                    >

                                        <span>ðŸ’³</span>

                                        Pay Now

                                    </button>

                                </form>

                            @else

                                <span class="payment-failed-label">

                                    Payment not completed

                                </span>

                            @endif

                        @endif

                    </div>


                    {{-- =================================================
                         TOTAL
                    ================================================== --}}

                    <div class="total-area">

                        <span class="total-label">
                            Order Total
                        </span>

                        <span class="order-total">

                            â‚¹{{ number_format(
                                (float) $order->total_amount,
                                2
                            ) }}

                        </span>

                    </div>

                </div>

            </div>

        @endforeach


    @else


        {{-- =================================================
             EMPTY STATE
        ================================================== --}}

        <div class="empty">

            <div class="empty-icon">
                ðŸ“¦
            </div>

            <h2>
                No orders yet
            </h2>

            <p>
                You haven't placed an order yet.
                Explore our menu and discover something delicious
                from BenStoke.
            </p>

            <a
                href="{{ route('user.menu') }}"
                class="menu-btn"
            >
                Browse Our Menu â†’
            </a>

        </div>

    @endif

</div>

@endsection 

