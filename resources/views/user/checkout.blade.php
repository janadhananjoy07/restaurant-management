@extends('layouts.user')

@section('title', 'Checkout')

@section('styles')

<style>
    :root {
        --checkout-dark: #1c1917;
        --checkout-text: #292524;
        --checkout-muted: #78716c;
        --checkout-gold: #b7791f;
        --checkout-gold-light: #fbf3e5;
        --checkout-border: #e7e2da;
        --checkout-green: #15803d;
        --checkout-red: #b91c1c;
        --checkout-blue: #1d4ed8;
        --checkout-blue-light: #eff6ff;
        --checkout-bg: #f7f5f1;
    }

    .checkout-page {
        color: var(--checkout-text);
    }

    /* =========================================================
       HEADER
    ========================================================= */

    .checkout-header {
        margin-bottom: 28px;
    }

    .checkout-eyebrow {
        color: var(--checkout-gold);
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 11px;
        font-weight: 800;
        margin-bottom: 7px;
    }

    .checkout-header h1 {
        margin: 0 0 7px;
        color: var(--checkout-dark);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 38px;
        line-height: 1.1;
    }

    .checkout-header p {
        margin: 0;
        color: var(--checkout-muted);
        font-size: 14px;
    }

    /* =========================================================
       PROGRESS
    ========================================================= */

    .checkout-progress {
        display: flex;
        align-items: center;
        margin-bottom: 28px;
        max-width: 650px;
    }

    .progress-step {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--checkout-muted);
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .progress-step.active {
        color: var(--checkout-dark);
    }

    .progress-number {
        width: 27px;
        height: 27px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #e7e2da;
        color: #78716c;
        font-size: 11px;
        font-weight: 800;
    }

    .progress-step.active .progress-number {
        background: var(--checkout-dark);
        color: white;
    }

    .progress-line {
        flex: 1;
        height: 1px;
        background: var(--checkout-border);
        margin: 0 12px;
    }

    /* =========================================================
       GRID
    ========================================================= */

    .checkout-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.15fr) minmax(320px, .85fr);
        gap: 25px;
        align-items: start;
    }

    .checkout-box {
        background: white;
        border: 1px solid var(--checkout-border);
        border-radius: 14px;
        overflow: hidden;
    }

    .box-header {
        padding: 21px 23px;
        border-bottom: 1px solid var(--checkout-border);
    }

    .box-header h2 {
        margin: 0 0 5px;
        color: var(--checkout-dark);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 22px;
    }

    .box-header p {
        margin: 0;
        color: var(--checkout-muted);
        font-size: 12px;
    }

    .box-body {
        padding: 23px;
    }

    /* =========================================================
       ADDRESS SECTION
    ========================================================= */

    .address-section {
        margin-bottom: 24px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 16px;
        padding-bottom: 11px;
        border-bottom: 1px solid var(--checkout-border);
    }

    .section-title-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: var(--checkout-gold-light);
        font-size: 17px;
        flex-shrink: 0;
    }

    .section-title strong {
        display: block;
        color: var(--checkout-dark);
        font-size: 13px;
    }

    .section-title span {
        display: block;
        margin-top: 2px;
        color: var(--checkout-muted);
        font-size: 10px;
    }

    .address-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .address-grid .full-width {
        grid-column: 1 / -1;
    }

    /* =========================================================
       FORM
    ========================================================= */

    .form-group {
        margin-bottom: 0;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 4px;
        margin-bottom: 8px;
        color: var(--checkout-dark);
        font-size: 12px;
        font-weight: 800;
    }

    .required {
        color: var(--checkout-red);
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 12px 13px;
        border: 1px solid #d6d3d1;
        border-radius: 8px;
        background: #fafaf9;
        color: var(--checkout-text);
        font-family: inherit;
        font-size: 13px;
        outline: none;
        transition: .2s ease;
    }

    .form-group input {
        height: 45px;
    }

    .form-group textarea {
        min-height: 90px;
        resize: vertical;
        line-height: 1.5;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: var(--checkout-gold);
        background: white;
        box-shadow: 0 0 0 3px rgba(183,121,31,.10);
    }

    .form-group input.invalid,
    .form-group textarea.invalid {
        border-color: var(--checkout-red);
        background: #fffafa;
    }

    .field-help {
        margin-top: 6px;
        color: #a8a29e;
        font-size: 10px;
        line-height: 1.5;
    }

    .field-error {
        margin-top: 6px;
        color: var(--checkout-red);
        font-size: 11px;
    }

    /* =========================================================
       PHONE
    ========================================================= */

    .phone-wrapper {
        position: relative;
    }

    .phone-prefix {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--checkout-dark);
        font-size: 13px;
        font-weight: 700;
        pointer-events: none;
    }

    .phone-input {
        padding-left: 45px !important;
        letter-spacing: 1px;
    }

    .phone-counter {
        margin-top: 5px;
        color: var(--checkout-muted);
        font-size: 10px;
        text-align: right;
    }

    /* =========================================================
       LIVE LOCATION
    ========================================================= */

    .location-box {
        padding: 16px;
        margin-top: 22px;
        margin-bottom: 22px;
        border: 1px solid var(--checkout-border);
        border-radius: 10px;
        background: #fafaf9;
    }

    .location-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 12px;
    }

    .location-title {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .location-icon {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: var(--checkout-gold-light);
        font-size: 18px;
    }

    .location-title strong {
        display: block;
        color: var(--checkout-dark);
        font-size: 13px;
    }

    .location-title span {
        display: block;
        margin-top: 2px;
        color: var(--checkout-muted);
        font-size: 10px;
    }

    .location-btn {
        min-height: 38px;
        padding: 8px 12px;
        border: 1px solid var(--checkout-dark);
        border-radius: 7px;
        background: white;
        color: var(--checkout-dark);
        cursor: pointer;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
        transition: .2s ease;
    }

    .location-btn:hover {
        background: var(--checkout-dark);
        color: white;
    }

    .location-btn:disabled {
        opacity: .6;
        cursor: not-allowed;
    }

    .location-status {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 12px;
        border-radius: 7px;
        background: #f5f5f4;
        color: var(--checkout-muted);
        font-size: 10px;
        line-height: 1.5;
    }

    .location-status.success {
        background: #f0fdf4;
        color: #166534;
    }

    .location-status.error {
        background: #fef2f2;
        color: #991b1b;
    }

    .location-status.loading {
        background: var(--checkout-blue-light);
        color: var(--checkout-blue);
    }

    .location-coordinates {
        display: none;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: 10px;
    }

    .coordinate-card {
        padding: 9px 10px;
        border: 1px solid var(--checkout-border);
        border-radius: 7px;
        background: white;
    }

    .coordinate-label {
        color: var(--checkout-muted);
        text-transform: uppercase;
        font-size: 8px;
        font-weight: 800;
        letter-spacing: .7px;
        margin-bottom: 3px;
    }

    .coordinate-value {
        color: var(--checkout-dark);
        font-family: monospace;
        font-size: 10px;
        word-break: break-all;
    }

    .location-required {
        margin-top: 7px;
        color: var(--checkout-red);
        font-size: 10px;
        font-weight: 700;
    }

    /* =========================================================
       PAYMENT METHOD
    ========================================================= */

    .payment-section {
        margin-top: 25px;
    }

    .payment-options {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .payment-option {
        position: relative;
    }

    .payment-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .payment-card {
        display: flex;
        align-items: center;
        gap: 12px;
        min-height: 75px;
        padding: 13px 14px;
        border: 1px solid var(--checkout-border);
        border-radius: 10px;
        background: white;
        cursor: pointer;
        transition: .2s ease;
    }

    .payment-card:hover {
        border-color: #c7b28f;
        background: #fffdf9;
    }

    .payment-option input:checked + .payment-card {
        border-color: var(--checkout-gold);
        background: var(--checkout-gold-light);
        box-shadow: 0 0 0 2px rgba(183,121,31,.08);
    }

    .payment-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border-radius: 9px;
        background: #f5f5f4;
        font-size: 19px;
    }

    .payment-option input:checked + .payment-card .payment-icon {
        background: white;
    }

    .payment-info {
        min-width: 0;
    }

    .payment-info strong {
        display: block;
        color: var(--checkout-dark);
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 3px;
    }

    .payment-info span {
        display: block;
        color: var(--checkout-muted);
        font-size: 10px;
        line-height: 1.4;
    }

    .payment-check {
        margin-left: auto;
        color: var(--checkout-gold);
        font-size: 16px;
        opacity: 0;
    }

    .payment-option input:checked + .payment-card .payment-check {
        opacity: 1;
    }

    .online-payment-note {
        display: none;
        margin-top: 10px;
        padding: 11px 12px;
        border-radius: 8px;
        background: var(--checkout-blue-light);
        color: #1e40af;
        font-size: 10px;
        line-height: 1.5;
    }

    .online-payment-note.active {
        display: block;
    }

    /* =========================================================
       ORDER ITEMS
    ========================================================= */

    .food-row {
        display: grid;
        grid-template-columns: 58px minmax(0, 1fr) auto;
        gap: 13px;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid var(--checkout-border);
    }

    .food-row:first-child {
        padding-top: 0;
    }

    .food-row:last-child {
        border-bottom: 0;
    }

    .food-image {
        width: 58px;
        height: 55px;
        border-radius: 8px;
        overflow: hidden;
        background: #eee9e1;
    }

    .food-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .food-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
    }

    .food-info {
        min-width: 0;
    }

    .food-category {
        color: var(--checkout-gold);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 9px;
        font-weight: 800;
        margin-bottom: 3px;
    }

    .food-name {
        color: var(--checkout-dark);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 3px;
    }

    .food-quantity {
        color: var(--checkout-muted);
        font-size: 11px;
    }

    .food-price {
        color: var(--checkout-dark);
        font-size: 14px;
        font-weight: 800;
        white-space: nowrap;
    }

    /* =========================================================
       SUMMARY
    ========================================================= */

    .summary-divider {
        height: 1px;
        background: var(--checkout-border);
        margin: 18px 0;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        padding: 7px 0;
        color: var(--checkout-muted);
        font-size: 13px;
    }

    .summary-row strong {
        color: var(--checkout-text);
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding-top: 16px;
    }

    .summary-total span:first-child {
        color: var(--checkout-dark);
        font-size: 15px;
        font-weight: 800;
    }

    .summary-total span:last-child {
        color: var(--checkout-gold);
        font-size: 25px;
        font-weight: 900;
    }

    /* =========================================================
       PLACE ORDER
    ========================================================= */

    .place-btn {
        width: 100%;
        min-height: 50px;
        padding: 13px 18px;
        margin-top: 5px;
        border: 0;
        border-radius: 8px;
        background: var(--checkout-dark);
        color: white;
        cursor: pointer;
        font-size: 13px;
        font-weight: 800;
        transition: .25s ease;
    }

    .place-btn:hover {
        background: var(--checkout-gold);
        transform: translateY(-2px);
    }

    .place-btn:disabled {
        background: #a8a29e;
        cursor: not-allowed;
        transform: none;
    }

    .secure-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-top: 12px;
        color: #a8a29e;
        font-size: 10px;
        text-align: center;
        line-height: 1.5;
    }

    /* =========================================================
       BACK BUTTON
    ========================================================= */

    .back-cart {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-top: 17px;
        color: var(--checkout-muted);
        font-size: 12px;
        font-weight: 700;
        transition: .2s;
    }

    .back-cart:hover {
        color: var(--checkout-gold);
    }

    /* =========================================================
       DELIVERY INFO
    ========================================================= */

    .delivery-info {
        margin-top: 17px;
        padding: 14px;
        border-radius: 9px;
        background: var(--checkout-gold-light);
        border: 1px solid #f0dfc1;
    }

    .delivery-info strong {
        display: block;
        color: var(--checkout-dark);
        font-size: 12px;
        margin-bottom: 4px;
    }

    .delivery-info span {
        color: #85745e;
        font-size: 10px;
        line-height: 1.5;
    }

    /* =========================================================
       SERVER ERRORS
    ========================================================= */

    .server-errors {
        margin-bottom: 20px;
        padding: 14px 16px;
        border: 1px solid #fecaca;
        border-radius: 9px;
        background: #fef2f2;
        color: #991b1b;
        font-size: 12px;
    }

    .server-errors strong {
        display: block;
        margin-bottom: 7px;
    }

    .server-errors ul {
        margin: 0;
        padding-left: 18px;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 850px) {

        .checkout-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {

        .checkout-header h1 {
            font-size: 32px;
        }

        .checkout-progress {
            width: 100%;
        }

        .progress-step {
            font-size: 9px;
        }

        .progress-number {
            width: 24px;
            height: 24px;
        }

        .progress-line {
            margin: 0 7px;
        }

        .box-header,
        .box-body {
            padding: 18px;
        }

        .address-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .address-grid .full-width {
            grid-column: auto;
        }

        .payment-options {
            grid-template-columns: 1fr;
        }

        .food-row {
            grid-template-columns: 52px minmax(0, 1fr) auto;
            gap: 10px;
        }

        .food-image {
            width: 52px;
            height: 50px;
        }

        .food-name {
            font-size: 15px;
        }

        .food-price {
            font-size: 13px;
        }

        .location-header {
            flex-direction: column;
        }

        .location-btn {
            width: 100%;
        }
    }

    @media (max-width: 400px) {

        .progress-step span:last-child {
            display: none;
        }

        .checkout-header h1 {
            font-size: 29px;
        }

        .food-row {
            grid-template-columns: 48px minmax(0, 1fr);
        }

        .food-price {
            grid-column: 2;
            margin-top: -5px;
        }

        .location-coordinates {
            grid-template-columns: 1fr;
        }
    }
</style>

@endsection


@section('content')

<div class="checkout-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="checkout-header">

        <div class="checkout-eyebrow">
            Almost there
        </div>

        <h1>
            💳 Checkout
        </h1>

        <p>
            Confirm your delivery details, choose your payment method and place your order.
        </p>

    </div>


    {{-- =====================================================
         PROGRESS
    ====================================================== --}}

    <div class="checkout-progress">

        <div class="progress-step">

            <div class="progress-number">
                ✓
            </div>

            <span>
                Cart
            </span>

        </div>

        <div class="progress-line"></div>

        <div class="progress-step active">

            <div class="progress-number">
                2
            </div>

            <span>
                Checkout
            </span>

        </div>

        <div class="progress-line"></div>

        <div class="progress-step">

            <div class="progress-number">
                3
            </div>

            <span>
                Confirmation
            </span>

        </div>

    </div>


    {{-- =====================================================
         SERVER VALIDATION ERRORS
    ====================================================== --}}

    @if($errors->any())

        <div class="server-errors">

            <strong>
                Please correct the following:
            </strong>

            <ul>

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="checkout-grid">


        {{-- =================================================
             LEFT SIDE
        ================================================== --}}

        <div>

            <div class="checkout-box">

                <div class="box-header">

                    <h2>
                        📍 Delivery Details
                    </h2>

                    <p>
                        Enter your complete delivery address and mobile number.
                    </p>

                </div>


                <div class="box-body">

                    <form
                        id="checkoutForm"
                        action="{{ route('user.order.place') }}"
                        method="POST"
                    >

                        @csrf


                        {{-- =================================================
                             ADDRESS SECTION
                        ================================================== --}}

                        <div class="address-section">

                            <div class="section-title">

                                <div class="section-title-icon">
                                    🏠
                                </div>

                                <div>

                                    <strong>
                                        Complete Delivery Address
                                    </strong>

                                    <span>
                                        All address fields marked * are required
                                    </span>

                                </div>

                            </div>


                            <div class="address-grid">


                                {{-- HOUSE / FLAT --}}

                                <div class="form-group">

                                    <label for="house_no">

                                        House / Flat / Building No.

                                        <span class="required">*</span>

                                    </label>

                                    <input
                                        type="text"
                                        id="house_no"
                                        name="house_no"
                                        value="{{ old('house_no') }}"
                                        maxlength="100"
                                        placeholder="House / Flat / Building No."
                                        autocomplete="street-address"
                                        required
                                    >

                                    @error('house_no')

                                        <div class="field-error">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- STREET --}}

                                <div class="form-group">

                                    <label for="street">

                                        Street / Road

                                        <span class="required">*</span>

                                    </label>

                                    <input
                                        type="text"
                                        id="street"
                                        name="street"
                                        value="{{ old('street') }}"
                                        maxlength="150"
                                        placeholder="Street / Road name"
                                        required
                                    >

                                    @error('street')

                                        <div class="field-error">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- TOWN / VILLAGE --}}

                                <div class="form-group">

                                    <label for="town_village">

                                        Town / Village

                                        <span class="required">*</span>

                                    </label>

                                    <input
                                        type="text"
                                        id="town_village"
                                        name="town_village"
                                        value="{{ old('town_village') }}"
                                        maxlength="100"
                                        placeholder="Town / Village"
                                        required
                                    >

                                    @error('town_village')

                                        <div class="field-error">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- POST OFFICE --}}

                                <div class="form-group">

                                    <label for="post_office">

                                        Post Office

                                        <span class="required">*</span>

                                    </label>

                                    <input
                                        type="text"
                                        id="post_office"
                                        name="post_office"
                                        value="{{ old('post_office') }}"
                                        maxlength="100"
                                        placeholder="Post Office"
                                        required
                                    >

                                    @error('post_office')

                                        <div class="field-error">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- POLICE STATION --}}

                                <div class="form-group">

                                    <label for="police_station">

                                        Police Station

                                        <span class="required">*</span>

                                    </label>

                                    <input
                                        type="text"
                                        id="police_station"
                                        name="police_station"
                                        value="{{ old('police_station') }}"
                                        maxlength="100"
                                        placeholder="Police Station"
                                        required
                                    >

                                    @error('police_station')

                                        <div class="field-error">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- CITY / DISTRICT --}}

                                <div class="form-group">

                                    <label for="city_district">

                                        City / District

                                        <span class="required">*</span>

                                    </label>

                                    <input
                                        type="text"
                                        id="city_district"
                                        name="city_district"
                                        value="{{ old('city_district') }}"
                                        maxlength="100"
                                        placeholder="City / District"
                                        required
                                    >

                                    @error('city_district')

                                        <div class="field-error">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- STATE --}}

                                <div class="form-group">

                                    <label for="state">

                                        State

                                        <span class="required">*</span>

                                    </label>

                                    <input
                                        type="text"
                                        id="state"
                                        name="state"
                                        value="{{ old('state') }}"
                                        maxlength="100"
                                        placeholder="State"
                                        required
                                    >

                                    @error('state')

                                        <div class="field-error">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- PIN CODE --}}

                                <div class="form-group">

                                    <label for="pincode">

                                        PIN Code

                                        <span class="required">*</span>

                                    </label>

                                    <input
                                        type="text"
                                        id="pincode"
                                        name="pincode"
                                        value="{{ old('pincode') }}"
                                        maxlength="6"
                                        minlength="6"
                                        inputmode="numeric"
                                        pattern="[1-9][0-9]{5}"
                                        placeholder="6 digit PIN code"
                                        required
                                    >

                                    @error('pincode')

                                        <div class="field-error">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- LANDMARK --}}

                                <div class="form-group full-width">

                                    <label for="landmark">

                                        Landmark

                                        <span class="required">*</span>

                                    </label>

                                    <input
                                        type="text"
                                        id="landmark"
                                        name="landmark"
                                        value="{{ old('landmark') }}"
                                        maxlength="150"
                                        placeholder="Nearby school, market, temple, shop, road, etc."
                                        required
                                    >

                                    <div class="field-help">
                                        Give a nearby landmark so the delivery person can find the location easily.
                                    </div>

                                    @error('landmark')

                                        <div class="field-error">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>


                                {{-- ADDITIONAL DELIVERY INSTRUCTION --}}

                                <div class="form-group full-width">

                                    <label for="delivery_note">

                                        Additional Delivery Instructions

                                        <span style="color:#a8a29e;font-weight:600;">
                                            (Optional)
                                        </span>

                                    </label>

                                    <textarea
                                        id="delivery_note"
                                        name="delivery_note"
                                        maxlength="300"
                                        placeholder="Example: Call me when you reach the gate..."
                                    >{{ old('delivery_note') }}</textarea>

                                    @error('delivery_note')

                                        <div class="field-error">
                                            {{ $message }}
                                        </div>

                                    @enderror

                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                             MOBILE NUMBER
                        ================================================== --}}

                        <div class="form-group" style="margin-bottom:22px;">

                            <div class="section-title">

                                <div class="section-title-icon">
                                    📱
                                </div>

                                <div>

                                    <strong>
                                        Contact Number
                                    </strong>

                                    <span>
                                        Required for delivery communication
                                    </span>

                                </div>

                            </div>


                            <label for="phone">

                                Mobile Number

                                <span class="required">
                                    *
                                </span>

                            </label>


                            <div class="phone-wrapper">

                                <span class="phone-prefix">
                                    +91
                                </span>

                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    class="phone-input"
                                    value="{{ old('phone') }}"
                                    placeholder="10 digit mobile number"
                                    maxlength="10"
                                    minlength="10"
                                    inputmode="numeric"
                                    autocomplete="tel"
                                    pattern="[6-9][0-9]{9}"
                                    required
                                >

                            </div>


                            <div class="phone-counter">

                                <span id="phoneCount">0</span>/10 digits

                            </div>


                            <div class="field-help">

                                Enter a valid Indian mobile number beginning with
                                6, 7, 8 or 9.

                            </div>


                            @error('phone')

                                <div class="field-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- =================================================
                             LIVE LOCATION
                        ================================================== --}}

                        <div class="location-box">

                            <div class="location-header">

                                <div class="location-title">

                                    <div class="location-icon">
                                        📍
                                    </div>

                                    <div>

                                        <strong>
                                            Live Delivery Location
                                        </strong>

                                        <span>
                                            Required for accurate delivery
                                        </span>

                                    </div>

                                </div>


                                <button
                                    type="button"
                                    id="locationBtn"
                                    class="location-btn"
                                >
                                    📍 Use My Current Location
                                </button>

                            </div>


                            <div
                                id="locationStatus"
                                class="location-status"
                            >

                                <span>
                                    📡
                                </span>

                                <span id="locationStatusText">
                                    Please allow browser location access.
                                </span>

                            </div>


                            <div
                                id="locationCoordinates"
                                class="location-coordinates"
                            >

                                <div class="coordinate-card">

                                    <div class="coordinate-label">
                                        Latitude
                                    </div>

                                    <div
                                        id="latitudeDisplay"
                                        class="coordinate-value"
                                    >
                                        —
                                    </div>

                                </div>


                                <div class="coordinate-card">

                                    <div class="coordinate-label">
                                        Longitude
                                    </div>

                                    <div
                                        id="longitudeDisplay"
                                        class="coordinate-value"
                                    >
                                        —
                                    </div>

                                </div>

                            </div>


                            <input
                                type="hidden"
                                id="latitude"
                                name="latitude"
                                value="{{ old('latitude') }}"
                            >

                            <input
                                type="hidden"
                                id="longitude"
                                name="longitude"
                                value="{{ old('longitude') }}"
                            >

                            <input
                                type="hidden"
                                id="location_accuracy"
                                name="location_accuracy"
                                value="{{ old('location_accuracy') }}"
                            >


                            <div
                                id="locationRequired"
                                class="location-required"
                            >
                                * Live location is required before placing the order.
                            </div>

                        </div>


                        {{-- =================================================
                             PAYMENT METHOD
                        ================================================== --}}

                        <div class="payment-section">

                            <div class="section-title">

                                <div class="section-title-icon">
                                    💳
                                </div>

                                <div>

                                    <strong>
                                        Payment Method
                                    </strong>

                                    <span>
                                        Choose how you want to pay for this order
                                    </span>

                                </div>

                            </div>


                            <div class="payment-options">


                                {{-- COD --}}

                                <div class="payment-option">

                                    <input
                                        type="radio"
                                        id="payment_cod"
                                        name="payment_method"
                                        value="cod"
                                        {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }}
                                    >

                                    <label
                                        for="payment_cod"
                                        class="payment-card"
                                    >

                                        <div class="payment-icon">
                                            💵
                                        </div>

                                        <div class="payment-info">

                                            <strong>
                                                Cash on Delivery
                                            </strong>

                                            <span>
                                                Pay when your order arrives.
                                            </span>

                                        </div>

                                        <div class="payment-check">
                                            ✓
                                        </div>

                                    </label>

                                </div>


                                {{-- ONLINE --}}

                                <div class="payment-option">

                                    <input
                                        type="radio"
                                        id="payment_online"
                                        name="payment_method"
                                        value="online"
                                        {{ old('payment_method') === 'online' ? 'checked' : '' }}
                                    >

                                    <label
                                        for="payment_online"
                                        class="payment-card"
                                    >

                                        <div class="payment-icon">
                                            💳
                                        </div>

                                        <div class="payment-info">

                                            <strong>
                                                Online Payment
                                            </strong>

                                            <span>
                                                Pay securely using Cashfree.
                                            </span>

                                        </div>

                                        <div class="payment-check">
                                            ✓
                                        </div>

                                    </label>

                                </div>

                            </div>


                            <div
                                id="onlinePaymentNote"
                                class="online-payment-note"
                            >
                                🔒 You will be redirected to the secure Cashfree payment page after your order is created.
                            </div>


                            @error('payment_method')

                                <div class="field-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- =================================================
                             COMBINED ADDRESS
                        ================================================== --}}

                        <input
                            type="hidden"
                            id="address"
                            name="address"
                            value="{{ old('address') }}"
                        >


                        {{-- =================================================
                             PLACE ORDER
                        ================================================== --}}

                        <button
                            type="submit"
                            id="placeOrderBtn"
                            class="place-btn"
                        >
                            Place Order &nbsp; →
                        </button>


                        <div class="secure-note">

                            🔒 Your address, mobile number and payment
                            information are securely processed.

                        </div>

                    </form>

                </div>

            </div>


            {{-- =================================================
                 DELIVERY INFORMATION
            ================================================== --}}

            <div class="delivery-info">

                <strong>
                    🚚 Delivery Information
                </strong>

                <span>

                    Please enter the complete delivery address.
                    Your mobile number must contain exactly 10 digits.
                    Live GPS location is also required to help the
                    restaurant identify your delivery position.

                </span>

            </div>


            <a
                href="{{ route('user.cart') }}"
                class="back-cart"
            >
                ← Back to Cart
            </a>

        </div>


        {{-- =================================================
             RIGHT SIDE — ORDER SUMMARY
        ================================================== --}}

        <div class="checkout-box">

            <div class="box-header">

                <h2>
                    🛒 Order Summary
                </h2>

                <p>

                    {{ $cartItems->sum('quantity') }}

                    {{ $cartItems->sum('quantity') == 1 ? 'item' : 'items' }}

                    in your order

                </p>

            </div>


            <div class="box-body">


                @foreach($cartItems as $item)

                    @php

                        $menuItem = $item->menuItem;

                        $imagePath = $menuItem && $menuItem->image
                            ? 'storage/' . ltrim($menuItem->image, '/')
                            : null;

                    @endphp


                    <div class="food-row">


                        <div class="food-image">

                            @if($imagePath)

                                <img
                                    src="{{ asset($imagePath) }}"
                                    alt="{{ $menuItem->name ?? 'Food item' }}"
                                    loading="lazy"
                                    onerror="
                                        this.style.display='none';
                                        this.parentElement
                                            .querySelector('.food-placeholder')
                                            .style.display='flex';
                                    "
                                >

                                <div
                                    class="food-placeholder"
                                    style="display:none;"
                                >
                                    🍽️
                                </div>

                            @else

                                <div class="food-placeholder">
                                    🍽️
                                </div>

                            @endif

                        </div>


                        <div class="food-info">

                            @if($menuItem && $menuItem->category)

                                <div class="food-category">
                                    {{ $menuItem->category }}
                                </div>

                            @endif

                            <div class="food-name">
                                {{ $menuItem->name ?? 'Menu Item' }}
                            </div>

                            <div class="food-quantity">

                                ₹{{ number_format((float) $item->price, 2) }}

                                ×

                                {{ $item->quantity }}

                            </div>

                        </div>


                        <div class="food-price">

                            ₹{{ number_format(
                                (float) $item->price *
                                (int) $item->quantity,
                                2
                            ) }}

                        </div>

                    </div>

                @endforeach


                <div class="summary-divider"></div>


                <div class="summary-row">

                    <span>
                        Items
                    </span>

                    <strong>
                        {{ $cartItems->sum('quantity') }}
                    </strong>

                </div>


                <div class="summary-row">

                    <span>
                        Subtotal
                    </span>

                    <strong>
                        ₹{{ number_format((float) $total, 2) }}
                    </strong>

                </div>


                <div class="summary-row">

                    <span>
                        Delivery / Preparation
                    </span>

                    <strong>
                        Included
                    </strong>

                </div>


                <div class="summary-total">

                    <span>
                        Total Amount
                    </span>

                    <span>
                        ₹{{ number_format((float) $total, 2) }}
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | ELEMENTS
    |--------------------------------------------------------------------------
    */

    const form =
        document.getElementById('checkoutForm');

    const phone =
        document.getElementById('phone');

    const phoneCount =
        document.getElementById('phoneCount');

    const locationBtn =
        document.getElementById('locationBtn');

    const locationStatus =
        document.getElementById('locationStatus');

    const locationStatusText =
        document.getElementById('locationStatusText');

    const locationCoordinates =
        document.getElementById('locationCoordinates');

    const latitude =
        document.getElementById('latitude');

    const longitude =
        document.getElementById('longitude');

    const locationAccuracy =
        document.getElementById('location_accuracy');

    const latitudeDisplay =
        document.getElementById('latitudeDisplay');

    const longitudeDisplay =
        document.getElementById('longitudeDisplay');

    const locationRequired =
        document.getElementById('locationRequired');

    const placeOrderBtn =
        document.getElementById('placeOrderBtn');

    const address =
        document.getElementById('address');


    /*
    |--------------------------------------------------------------------------
    | PAYMENT ELEMENTS
    |--------------------------------------------------------------------------
    */

    const paymentOptions =
        document.querySelectorAll(
            'input[name="payment_method"]'
        );

    const onlinePaymentNote =
        document.getElementById(
            'onlinePaymentNote'
        );


    /*
    |--------------------------------------------------------------------------
    | ADDRESS FIELDS
    |--------------------------------------------------------------------------
    */

    const houseNo =
        document.getElementById('house_no');

    const street =
        document.getElementById('street');

    const townVillage =
        document.getElementById('town_village');

    const postOffice =
        document.getElementById('post_office');

    const policeStation =
        document.getElementById('police_station');

    const cityDistrict =
        document.getElementById('city_district');

    const state =
        document.getElementById('state');

    const pincode =
        document.getElementById('pincode');

    const landmark =
        document.getElementById('landmark');

    const deliveryNote =
        document.getElementById('delivery_note');


    /*
    |--------------------------------------------------------------------------
    | PAYMENT METHOD UI
    |--------------------------------------------------------------------------
    */

    function updatePaymentUI() {

        const selected =
            document.querySelector(
                'input[name="payment_method"]:checked'
            );

        if (
            selected &&
            selected.value === 'online'
        ) {

            onlinePaymentNote.classList.add(
                'active'
            );

            placeOrderBtn.textContent =
                'Continue to Secure Payment →';

        } else {

            onlinePaymentNote.classList.remove(
                'active'
            );

            placeOrderBtn.textContent =
                'Place Order →';
        }
    }


    paymentOptions.forEach(function (radio) {

        radio.addEventListener(
            'change',
            updatePaymentUI
        );

    });


    updatePaymentUI();


    /*
    |--------------------------------------------------------------------------
    | PHONE
    |--------------------------------------------------------------------------
    */

    function cleanPhone(value) {

        return value
            .replace(/\D/g, '')
            .substring(0, 10);

    }


    function updatePhoneCounter() {

        phone.value =
            cleanPhone(phone.value);

        phoneCount.textContent =
            phone.value.length;

    }


    phone.addEventListener(
        'input',
        updatePhoneCounter
    );


    updatePhoneCounter();


    /*
    |--------------------------------------------------------------------------
    | PIN CODE
    |--------------------------------------------------------------------------
    */

    pincode.addEventListener(
        'input',
        function () {

            this.value =
                this.value
                    .replace(/\D/g, '')
                    .substring(0, 6);

            this.classList.remove(
                'invalid'
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | LOCATION STATUS
    |--------------------------------------------------------------------------
    */

    function setLocationStatus(
        type,
        message
    ) {

        locationStatus.className =
            'location-status';

        if (type) {

            locationStatus.classList.add(
                type
            );

        }

        locationStatusText.textContent =
            message;

    }


    /*
    |--------------------------------------------------------------------------
    | LOCATION SUCCESS
    |--------------------------------------------------------------------------
    */

    function locationSuccess(position) {

        const lat =
            position.coords.latitude;

        const lng =
            position.coords.longitude;

        const accuracy =
            position.coords.accuracy;


        latitude.value =
            lat;

        longitude.value =
            lng;

        locationAccuracy.value =
            accuracy;


        latitudeDisplay.textContent =
            lat.toFixed(6);

        longitudeDisplay.textContent =
            lng.toFixed(6);


        locationCoordinates.style.display =
            'grid';

        locationRequired.style.display =
            'none';


        setLocationStatus(
            'success',
            'Live location captured successfully.'
        );


        locationBtn.textContent =
            '✓ Location Captured';

        locationBtn.disabled =
            false;


        if (accuracy <= 50) {

            locationStatusText.textContent =
                'Live location captured. GPS accuracy is good.';

        } else if (accuracy <= 150) {

            locationStatusText.textContent =
                'Live location captured. Accuracy is acceptable.';

        } else {

            locationStatusText.textContent =
                'Location captured, but GPS accuracy is low.';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | LOCATION ERROR
    |--------------------------------------------------------------------------
    */

    function locationError(error) {

        latitude.value = '';

        longitude.value = '';

        locationAccuracy.value = '';

        locationCoordinates.style.display =
            'none';

        locationRequired.style.display =
            'block';

        locationBtn.disabled =
            false;

        locationBtn.textContent =
            '📍 Use My Current Location';


        let message =
            'Unable to get your location.';


        switch (error.code) {

            case error.PERMISSION_DENIED:

                message =
                    'Location permission was denied. Please allow location access in your browser.';

                break;

            case error.POSITION_UNAVAILABLE:

                message =
                    'Your location is currently unavailable. Please try again.';

                break;

            case error.TIMEOUT:

                message =
                    'Location request timed out. Please try again.';

                break;

        }


        setLocationStatus(
            'error',
            message
        );

    }


    /*
    |--------------------------------------------------------------------------
    | GET CURRENT LOCATION
    |--------------------------------------------------------------------------
    */

    function getCurrentLocation() {

        if (!navigator.geolocation) {

            setLocationStatus(
                'error',
                'Your browser does not support GPS location.'
            );

            return;

        }


        locationBtn.disabled =
            true;

        locationBtn.textContent =
            '📡 Detecting Location...';


        setLocationStatus(
            'loading',
            'Getting your current location. Please allow location access...'
        );


        navigator.geolocation.getCurrentPosition(
            locationSuccess,
            locationError,
            {
                enableHighAccuracy: true,
                timeout: 15000,
                maximumAge: 0
            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | LOCATION BUTTON
    |--------------------------------------------------------------------------
    */

    locationBtn.addEventListener(
        'click',
        getCurrentLocation
    );


    /*
    |--------------------------------------------------------------------------
    | EXISTING LOCATION
    |--------------------------------------------------------------------------
    */

    if (
        latitude.value &&
        longitude.value
    ) {

        locationCoordinates.style.display =
            'grid';

        locationRequired.style.display =
            'none';


        latitudeDisplay.textContent =
            parseFloat(
                latitude.value
            ).toFixed(6);

        longitudeDisplay.textContent =
            parseFloat(
                longitude.value
            ).toFixed(6);


        setLocationStatus(
            'success',
            'Previously captured location is available.'
        );


        locationBtn.textContent =
            '✓ Location Captured';

    }


    /*
    |--------------------------------------------------------------------------
    | BUILD COMPLETE ADDRESS
    |--------------------------------------------------------------------------
    */

    function buildCompleteAddress() {

        const parts = [];


        if (houseNo.value.trim()) {

            parts.push(
                'House/Flat/Building: ' +
                houseNo.value.trim()
            );

        }


        if (street.value.trim()) {

            parts.push(
                'Street/Road: ' +
                street.value.trim()
            );

        }


        if (townVillage.value.trim()) {

            parts.push(
                'Town/Village: ' +
                townVillage.value.trim()
            );

        }


        if (postOffice.value.trim()) {

            parts.push(
                'Post Office: ' +
                postOffice.value.trim()
            );

        }


        if (policeStation.value.trim()) {

            parts.push(
                'Police Station: ' +
                policeStation.value.trim()
            );

        }


        if (cityDistrict.value.trim()) {

            parts.push(
                'City/District: ' +
                cityDistrict.value.trim()
            );

        }


        if (state.value.trim()) {

            parts.push(
                'State: ' +
                state.value.trim()
            );

        }


        if (pincode.value.trim()) {

            parts.push(
                'PIN Code: ' +
                pincode.value.trim()
            );

        }


        if (landmark.value.trim()) {

            parts.push(
                'Landmark: ' +
                landmark.value.trim()
            );

        }


        if (deliveryNote.value.trim()) {

            parts.push(
                'Delivery Instruction: ' +
                deliveryNote.value.trim()
            );

        }


        address.value =
            parts.join(', ');

    }


    /*
    |--------------------------------------------------------------------------
    | REMOVE FIELD ERROR
    |--------------------------------------------------------------------------
    */

    const addressFields = [

        houseNo,
        street,
        townVillage,
        postOffice,
        policeStation,
        cityDistrict,
        state,
        pincode,
        landmark

    ];


    addressFields.forEach(function (field) {

        field.addEventListener(
            'input',
            function () {

                this.classList.remove(
                    'invalid'
                );

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | FORM SUBMISSION
    |--------------------------------------------------------------------------
    */

    form.addEventListener(
        'submit',
        function (event) {

            /*
            |--------------------------------------------------------------
            | PHONE
            |--------------------------------------------------------------
            */

            phone.value =
                cleanPhone(phone.value);


            const phonePattern =
                /^[6-9][0-9]{9}$/;


            if (
                !phonePattern.test(
                    phone.value
                )
            ) {

                event.preventDefault();

                phone.classList.add(
                    'invalid'
                );

                phone.focus();

                return;

            }


            phone.classList.remove(
                'invalid'
            );


            /*
            |--------------------------------------------------------------
            | PIN
            |--------------------------------------------------------------
            */

            const pinPattern =
                /^[1-9][0-9]{5}$/;


            if (
                !pinPattern.test(
                    pincode.value
                )
            ) {

                event.preventDefault();

                pincode.classList.add(
                    'invalid'
                );

                pincode.focus();

                return;

            }


            pincode.classList.remove(
                'invalid'
            );


            /*
            |--------------------------------------------------------------
            | ADDRESS
            |--------------------------------------------------------------
            */

            let firstInvalid =
                null;


            addressFields.forEach(
                function (field) {

                    if (
                        !field.value.trim()
                    ) {

                        field.classList.add(
                            'invalid'
                        );

                        if (
                            !firstInvalid
                        ) {

                            firstInvalid =
                                field;

                        }

                    }

                }
            );


            if (firstInvalid) {

                event.preventDefault();

                firstInvalid.focus();

                return;

            }


            /*
            |--------------------------------------------------------------
            | BUILD ADDRESS
            |--------------------------------------------------------------
            */

            buildCompleteAddress();


            if (
                !address.value.trim()
            ) {

                event.preventDefault();

                return;

            }


            /*
            |--------------------------------------------------------------
            | PAYMENT METHOD
            |--------------------------------------------------------------
            */

            const selectedPayment =
                document.querySelector(
                    'input[name="payment_method"]:checked'
                );


            if (!selectedPayment) {

                event.preventDefault();

                alert(
                    'Please select a payment method.'
                );

                return;

            }


            /*
            |--------------------------------------------------------------
            | LIVE LOCATION
            |--------------------------------------------------------------
            */

            if (
                !latitude.value ||
                !longitude.value
            ) {

                event.preventDefault();

                locationRequired.style.display =
                    'block';


                setLocationStatus(
                    'error',
                    'Please capture your live location before placing the order.'
                );


                locationBtn.focus();

                return;

            }


            /*
            |--------------------------------------------------------------
            | PREVENT DOUBLE SUBMISSION
            |--------------------------------------------------------------
            */

            placeOrderBtn.disabled =
                true;


            if (
                selectedPayment.value === 'online'
            ) {

                placeOrderBtn.textContent =
                    'Creating Secure Payment...';

            } else {

                placeOrderBtn.textContent =
                    'Placing Order...';

            }

        }
    );

});

</script>

@endsection

