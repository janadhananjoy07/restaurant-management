@extends('layouts.user')

@section('title', 'My Profile')

@section('styles')

<style>
    :root {
        --profile-dark: #1c1917;
        --profile-text: #292524;
        --profile-muted: #78716c;
        --profile-gold: #b7791f;
        --profile-gold-light: #fbf3e5;
        --profile-border: #e7e2da;
        --profile-bg: #f7f5f1;
        --profile-green: #15803d;
        --profile-red: #b91c1c;
    }

    .profile-page {
        max-width: 850px;
        margin: 0 auto;
        color: var(--profile-text);
    }

    /* HEADER */

    .profile-header {
        position: relative;
        overflow: hidden;
        margin-bottom: 22px;
        padding: 32px 25px;
        border-radius: 14px;
        background: var(--profile-dark);
        color: white;
        text-align: center;
    }

    .profile-header::before {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        right: -80px;
        top: -100px;
        border-radius: 50%;
        border: 1px solid rgba(214,168,95,.18);
    }

    .profile-header::after {
        content: "";
        position: absolute;
        width: 150px;
        height: 150px;
        left: -70px;
        bottom: -80px;
        border-radius: 50%;
        border: 1px solid rgba(214,168,95,.15);
    }

    .profile-icon {
        position: relative;
        z-index: 1;
        width: 82px;
        height: 82px;
        margin: 0 auto 15px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #d6a85f;
        color: var(--profile-dark);
        font-size: 34px;
        box-shadow: 0 8px 25px rgba(0,0,0,.25);
    }

    .profile-eyebrow {
        position: relative;
        z-index: 1;
        margin-bottom: 7px;
        color: #d6a85f;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 10px;
        font-weight: 800;
    }

    .profile-header h1 {
        position: relative;
        z-index: 1;
        margin: 0 0 6px;
        color: white;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 29px;
    }

    .profile-header p {
        position: relative;
        z-index: 1;
        margin: 0;
        color: #b7afa5;
        font-size: 12px;
    }

    /* ACCOUNT BADGE */

    .account-badge {
        position: relative;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 15px;
        padding: 6px 11px;
        border-radius: 20px;
        background: rgba(255,255,255,.08);
        color: #ded7cf;
        font-size: 10px;
        font-weight: 700;
    }

    .account-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #79c58d;
    }

    /* PROFILE CARD */

    .profile-card {
        overflow: hidden;
        background: white;
        border: 1px solid var(--profile-border);
        border-radius: 14px;
    }

    .profile-card-header {
        padding: 21px 24px;
        border-bottom: 1px solid var(--profile-border);
    }

    .profile-card-header h2 {
        margin: 0 0 5px;
        color: var(--profile-dark);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 22px;
    }

    .profile-card-header p {
        margin: 0;
        color: var(--profile-muted);
        font-size: 12px;
    }

    .profile-body {
        padding: 24px;
    }

    /* ALERTS */

    .success {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 22px;
        padding: 13px 15px;
        border: 1px solid #bbf7d0;
        border-radius: 9px;
        background: #f0fdf4;
        color: #166534;
        font-size: 12px;
        font-weight: 600;
    }

    .error {
        margin-bottom: 22px;
        padding: 13px 15px;
        border: 1px solid #fecaca;
        border-radius: 9px;
        background: #fef2f2;
        color: #991b1b;
        font-size: 12px;
        line-height: 1.6;
    }

    /* FORM */

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: var(--profile-dark);
        font-size: 12px;
        font-weight: 800;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        top: 50%;
        left: 13px;
        transform: translateY(-50%);
        font-size: 14px;
        pointer-events: none;
    }

    .form-group input {
        width: 100%;
        height: 45px;
        box-sizing: border-box;
        padding: 11px 13px 11px 39px;
        border: 1px solid #d6d3d1;
        border-radius: 8px;
        background: #fafaf9;
        color: var(--profile-text);
        font-family: inherit;
        font-size: 13px;
        outline: none;
        transition: .2s ease;
    }

    .form-group input:focus {
        border-color: var(--profile-gold);
        background: white;
        box-shadow: 0 0 0 3px rgba(183,121,31,.10);
    }

    .form-group input:disabled {
        background: #f5f5f4;
        color: #78716c;
        cursor: not-allowed;
    }

    .field-help {
        margin-top: 6px;
        color: #a8a29e;
        font-size: 10px;
    }

    /* ACCOUNT TYPE */

    .account-type {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        min-height: 45px;
        box-sizing: border-box;
        padding: 8px 13px;
        border: 1px solid var(--profile-border);
        border-radius: 8px;
        background: #fafaf9;
    }

    .account-type-left {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .account-type-icon {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 7px;
        background: var(--profile-gold-light);
        font-size: 13px;
    }

    .account-type-name {
        color: var(--profile-dark);
        font-size: 12px;
        font-weight: 700;
    }

    .account-type-badge {
        padding: 5px 9px;
        border-radius: 15px;
        background: #f0fdf4;
        color: var(--profile-green);
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
    }

    /* BUTTON */

    .btn {
        width: 100%;
        min-height: 47px;
        margin-top: 3px;
        padding: 12px 18px;
        border: 0;
        border-radius: 8px;
        background: var(--profile-dark);
        color: white;
        cursor: pointer;
        font-size: 13px;
        font-weight: 800;
        transition: .25s ease;
    }

    .btn:hover {
        background: var(--profile-gold);
        transform: translateY(-2px);
    }

    /* PROFILE FOOTER */

    .profile-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-top: 13px;
        color: #a8a29e;
        font-size: 10px;
    }

    /* QUICK LINKS */

    .quick-links {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 13px;
        margin-top: 17px;
    }

    .quick-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 13px;
        border: 1px solid var(--profile-border);
        border-radius: 9px;
        background: white;
        color: var(--profile-dark);
        transition: .2s ease;
    }

    .quick-link:hover {
        border-color: #d7c7ae;
        transform: translateY(-2px);
    }

    .quick-link-icon {
        width: 32px;
        height: 32px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 7px;
        background: var(--profile-gold-light);
        font-size: 14px;
    }

    .quick-link-text strong {
        display: block;
        margin-bottom: 2px;
        font-size: 11px;
    }

    .quick-link-text span {
        color: var(--profile-muted);
        font-size: 9px;
    }

    /* RESPONSIVE */

    @media (max-width: 650px) {

        .profile-header {
            padding: 28px 18px;
        }

        .profile-header h1 {
            font-size: 25px;
        }

        .profile-body,
        .profile-card-header {
            padding: 18px;
        }

        .quick-links {
            grid-template-columns: 1fr;
        }
    }
