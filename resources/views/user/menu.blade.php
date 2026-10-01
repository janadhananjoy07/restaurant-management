@extends('layouts.user')

@section('title', 'Our Menu')

@section('styles')
<style>
    :root {
        --menu-bg: #f7f5f1;
        --menu-card: #ffffff;
        --menu-dark: #1c1917;
        --menu-text: #292524;
        --menu-muted: #78716c;
        --menu-gold: #c58b3a;
        --menu-gold-dark: #9a6724;
        --menu-green: #15803d;
        --menu-border: #e7e2da;
        --menu-danger: #b91c1c;
    }

    .menu-page {
        color: var(--menu-text);
        width: 100%;
    }

    /* =========================================
       HEADER
    ========================================= */

    .menu-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 25px;
        margin-bottom: 24px;
    }

    .menu-eyebrow {
        color: var(--menu-gold-dark);
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 11px;
        font-weight: 800;
        margin-bottom: 7px;
    }

    .menu-header h1 {
        margin: 0 0 7px;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 38px;
        line-height: 1.1;
        color: var(--menu-dark);
    }

    .menu-header p {
        color: var(--menu-muted);
        margin: 0;
        font-size: 14px;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .cart-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 11px 17px;
        background: var(--menu-dark);
        color: #fff;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: .25s ease;
        white-space: nowrap;
    }

    .cart-link:hover {
        background: #000;
        transform: translateY(-2px);
        color: #fff;
    }

    /* =========================================
       ALERTS
    ========================================= */

    .alert {
        border-radius: 10px;
        padding: 13px 16px;
        margin-bottom: 22px;
        font-size: 14px;
    }

    .alert-success {
        background: #ecfdf3;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .alert-error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .alert ul {
        margin: 0;
        padding-left: 20px;
    }

    /* =========================================
       MENU INTRO
    ========================================= */

    .menu-intro {
        background:
            linear-gradient(
                100deg,
                rgba(29, 25, 21, .97),
                rgba(59, 43, 26, .90)
            );
        border-radius: 14px;
        padding: 27px 30px;
        margin-bottom: 25px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .menu-intro::after {
        content: "✦";
        position: absolute;
        right: 35px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 100px;
        color: rgba(255,255,255,.05);
    }

    .menu-intro h2 {
        margin: 0 0 5px;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 25px;
        position: relative;
        z-index: 1;
    }

    .menu-intro p {
        margin: 0;
        color: #d6d0c7;
        font-size: 13px;
        position: relative;
        z-index: 1;
        max-width: 700px;
    }

    /* =========================================
       FILTER PANEL
    ========================================= */

    .filter-panel {
        background: #fff;
        border: 1px solid var(--menu-border);
        border-radius: 16px;
        padding: 22px;
        margin-bottom: 28px;
        box-shadow: 0 8px 25px rgba(28, 25, 23, .05);
    }

    .filter-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 18px;
    }

    .filter-title {
        display: flex;
        align-items: center;
        gap: 9px;
        margin: 0;
        color: var(--menu-dark);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 22px;
    }

    .filter-subtitle {
        color: var(--menu-muted);
        font-size: 12px;
        margin: 3px 0 0;
    }

    .filter-result {
        background: #fbf3e5;
        border: 1px solid #f1dfc2;
        color: var(--menu-gold-dark);
        border-radius: 20px;
        padding: 7px 12px;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 15px;
    }

    .filter-field {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .filter-field.full {
        grid-column: 1 / -1;
    }

    .filter-label {
        font-size: 11px;
        font-weight: 800;
        color: #44403c;
        text-transform: uppercase;
        letter-spacing: .6px;
    }

    .filter-input,
    .filter-select {
        width: 100%;
        min-height: 44px;
        border: 1px solid #d9d2c8;
        border-radius: 9px;
        padding: 10px 12px;
        background: #fff;
        color: var(--menu-dark);
        font-size: 13px;
        outline: none;
        transition: border-color .2s ease, box-shadow .2s ease;
        box-sizing: border-box;
    }

    .filter-input::placeholder {
        color: #a8a29e;
    }

    .filter-input:focus,
    .filter-select:focus {
        border-color: var(--menu-gold);
        box-shadow: 0 0 0 3px rgba(197, 139, 58, .10);
    }

    .price-range-wrap {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 10px;
    }

    .price-box {
        position: relative;
    }

    .price-prefix {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--menu-muted);
        font-size: 13px;
        pointer-events: none;
    }

    .price-box .filter-input {
        padding-left: 25px;
    }

    .filter-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        margin-top: 18px;
        padding-top: 18px;
        border-top: 1px solid #eee9e1;
    }

    .filter-btn {
        min-height: 44px;
        border-radius: 9px;
        padding: 10px 18px;
        border: 0;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        transition: .2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .filter-btn-primary {
        background: var(--menu-dark);
        color: #fff;
    }

    .filter-btn-primary:hover {
        background: var(--menu-gold-dark);
        color: #fff;
        transform: translateY(-1px);
    }

    .filter-btn-clear {
        background: #f5f1eb;
        color: #57534e;
        border: 1px solid #dfd6ca;
    }

    .filter-btn-clear:hover {
        background: #ece5db;
        color: var(--menu-dark);
    }

    /* ACTIVE FILTERS */

    .active-filters {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        margin-top: 15px;
    }

    .active-filter-title {
        font-size: 11px;
        color: var(--menu-muted);
        font-weight: 700;
        margin-right: 2px;
    }

    .filter-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 20px;
        background: #faf7f2;
        border: 1px solid #e7ded2;
        color: #57534e;
        font-size: 11px;
        font-weight: 700;
    }

    .filter-chip strong {
        color: var(--menu-gold-dark);
    }

    /* =========================================
       SELECTED ITEM
    ========================================= */

    .selected-food {
        border-color: #e4a63f !important;
        box-shadow:
            0 12px 35px rgba(197, 139, 58, .22),
            0 0 0 2px rgba(197, 139, 58, .08);
    }

    .selected-label {
        position: absolute;
        top: 14px;
        left: 14px;
        z-index: 3;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #e4a63f;
        color: #21170b;
        padding: 7px 11px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    /* =========================================
       MENU GRID
    ========================================= */

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 25px;
    }

    /* =========================================
       FOOD CARD
    ========================================= */

    .food-card {
        position: relative;
        background: var(--menu-card);
        border: 1px solid var(--menu-border);
        border-radius: 14px;
        overflow: hidden;
        transition:
            transform .3s ease,
            box-shadow .3s ease,
            border-color .3s ease;
    }

    .food-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 35px rgba(28, 25, 23, .11);
        border-color: #d7c8b3;
    }

    /* =========================================
       IMAGE
    ========================================= */

    .food-image-wrap {
        width: 100%;
        height: 215px;
        background: #eee9e1;
        overflow: hidden;
        position: relative;
    }

    .food-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .45s ease;
    }

    .food-card:hover .food-image {
        transform: scale(1.045);
    }

    .food-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background:
            linear-gradient(
                135deg,
                #eee9e1,
                #ddd5c9
            );
        font-size: 58px;
    }

    /* =========================================
       CARD CONTENT
    ========================================= */

    .food-content {
        padding: 20px;
    }

    .food-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 9px;
    }

    .food-category {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--menu-gold-dark);
        background: #fbf3e5;
        border: 1px solid #f1dfc2;
        border-radius: 20px;
        padding: 5px 9px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .7px;
    }

    .food-category::before {
        content: "•";
        font-size: 12px;
    }

    .food-price {
        color: var(--menu-dark);
        font-size: 19px;
        font-weight: 800;
        white-space: nowrap;
    }

    .food-name {
        margin: 0 0 8px;
        color: var(--menu-dark);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 23px;
        line-height: 1.2;
    }

    .food-subcategory {
        color: #a16207;
        font-size: 11px;
        font-weight: 700;
        margin-bottom: 7px;
    }

    .food-description {
        color: var(--menu-muted);
        font-size: 13px;
        line-height: 1.65;
        min-height: 43px;
        margin: 0 0 17px;
    }

    /* =========================================
       ADD TO CART
    ========================================= */

    .cart-form {
        margin: 0;
    }

    .cart-btn {
        width: 100%;
        border: 0;
        min-height: 45px;
        padding: 11px 14px;
        background: var(--menu-dark);
        color: #fff;
        border-radius: 8px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 700;
        transition: background .2s ease, transform .2s ease;
    }

    .cart-btn:hover {
        background: var(--menu-gold-dark);
        transform: translateY(-1px);
    }

    .cart-btn:active {
        transform: translateY(0);
    }

    /* =========================================
       EMPTY
    ========================================= */

    .empty-menu {
        grid-column: 1 / -1;
        background: white;
        border: 1px dashed #d8d0c5;
        border-radius: 14px;
        padding: 65px 25px;
        text-align: center;
    }

    .empty-icon {
        width: 75px;
        height: 75px;
        margin: 0 auto 18px;
        border-radius: 50%;
        background: #f4eee5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 35px;
    }

    .empty-menu h2 {
        margin: 0 0 8px;
        color: var(--menu-dark);
        font-family: Georgia, "Times New Roman", serif;
    }

    .empty-menu p {
        margin: 0 0 18px;
        color: var(--menu-muted);
        font-size: 14px;
    }

    .empty-clear-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--menu-dark);
        color: #fff;
        text-decoration: none;
        padding: 10px 15px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 800;
    }

    .empty-clear-btn:hover {
        background: var(--menu-gold-dark);
        color: #fff;
    }

    /* =========================================
       BOTTOM INFO
    ========================================= */

    .menu-footer-note {
        margin-top: 35px;
        padding: 20px;
        border-top: 1px solid var(--menu-border);
        display: flex;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
        color: var(--menu-muted);
        font-size: 12px;
    }

    .menu-footer-note span {
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .menu-footer-note strong {
        color: var(--menu-gold-dark);
    }

    /* =========================================
       TABLET
    ========================================= */

    @media (max-width: 1100px) {
        .filter-grid {
            grid-template-columns: 1fr 1fr;
        }

        .filter-field.search-field {
            grid-column: 1 / -1;
        }

        .menu-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    /* =========================================
       MOBILE
    ========================================= */

    @media (max-width: 700px) {
        .menu-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 17px;
        }

        .menu-header h1 {
            font-size: 32px;
        }

        .header-actions {
            width: 100%;
        }

        .cart-link {
            width: 100%;
        }

        .menu-intro {
            padding: 22px;
        }

        .menu-intro h2 {
            font-size: 22px;
        }

        .menu-intro::after {
            display: none;
        }

        .filter-panel {
            padding: 17px;
        }

        .filter-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .filter-grid {
            grid-template-columns: 1fr;
        }

        .filter-field.full,
        .filter-field.search-field {
            grid-column: auto;
        }

        .price-range-wrap {
            grid-template-columns: 1fr;
        }

        .filter-actions {
            flex-direction: column-reverse;
        }

        .filter-btn {
            width: 100%;
        }

        .menu-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .food-image-wrap {
            height: 230px;
        }

        .food-content {
            padding: 18px;
        }

        .menu-footer-note {
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
    }

    @media (max-width: 420px) {
        .menu-header h1 {
            font-size: 29px;
        }

        .food-image-wrap {
            height: 210px;
        }

        .food-name {
            font-size: 21px;
        }

        .food-top {
            gap: 8px;
        }

        .food-price {
            font-size: 17px;
        }
    }
</style>
@endsection


@section('content')

<div class="menu-page">

    {{-- =========================================
         HEADER
    ========================================== --}}

    <div class="menu-header">
        <div>
            <div class="menu-eyebrow">
                From our kitchen
            </div>

            <h1>
                🍽️ Our Menu
            </h1>

            <p>
                Discover delicious dishes prepared fresh for you.
            </p>
        </div>

        <div class="header-actions">
            <a href="{{ route('user.cart') }}" class="cart-link">
                🛒 View Cart
            </a>
        </div>
    </div>


    {{-- =========================================
         SUCCESS MESSAGE
    ========================================== --}}

    @if(session('success'))
        <div class="alert alert-success">
            ✓ {{ session('success') }}
        </div>
    @endif


    {{-- =========================================
         ERROR MESSAGE
    ========================================== --}}

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif


    {{-- =========================================
         VALIDATION ERRORS
    ========================================== --}}

    @if($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- =========================================
         MENU INTRO
    ========================================== --}}

    <div class="menu-intro">
        <h2>
            Good food starts here.
        </h2>

        <p>
            Search your favourite dish, filter by price or category,
            choose a subcategory and add your favourite food to the cart.
        </p>
    </div>


    {{-- =========================================
         FILTER PANEL
    ========================================== --}}

    <form
        action="{{ route('user.menu') }}"
        method="GET"
        class="filter-panel"
    >

        {{-- Keep dashboard-selected item while filtering --}}
        @if(!empty($selectedItemId))
            <input
                type="hidden"
                name="item"
                value="{{ $selectedItemId }}"
            >
        @endif

        <div class="filter-heading">
            <div>
                <h2 class="filter-title">
                    🔎 Find Your Food
                </h2>

                <p class="filter-subtitle">
                    Use one or more filters to narrow down the menu.
                </p>
            </div>

            <div class="filter-result">
                {{ $resultCount ?? $menuItems->count() }}
                {{ ($resultCount ?? $menuItems->count()) === 1 ? 'dish' : 'dishes' }}
            </div>
        </div>


        <div class="filter-grid">

            {{-- SEARCH MENU --}}
            <div class="filter-field search-field">
                <label for="search" class="filter-label">
                    Menu / Dish
                </label>

                <input
                    type="text"
                    id="search"
                    name="search"
                    class="filter-input"
                    placeholder="Search dish name or description..."
                    value="{{ $search ?? request('search', '') }}"
                    autocomplete="off"
                >
            </div>


            {{-- CATEGORY --}}
            <div class="filter-field">
                <label for="category" class="filter-label">
                    Category
                </label>

                <select
                    id="category"
                    name="category"
                    class="filter-select"
                >
                    <option value="">
                        All Categories
                    </option>

                    @foreach(($categories ?? collect()) as $categoryOption)
                        <option
                            value="{{ $categoryOption }}"
                            {{ ($category ?? request('category')) === $categoryOption ? 'selected' : '' }}
                        >
                            {{ $categoryOption }}
                        </option>
                    @endforeach

                    {{-- Others option --}}
                    @if(!collect($categories ?? [])->contains('Others'))
                        <option
                            value="Others"
                            {{ ($category ?? request('category')) === 'Others' ? 'selected' : '' }}
                        >
                            Others
                        </option>
                    @endif
                </select>
            </div>


            {{-- SUBCATEGORY --}}
            <div class="filter-field">
                <label for="subcategory" class="filter-label">
                    Subcategory
                </label>

                <select
                    id="subcategory"
                    name="subcategory"
                    class="filter-select"
                >
                    <option value="">
                        All Subcategories
                    </option>

                    @foreach(($subcategories ?? collect()) as $subcategoryOption)
                        <option
                            value="{{ $subcategoryOption }}"
                            {{ ($subcategory ?? request('subcategory')) === $subcategoryOption ? 'selected' : '' }}
                        >
                            {{ $subcategoryOption }}
                        </option>
                    @endforeach

                    {{-- Others option --}}
                    @if(!collect($subcategories ?? [])->contains('Others'))
                        <option
                            value="Others"
                            {{ ($subcategory ?? request('subcategory')) === 'Others' ? 'selected' : '' }}
                        >
                            Others
                        </option>
                    @endif
                </select>
            </div>


            {{-- PRICE RANGE --}}
            <div class="filter-field">
                <label for="price_range" class="filter-label">
                    Price Range
                </label>

                <select
                    id="price_range"
                    name="price_range"
                    class="filter-select"
                >
                    <option value="">
                        All Prices
                    </option>

                    <option
                        value="under_100"
                        {{ ($priceRange ?? request('price_range')) === 'under_100' ? 'selected' : '' }}
                    >
                        Under ₹100
                    </option>

                    <option
                        value="100_250"
                        {{ ($priceRange ?? request('price_range')) === '100_250' ? 'selected' : '' }}
                    >
                        ₹100 – ₹250
                    </option>

                    <option
                        value="250_500"
                        {{ ($priceRange ?? request('price_range')) === '250_500' ? 'selected' : '' }}
                    >
                        ₹250 – ₹500
                    </option>

                    <option
                        value="above_500"
                        {{ ($priceRange ?? request('price_range')) === 'above_500' ? 'selected' : '' }}
                    >
                        Above ₹500
                    </option>
                </select>
            </div>


            {{-- CUSTOM PRICE --}}
            <div class="filter-field full">

                <label class="filter-label">
                    Custom Price
                </label>

                <div class="price-range-wrap">

                    <div class="price-box">
                        <span class="price-prefix">₹</span>

                        <input
                            type="number"
                            id="min_price"
                            name="min_price"
                            class="filter-input"
                            placeholder="Minimum price"
                            min="0"
                            step="0.01"
                            value="{{ $minPrice ?? request('min_price', '') }}"
                        >
                    </div>

                    <div class="price-box">
                        <span class="price-prefix">₹</span>

                        <input
                            type="number"
                            id="max_price"
                            name="max_price"
                            class="filter-input"
                            placeholder="Maximum price"
                            min="0"
                            step="0.01"
                            value="{{ $maxPrice ?? request('max_price', '') }}"
                        >
                    </div>

                    <div>
                        <input
                            type="text"
                            class="filter-input"
                            value="Example: ₹150 – ₹400"
                            readonly
                            aria-label="Price range example"
                        >
                    </div>

                </div>
            </div>

        </div>


        {{-- ACTIVE FILTERS --}}
        @php
            $currentSearch = $search ?? request('search', '');
            $currentCategory = $category ?? request('category', '');
            $currentSubcategory = $subcategory ?? request('subcategory', '');
            $currentMinPrice = $minPrice ?? request('min_price', '');
            $currentMaxPrice = $maxPrice ?? request('max_price', '');
            $currentPriceRange = $priceRange ?? request('price_range', '');
        @endphp

        @if(
            $currentSearch !== '' ||
            $currentCategory !== '' ||
            $currentSubcategory !== '' ||
            $currentMinPrice !== '' ||
            $currentMaxPrice !== '' ||
            $currentPriceRange !== ''
        )

            <div class="active-filters">

                <span class="active-filter-title">
                    Active filters:
                </span>

                @if($currentSearch !== '')
                    <span class="filter-chip">
                        🔎 <strong>Menu:</strong>
                        {{ $currentSearch }}
                    </span>
                @endif

                @if($currentCategory !== '')
                    <span class="filter-chip">
                        🍽️ <strong>Category:</strong>
                        {{ $currentCategory }}
                    </span>
                @endif

                @if($currentSubcategory !== '')
                    <span class="filter-chip">
                        🥘 <strong>Subcategory:</strong>
                        {{ $currentSubcategory }}
                    </span>
                @endif

                @if($currentPriceRange !== '')
                    @php
                        $priceLabels = [
                            'under_100' => 'Under ₹100',
                            '100_250'   => '₹100 – ₹250',
                            '250_500'   => '₹250 – ₹500',
                            'above_500' => 'Above ₹500',
                        ];
                    @endphp

                    <span class="filter-chip">
                        💰 <strong>Price:</strong>
                        {{ $priceLabels[$currentPriceRange] ?? $currentPriceRange }}
                    </span>
                @endif

                @if($currentMinPrice !== '')
                    <span class="filter-chip">
                        ⬆️ <strong>Min:</strong>
                        ₹{{ number_format((float) $currentMinPrice, 2) }}
                    </span>
                @endif

                @if($currentMaxPrice !== '')
                    <span class="filter-chip">
                        ⬇️ <strong>Max:</strong>
                        ₹{{ number_format((float) $currentMaxPrice, 2) }}
                    </span>
                @endif

            </div>

        @endif


        {{-- ACTIONS --}}
        <div class="filter-actions">

            @php
                $clearParams = [];

                if (!empty($selectedItemId)) {
                    $clearParams['item'] = $selectedItemId;
                }
            @endphp

            <a
                href="{{ route('user.menu', $clearParams) }}"
                class="filter-btn filter-btn-clear"
            >
                ↺ Clear Filters
            </a>

            <button
                type="submit"
                class="filter-btn filter-btn-primary"
            >
                🔍 Apply Filters
            </button>

        </div>

    </form>


    {{-- =========================================
         MENU ITEMS
    ========================================== --}}

    @if($menuItems->count() > 0)

        <div class="menu-grid">

            @foreach($menuItems as $item)

                @php

                    $isSelected =
                        isset($selectedItemId)
                        && (int) $selectedItemId === (int) $item->id;

                    $imagePath = $item->image
                        ? 'storage/' . ltrim($item->image, '/')
                        : null;

                @endphp


                <article
                    class="food-card {{ $isSelected ? 'selected-food' : '' }}"
                    id="food-{{ $item->id }}"
                >

                    {{-- SELECTED LABEL --}}
                    @if($isSelected)

                        <div class="selected-label">
                            ⭐ Selected from Dashboard
                        </div>

                    @endif


                    {{-- IMAGE --}}
                    <div class="food-image-wrap">

                        @if($imagePath)

                            <img
                                src="{{ asset($imagePath) }}"
                                alt="{{ $item->name }}"
                                class="food-image"
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


                    {{-- CONTENT --}}
                    <div class="food-content">

                        <div class="food-top">

                            @if($item->category)

                                <span class="food-category">
                                    {{ $item->category }}
                                </span>

                            @endif

                            <span class="food-price">
                                ₹{{ number_format((float) $item->price, 2) }}
                            </span>

                        </div>


                        @if($item->subcategory)

                            <div class="food-subcategory">
                                {{ $item->subcategory }}
                            </div>

                        @endif


                        <h2 class="food-name">
                            {{ $item->name }}
                        </h2>


                        <p class="food-description">
                            {{ $item->description
                                ?: 'Delicious food prepared fresh by our restaurant.' }}
                        </p>


                        {{-- ADD TO CART --}}
                        <form
                            action="{{ route('user.cart.add', $item->id) }}"
                            method="POST"
                            class="cart-form"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="cart-btn"
                            >
                                🛒 Add to Cart
                            </button>

                        </form>

                    </div>

                </article>

            @endforeach

        </div>

    @else

        {{-- =========================================
             EMPTY FILTER RESULT
        ========================================== --}}

        <div class="empty-menu">

            <div class="empty-icon">
                🔍
            </div>

            <h2>
                No Matching Food Found
            </h2>

            <p>
                We couldn't find any dishes matching your current filters.
                Try changing the search, price, category or subcategory.
            </p>

            @php
                $clearParams = [];

                if (!empty($selectedItemId)) {
                    $clearParams['item'] = $selectedItemId;
                }
            @endphp

            <a
                href="{{ route('user.menu', $clearParams) }}"
                class="empty-clear-btn"
            >
                ↺ Show All Menu Items
            </a>

        </div>

    @endif


    {{-- =========================================
         FOOTER NOTE
    ========================================== --}}

    @if($menuItems->count() > 0)

        <div class="menu-footer-note">

            <span>
                <strong>✓</strong>
                Freshly prepared
            </span>

            <span>
                <strong>✓</strong>
                Quality ingredients
            </span>

            <span>
                <strong>✓</strong>
                Easy online ordering
            </span>

        </div>

    @endif

</div>


{{-- =========================================
     SMALL FILTER UX
========================================== --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const priceRange = document.getElementById('price_range');
        const minPrice = document.getElementById('min_price');
        const maxPrice = document.getElementById('max_price');

        /*
        |--------------------------------------------------------------------------
        | If user enters a custom price, remove quick price range selection.
        |--------------------------------------------------------------------------
        */

        function clearQuickPriceRange() {
            if (priceRange) {
                priceRange.value = '';
            }
        }

        if (minPrice) {
            minPrice.addEventListener('input', clearQuickPriceRange);
        }

        if (maxPrice) {
            maxPrice.addEventListener('input', clearQuickPriceRange);
        }

        /*
        |--------------------------------------------------------------------------
        | If user chooses a quick price range, clear custom price fields.
        |--------------------------------------------------------------------------
        */

        if (priceRange) {
            priceRange.addEventListener('change', function () {

                if (this.value !== '') {

                    if (minPrice) {
                        minPrice.value = '';
                    }

                    if (maxPrice) {
                        maxPrice.value = '';
                    }

                }

            });
        }

    });
</script>

@endsection

