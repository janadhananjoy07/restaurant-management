@extends('layouts.user')

@section('title', 'My Cart')

@section('styles')

<style>
    :root {
        --cart-dark: #1c1917;
        --cart-text: #292524;
        --cart-muted: #78716c;
        --cart-gold: #b7791f;
        --cart-gold-light: #fbf3e5;
        --cart-border: #e7e2da;
        --cart-bg: #f7f5f1;
        --cart-danger: #b91c1c;
        --cart-green: #15803d;
    }

    .cart-page {
        color: var(--cart-text);
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
        color: var(--cart-gold);
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 11px;
        font-weight: 800;
        margin-bottom: 7px;
    }

    .page-header h1 {
        margin: 0 0 7px;
        color: var(--cart-dark);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 38px;
        line-height: 1.1;
    }

    .page-header p {
        margin: 0;
        color: var(--cart-muted);
        font-size: 14px;
    }

    .back-menu-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 17px;
        border: 1px solid var(--cart-border);
        border-radius: 8px;
        background: white;
        color: var(--cart-dark);
        font-size: 13px;
        font-weight: 700;
        transition: .25s ease;
        white-space: nowrap;
    }

    .back-menu-btn:hover {
        border-color: var(--cart-gold);
        color: var(--cart-gold);
        transform: translateY(-2px);
    }

    /* ALERT */

    .alert {
        padding: 13px 16px;
        margin-bottom: 22px;
        border-radius: 9px;
        font-size: 14px;
    }

    .alert-error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    /* CART LAYOUT */

    .cart-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 340px;
        gap: 25px;
        align-items: start;
    }

    .cart-box {
        background: white;
        border: 1px solid var(--cart-border);
        border-radius: 14px;
        overflow: hidden;
    }

    /* CART HEADER */

    .cart-box-header {
        padding: 20px 22px;
        border-bottom: 1px solid var(--cart-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .cart-box-header h2 {
        margin: 0;
        color: var(--cart-dark);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 22px;
    }

    .cart-count {
        background: var(--cart-gold-light);
        color: var(--cart-gold);
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
    }

    /* CART ITEM */

    .cart-item {
        padding: 20px 22px;
        display: grid;
        grid-template-columns: 85px minmax(0, 1fr) auto;
        gap: 18px;
        align-items: center;
        border-bottom: 1px solid var(--cart-border);
    }

    .cart-item:last-child {
        border-bottom: 0;
    }

    .item-image {
        width: 85px;
        height: 75px;
        border-radius: 9px;
        overflow: hidden;
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
        font-size: 30px;
    }

    .item-info {
        min-width: 0;
    }

    .item-category {
        color: var(--cart-gold);
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 4px;
    }

    .item-name {
        color: var(--cart-dark);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .item-price {
        color: var(--cart-muted);
        font-size: 12px;
    }

    .item-controls {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quantity-form {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .quantity-input {
        width: 62px;
        height: 38px;
        padding: 5px 8px;
        text-align: center;
        border: 1px solid #d6d3d1;
        border-radius: 7px;
        background: #fafaf9;
        color: var(--cart-dark);
        font-size: 13px;
        font-weight: 700;
        outline: none;
    }

    .quantity-input:focus {
        border-color: var(--cart-gold);
        box-shadow: 0 0 0 3px rgba(183,121,31,.10);
    }

    .update-btn {
        height: 38px;
        padding: 0 12px;
        border: 0;
        border-radius: 7px;
        background: #292524;
        color: white;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s ease;
    }

    .update-btn:hover {
        background: var(--cart-gold);
    }

    .item-subtotal {
        min-width: 95px;
        text-align: right;
        color: var(--cart-dark);
        font-size: 16px;
        font-weight: 800;
    }

    .remove-form {
        margin-top: 7px;
        text-align: right;
    }

    .remove-btn {
        padding: 0;
        border: 0;
        background: transparent;
        color: #a8a29e;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        transition: .2s ease;
    }

    .remove-btn:hover {
        color: var(--cart-danger);
    }

    /* ORDER SUMMARY */

    .summary-box {
        background: var(--cart-dark);
        color: white;
        border-radius: 14px;
        padding: 24px;
        position: sticky;
        top: 95px;
    }

    .summary-label {
        color: #d6a85f;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 10px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .summary-box h2 {
        margin: 0 0 23px;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 25px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        padding: 11px 0;
        border-bottom: 1px solid rgba(255,255,255,.09);
        color: #cfc8be;
        font-size: 13px;
    }

    .summary-row:last-of-type {
        border-bottom: 0;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 20px 0 5px;
    }

    .summary-total span:first-child {
        color: white;
        font-size: 15px;
        font-weight: 700;
    }

    .summary-total span:last-child {
        color: #efc982;
        font-size: 24px;
        font-weight: 800;
    }

    .checkout-btn {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        min-height: 48px;
        margin-top: 18px;
        padding: 12px 15px;
        border-radius: 8px;
        background: #d6a85f;
        color: #1c1917;
        font-size: 13px;
        font-weight: 800;
        transition: .25s ease;
    }

    .checkout-btn:hover {
        background: #efc982;
        transform: translateY(-2px);
        color: #1c1917;
    }

    .summary-note {
        text-align: center;
        margin-top: 13px;
        color: #9f978d;
        font-size: 10px;
        line-height: 1.5;
    }

    /* CONTINUE SHOPPING */

    .continue-shopping {
        display: block;
        margin-top: 17px;
        text-align: center;
        color: #b7afa5;
        font-size: 12px;
        font-weight: 600;
        transition: .2s;
    }

    .continue-shopping:hover {
        color: #efc982;
    }

    /* EMPTY CART */

    .empty-cart {
        background: white;
        border: 1px solid var(--cart-border);
        border-radius: 14px;
        padding: 75px 25px;
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

    .empty-cart h2 {
        margin: 0 0 8px;
        color: var(--cart-dark);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 27px;
    }

    .empty-cart p {
        margin: 0 auto 23px;
        color: var(--cart-muted);
        font-size: 14px;
    }

    .menu-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 45px;
        padding: 0 20px;
        border-radius: 8px;
        background: var(--cart-dark);
        color: white;
        font-size: 13px;
        font-weight: 700;
        transition: .25s;
    }

    .menu-btn:hover {
        background: var(--cart-gold);
        color: white;
        transform: translateY(-2px);
    }

    /* RESPONSIVE */

    @media (max-width: 1000px) {
        .cart-layout {
            grid-template-columns: 1fr;
        }

        .summary-box {
            position: static;
        }
    }

    @media (max-width: 700px) {

        .page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .page-header h1 {
            font-size: 32px;
        }

        .back-menu-btn {
            width: 100%;
            justify-content: center;
        }

        .cart-item {
            grid-template-columns: 70px minmax(0, 1fr);
            gap: 13px;
            padding: 17px;
        }

        .item-image {
            width: 70px;
            height: 70px;
        }

        .item-controls {
            grid-column: 1 / -1;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 10px;
            padding-top: 5px;
        }

        .quantity-form {
            justify-content: flex-start;
        }

        .item-subtotal {
            text-align: right;
        }

        .remove-form {
            text-align: left;
        }

        .summary-box {
            padding: 21px;
        }
    }

    @media (max-width: 430px) {

        .cart-box-header {
            padding: 17px;
        }

        .cart-box-header h2 {
            font-size: 19px;
        }

        .quantity-form {
            flex-wrap: wrap;
        }

        .quantity-input {
            width: 58px;
        }

        .update-btn {
            padding: 0 9px;
        }

        .item-name {
            font-size: 17px;
        }

        .summary-total span:last-child {
            font-size: 21px;
        }
    }
</style>

@endsection


@section('content')

<div class="cart-page">

    {{-- PAGE HEADER --}}

    <div class="page-header">

        <div>

            <div class="page-eyebrow">
                Your selection
            </div>

            <h1>
                🛒 My Cart
            </h1>

            <p>
                Review your items before placing your order.
            </p>

        </div>

        <a
            href="{{ route('user.menu') }}"
            class="back-menu-btn"
        >
            ← Continue Shopping
        </a>

    </div>


    {{-- ERROR MESSAGE --}}

    @if(session('error'))

        <div class="alert alert-error">
            ⚠️ {{ session('error') }}
        </div>

    @endif


    {{-- CART HAS ITEMS --}}

    @if($cartItems->count() > 0)

        <div class="cart-layout">

            {{-- CART ITEMS --}}

            <div class="cart-box">

                <div class="cart-box-header">

                    <h2>
                        Your Order
                    </h2>

                    <span class="cart-count">
                        {{ $cartItems->sum('quantity') }}
                        {{ $cartItems->sum('quantity') == 1 ? 'item' : 'items' }}
                    </span>

                </div>


                @foreach($cartItems as $item)

                    @php
                        $menuItem = $item->menuItem;

                        $imagePath = $menuItem && $menuItem->image
                            ? 'storage/' . ltrim($menuItem->image, '/')
                            : null;
                    @endphp


                    <div class="cart-item">

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


                        {{-- INFORMATION --}}

                        <div class="item-info">

                            @if($menuItem && $menuItem->category)

                                <div class="item-category">
                                    {{ $menuItem->category }}
                                </div>

                            @endif

                            <div class="item-name">
                                {{ $menuItem->name ?? 'Menu Item' }}
                            </div>

                            <div class="item-price">
                                ₹{{ number_format((float) $item->price, 2) }}
                                per item
                            </div>

                        </div>


                        {{-- CONTROLS + SUBTOTAL --}}

                        <div class="item-controls">

                            <form
                                action="{{ route('user.cart.update', $item->id) }}"
                                method="POST"
                                class="quantity-form"
                            >

                                @csrf

                                @method('PUT')

                                <input
                                    type="number"
                                    name="quantity"
                                    value="{{ $item->quantity }}"
                                    min="1"
                                    max="99"
                                    class="quantity-input"
                                    aria-label="Quantity"
                                >

                                <button
                                    type="submit"
                                    class="update-btn"
                                >
                                    Update
                                </button>

                            </form>


                            <div>

                                <div class="item-subtotal">
                                    ₹{{ number_format(
                                        (float) $item->price * (int) $item->quantity,
                                        2
                                    ) }}
                                </div>


                                <form
                                    action="{{ route('user.cart.remove', $item->id) }}"
                                    method="POST"
                                    class="remove-form"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="remove-btn"
                                        onclick="return confirm('Remove this item from your cart?')"
                                    >
                                        Remove item
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- ORDER SUMMARY --}}

            <aside class="summary-box">

                <div class="summary-label">
                    Order Summary
                </div>

                <h2>
                    Your Total
                </h2>


                <div class="summary-row">

                    <span>
                        Items
                    </span>

                    <span>
                        {{ $cartItems->sum('quantity') }}
                    </span>

                </div>


                <div class="summary-row">

                    <span>
                        Subtotal
                    </span>

                    <span>
                        ₹{{ number_format((float) $total, 2) }}
                    </span>

                </div>


                <div class="summary-row">

                    <span>
                        Preparation
                    </span>

                    <span>
                        Included
                    </span>

                </div>


                <div class="summary-total">

                    <span>
                        Total
                    </span>

                    <span>
                        ₹{{ number_format((float) $total, 2) }}
                    </span>

                </div>


                <a
                    href="{{ route('user.checkout') }}"
                    class="checkout-btn"
                >
                    Proceed to Checkout →
                </a>


                <div class="summary-note">
                    Your final order details will be confirmed
                    on the checkout page.
                </div>


                <a
                    href="{{ route('user.menu') }}"
                    class="continue-shopping"
                >
                    ← Add more items
                </a>

            </aside>

        </div>


    @else

        {{-- EMPTY CART --}}

        <div class="empty-cart">

            <div class="empty-icon">
                🛒
            </div>

            <h2>
                Your cart is empty
            </h2>

            <p>
                Looks like you haven't added anything yet.
                Explore our menu and find something delicious.
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