</style>

@endsection


@section('content')

<div class="profile-page">

    {{-- PROFILE HEADER --}}

    <div class="profile-header">

        <div class="profile-icon">
            👤
        </div>

        <div class="profile-eyebrow">
            Your account
        </div>

        <h1>
            {{ auth()->user()->name }}
        </h1>

        <p>
            {{ auth()->user()->email }}
        </p>

        <div class="account-badge">

            <span class="account-dot"></span>

            Active Member

        </div>

    </div>


    {{-- PROFILE FORM --}}

    <div class="profile-card">

        <div class="profile-card-header">

            <h2>
                Personal Information
            </h2>

            <p>
                Keep your account details up to date.
            </p>

        </div>


        <div class="profile-body">


            {{-- SUCCESS --}}

            @if(session('success'))

                <div class="success">

                    <span>✓</span>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            @endif


            {{-- ERRORS --}}

            @if($errors->any())

                <div class="error">

                    <strong>
                        Please check the following:
                    </strong>

                    @foreach($errors->all() as $error)

                        <div>
                            • {{ $error }}
                        </div>

                    @endforeach

                </div>

            @endif


            <form
                action="{{ route('user.profile.update') }}"
                method="POST"
            >

                @csrf

                @method('PUT')


                {{-- NAME --}}

                <div class="form-group">

                    <label for="name">
                        Full Name
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">
                            👤
                        </span>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', auth()->user()->name) }}"
                            placeholder="Enter your name"
                            required
                        >

                    </div>

                </div>


                {{-- EMAIL --}}

                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">
                            ✉️
                        </span>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', auth()->user()->email) }}"
                            placeholder="Enter your email"
                            required
                        >

                    </div>

                    <div class="field-help">
                        This email is associated with your restaurant account.
                    </div>

                </div>


                {{-- ACCOUNT TYPE --}}

                <div class="form-group">

                    <label>
                        Account Type
                    </label>

                    <div class="account-type">

                        <div class="account-type-left">

                            <div class="account-type-icon">
                                🍽️
                            </div>

                            <div class="account-type-name">
                                Restaurant Customer
                            </div>

                        </div>

                        <div class="account-type-badge">
                            User
                        </div>

                    </div>

                </div>


                {{-- SUBMIT --}}

                <button
                    type="submit"
                    class="btn"
                >
                    Save Changes &nbsp; →
                </button>


                <div class="profile-note">
                    🔒 Your account information is kept private.
                </div>

            </form>

        </div>

    </div>


    {{-- QUICK LINKS --}}

    <div class="quick-links">

        <a
            href="{{ route('user.orders') }}"
            class="quick-link"
        >

            <div class="quick-link-icon">
                📦
            </div>

            <div class="quick-link-text">

                <strong>
                    My Orders
                </strong>

                <span>
                    View order history
                </span>

            </div>

        </a>


        <a
            href="{{ route('user.reservations') }}"
            class="quick-link"
        >

            <div class="quick-link-icon">
                📅
            </div>

            <div class="quick-link-text">

                <strong>
                    Reservations
                </strong>

                <span>
                    Manage bookings
                </span>

            </div>

        </a>


        <a
            href="{{ route('user.menu') }}"
            class="quick-link"
        >

            <div class="quick-link-icon">
                🍽️
            </div>

            <div class="quick-link-text">

                <strong>
                    Explore Menu
                </strong>

                <span>
                    Order something delicious
                </span>

            </div>

        </a>

    </div>

</div>

@endsection

