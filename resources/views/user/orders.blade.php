@extends('layouts.user')

@section('title', 'My Orders')

@section('styles')

<style>
    :root {
        --orders-dark: #1c1917;
        --orders-text: #292524;
        --orders-muted: #78716c;
        --orders-gold: #b7791f;
        --orders-gold-light: #fbf3e5;
        --orders-border: #e7e2da;
        --orders-bg: #f7f5f1;
        --orders-green: #15803d;
        --orders-red: #b91c1c;
    }

    .orders-page {
        color: var(--orders-text);
    }

    /* HEADER */

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 20px;
        margin-bottom: 28px;
    }

    .page-eyebrow {
        color: var(--orders-gold);
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 11px;
        font-weight: 800;
        margin-bottom: 7px;
    }

    .page-header h1 {
        margin: 0 0 7px;
        color: var(--orders-dark);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 38px;
        line-height: 1.1;
    }

    .page-header p {
        margin: 0;
        color: var(--orders-muted);
        font-size: 14px;
    }

    .order-food-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 17px;
        border-radius: 8px;
        background: var(--orders-dark);
        color: white;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
        transition: .25s ease;
    }

    .order-food-btn:hover {
        background: var(--orders-gold);
        color: white;
        transform: translateY(-2px);
    }

    /* SUCCESS */

    .success-message {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 22px;
        padding: 14px 16px;
        border: 1px solid #bbf7d0;
        border-radius: 9px;
        background: #f0fdf4;
        color: #166534;
        font-size: 13px;
        font-weight: 600;
    }

    /* ORDER CARD */

    .order-card {
        margin-bottom: 20px;
        background: white;
        border: 1px solid var(--orders-border);
        border-radius: 14px;
        overflow: hidden;
        transition: .25s ease;
    }

    .order-card:hover {
        border-color: #d7c7ae;
        box-shadow: 0 8px 25px rgba(28,25,23,.07);
    }

    /* ORDER TOP */

    .order-top {
        padding: 20px 23px;
        background: #faf9f7;
        border-bottom: 1px solid var(--orders-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .order-heading {
        min-width: 0;
    }

    .order-label {
        color: var(--orders-gold);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-size: 9px;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .order-heading h2 {
        margin: 0 0 5px;
        color: var(--orders-dark);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 21px;
    }

    .order-date {
        color: var(--orders-muted);
        font-size: 11px;
    }

    /* STATUS */

    .status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 11px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .5px;
        white-space: nowrap;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-pending {
        background: #fff7df;
        color: #a16207;
    }

    .status-confirmed {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .status-completed {
        background: #f0fdf4;
        color: #15803d;
    }

    .status-cancelled {
        background: #fef2f2;
        color: #b91c1c;
    }

    .status-default {
        background: #f5f5f4;
        color: #57534e;
    }

    /* ORDER BODY */

    .order-body {
        padding: 22px 23px;
    }

    /* DELIVERY INFO */

    .delivery-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 22px;
    }

    .delivery-card {
        padding: 13px 15px;
        border: 1px solid var(--orders-border);
        border-radius: 9px;
        background: #fff;
    }

    .delivery-label {
        color: var(--orders-muted);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 9px;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .delivery-value {
        color: var(--orders-dark);
        font-size: 12px;
        line-height: 1.5;
        word-break: break-word;
    }

    /* ITEMS */

    .items-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 9px;
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
        grid-template-columns: 52px minmax(0, 1fr) auto;
        gap: 13px;
        align-items: center;
        padding: 13px 0;
        border-bottom: 1px solid var(--orders-border);
    }

    .item:last-child {
        border-bottom: 0;
    }

    .item-image {
        width: 52px;
        height: 50px;
        overflow: hidden;
        border-radius: 8px;
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
        font-size: 22px;
    }

    .item-info {
        min-width: 0;
    }

    .item-name {
        margin-bottom: 3px;
        color: var(--orders-dark);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 15px;
        font-weight: 700;
    }

    .item-meta {
        color: var(--orders-muted);
        font-size: 10px;
    }

    .item-price {
        color: var(--orders-dark);
        font-size: 13px;
        font-weight: 800;
        white-space: nowrap;
    }

    /* FOOTER */

    .order-footer {
        padding: 18px 23px;
        border-top: 1px solid var(--orders-border);
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 20px;
    }

    .total-label {
        color: var(--orders-muted);
        font-size: 11px;
    }

    .order-total {
        color: var(--orders-gold);
        font-size: 22px;
        font-weight: 900;
    }

    /* EMPTY */

    .empty {
        padding: 75px 25px;
        background: white;
        border: 1px solid var(--orders-border);
        border-radius: 14px;
        text-align: center;
    }

    .empty-icon {
        width: 90px;
        height: 90px;
        margin: 0 auto 20px;
        border-radius: 50%;
        background: #f5eee4;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 42px;
    }

    .empty h2 {
        margin: 0 0 8px;
        color: var(--orders-dark);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 27px;
    }

    .empty p {
        margin: 0 auto 23px;
        max-width: 420px;
        color: var(--orders-muted);
        font-size: 13px;
        line-height: 1.6;
    }

    .menu-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 45px;
        padding: 0 20px;
        border-radius: 8px;
        background: var(--orders-dark);
        color: white;
        font-size: 12px;
        font-weight: 800;
        transition: .25s ease;
    }

    .menu-btn:hover {
        background: var(--orders-gold);
        color: white;
        transform: translateY(-2px);
    }

    /* RESPONSIVE */

    @media (max-width: 700px) {

        .page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .page-header h1 {
            font-size: 32px;
        }

        .order-food-btn {
            width: 100%;
            justify-content: center;
        }

        .order-top {
            padding: 18px;
            align-items: flex-start;
        }

        .order-body {
            padding: 18px;
        }

        .order-footer {
            padding: 17px 18px;
        }

        .delivery-section {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {

        .order-top {
            flex-direction: column;
            gap: 13px;
        }

        .status {
            align-self: flex-start;
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
            margin-top: -5px;
        }

        .order-footer {
            justify-content: space-between;
        }

        .order-total {
            font-size: 20px;
        }
    }
</style>

@endsection


@section('content')

<div class="orders-page">

    {{-- PAGE HEADER --}}

    <div class="page-header">

        <div>

            <div class="page-eyebrow">
                Your dining history
            </div>

            <h1>
                📦 My Orders
            </h1>

            <p>
                Track and review your previous restaurant orders.
            </p>

        </div>


        <a
            href="{{ route('user.menu') }}"
            class="order-food-btn"
        >
            🍽️ Order Food
        </a>

    </div>


    {{-- SUCCESS MESSAGE --}}

    @if(session('success'))

        <div class="success-message">
            <span>✓</span>
            <span>{{ session('success') }}</span>
        </div>

    @endif


    {{-- ORDERS --}}

    @if($orders->count() > 0)

        @foreach($orders as $order)

            <div class="order-card">

                {{-- ORDER HEADER --}}

                <div class="order-top">

                    <div class="order-heading">

                        <div class="order-label">
                            Order
                        </div>

                        <h2>
                            #{{ $order->id }}
                        </h2>

                        <div class="order-date">
                            {{ $order->created_at->format('d M Y, h:i A') }}
                        </div>

                    </div>


                    @php
                        $statusClass = match(strtolower($order->status)) {
                            'pending' => 'status-pending',
                            'confirmed' => 'status-confirmed',
                            'completed' => 'status-completed',
                            'cancelled' => 'status-cancelled',
                            default => 'status-default',
                        };
                    @endphp


                    <span class="status {{ $statusClass }}">

                        <span class="status-dot"></span>

                        {{ ucfirst($order->status) }}

                    </span>

                </div>


                {{-- ORDER BODY --}}

                <div class="order-body">


                    {{-- DELIVERY INFORMATION --}}

                    <div class="delivery-section">

                        <div class="delivery-card">

                            <div class="delivery-label">
                                Delivery Address
                            </div>

                            <div class="delivery-value">
                                {{ $order->address }}
                            </div>

                        </div>


                        <div class="delivery-card">

                            <div class="delivery-label">
                                Contact Number
                            </div>

                            <div class="delivery-value">
                                {{ $order->phone }}
                            </div>

                        </div>

                    </div>


                    {{-- ITEMS --}}

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

                                $imagePath = $menuItem && $menuItem->image
                                    ? 'storage/' . ltrim($menuItem->image, '/')
                                    : null;

                            @endphp


                            <div class="item">


                                {{-- IMAGE --}}

                                <div class="item-image">

                                    @if($imagePath)

                                        <img
                                            src="{{ asset($imagePath) }}"
                                            alt="{{ $menuItem->name ?? 'Food item' }}"
                                            loading="lazy"
                                            onerror="
                                                this.style.display='none';
                                                this.parentElement
                                                    .querySelector('.item-placeholder')
                                                    .style.display='flex';
                                            "
                                        >

                                        <div
                                            class="item-placeholder"
                                            style="display:none;"
                                        >
                                            🍽️
                                        </div>

                                    @else

                                        <div class="item-placeholder">
                                            🍽️
                                        </div>

                                    @endif

                                </div>


                                {{-- INFO --}}

                                <div class="item-info">

                                    <div class="item-name">
                                        {{ $menuItem->name ?? 'Menu Item' }}
                                    </div>

                                    <div class="item-meta">
                                        ₹{{ number_format((float) $item->price, 2) }}
                                        × {{ $item->quantity }}
                                    </div>

                                </div>


                                {{-- ITEM TOTAL --}}

                                <div class="item-price">

                                    ₹{{ number_format(
                                        (float) $item->price * (int) $item->quantity,
                                        2
                                    ) }}

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>


                {{-- ORDER TOTAL --}}

                <div class="order-footer">

                    <span class="total-label">
                        Order Total
                    </span>

                    <span class="order-total">
                        ₹{{ number_format(
                            (float) $order->total_amount,
                            2
                        ) }}
                    </span>

                </div>

            </div>

        @endforeach


    @else

        {{-- EMPTY STATE --}}

        <div class="empty">

            <div class="empty-icon">
                📦
            </div>

            <h2>
                No orders yet
            </h2>

            <p>
                You haven't placed an order yet.
                Explore our menu and discover something delicious.
            </p>

            <a
                href="{{ route('user.menu') }}"
                class="menu-btn"
            >
                Browse Our Menu →
            </a>

        </div>

    @endif

</div>

@endsection

