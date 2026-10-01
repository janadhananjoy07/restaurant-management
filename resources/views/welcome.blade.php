@php
    /*
    |--------------------------------------------------------------------------
    | HOMEPAGE DATA
    |--------------------------------------------------------------------------
    |
    | We keep database queries inside try/catch so the public homepage
    | does not completely crash if a table/column is temporarily missing.
    |
    */

    $featuredItems = collect();
    $popularItems = collect();

    try {
        /*
        |--------------------------------------------------------------------------
        | FEATURED DISHES
        |--------------------------------------------------------------------------
        */

        $featuredItems = \App\Models\MenuItem::query()
            ->where('available', true)
            ->latest()
            ->take(6)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | POPULAR DISHES
        |--------------------------------------------------------------------------
        |
        | First try to calculate popularity from order_items.
        |
        | Expected:
        | order_items.menu_item_id
        | order_items.quantity
        |
        | If that query cannot run because the project structure is different,
        | fallback to available menu items.
        |
        */

        try {
            $popularItems = \App\Models\MenuItem::query()
                ->where('menu_items.available', true)
                ->leftJoin(
                    'order_items',
                    'menu_items.id',
                    '=',
                    'order_items.menu_item_id'
                )
                ->select(
                    'menu_items.*',
                    \Illuminate\Support\Facades\DB::raw(
                        'COALESCE(SUM(order_items.quantity), 0) as total_sold'
                    )
                )
                ->groupBy('menu_items.id')
                ->orderByDesc('total_sold')
                ->latest('menu_items.created_at')
                ->take(6)
                ->get();

        } catch (\Throwable $e) {

            /*
            | Fallback
            */

            $popularItems = \App\Models\MenuItem::query()
                ->where('available', true)
                ->latest()
                ->take(6)
                ->get();
        }

    } catch (\Throwable $e) {

        $featuredItems = collect();
        $popularItems = collect();
    }
@endphp

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="BenStoke Restaurant - Fresh food, warm hospitality, easy online ordering and table reservations."
    >

    <meta
        name="theme-color"
        content="#11100e"
    >

    <title>
        {{ config('app.name', 'BenStoke') }}
        | Good Food. Good Mood.
    </title>

    <!-- GOOGLE FONTS -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet"
    >


    <style>

        /*
        |--------------------------------------------------------------------------
        | RESET
        |--------------------------------------------------------------------------
        */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        :root {

            --bg: #11100e;
            --bg-soft: #181612;
            --card: #211e19;

            --gold: #d6a85f;
            --gold-light: #efc982;

            --cream: #f6f0e6;

            --text: #eee7dc;
            --muted: #a8a096;

            --white: #ffffff;

            --border: rgba(255,255,255,.09);

            --success: #79c58a;
        }


        html {
            scroll-behavior: smooth;
        }


        body {

            font-family: "DM Sans", sans-serif;

            background: var(--bg);

            color: var(--text);

            line-height: 1.6;
        }


        a {

            color: inherit;

            text-decoration: none;
        }


        img {

            max-width: 100%;

            display: block;
        }


        button,
        input,
        select,
        textarea {

            font: inherit;
        }


        .container {

            width: min(
                1180px,
                calc(100% - 40px)
            );

            margin: auto;
        }


        /*
        |--------------------------------------------------------------------------
        | NAVBAR
        |--------------------------------------------------------------------------
        */

        .navbar {

            position: fixed;

            top: 0;
            left: 0;

            width: 100%;

            z-index: 1000;

            background: rgba(
                17,
                16,
                14,
                .92
            );

            backdrop-filter: blur(15px);

            border-bottom:
                1px solid var(--border);
        }


        .nav-inner {

            min-height: 78px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 25px;
        }


        .logo {

            font-family:
                "Playfair Display",
                serif;

            font-size: 28px;

            font-weight: 700;

            letter-spacing: .5px;

            color: var(--cream);

            white-space: nowrap;
        }


        .logo span {

            color: var(--gold);
        }


        .nav-links {

            display: flex;

            align-items: center;

            gap: 27px;
        }


        .nav-links a {

            color: #d8d1c7;

            font-size: 14px;

            font-weight: 500;

            transition: .25s;
        }


        .nav-links a:hover {

            color: var(--gold-light);
        }


        /*
        |--------------------------------------------------------------------------
        | NAV ACTIONS
        |--------------------------------------------------------------------------
        */

        .nav-actions {

            display: flex;

            align-items: center;

            gap: 8px;
        }


        .nav-login {

            color: var(--cream);

            font-size: 13px;

            font-weight: 600;

            padding: 10px 12px;
        }


        .nav-login:hover {

            color: var(--gold-light);
        }


        .nav-register {

            background:
                var(--gold);

            color:
                #17120c;

            border-radius: 7px;

            padding:
                10px 15px;

            font-size: 13px;

            font-weight: 700;

            transition: .25s;
        }


        .nav-register:hover {

            background:
                var(--gold-light);

            transform:
                translateY(-2px);
        }


        .portal-links {

            display: flex;

            align-items: center;

            gap: 6px;

            margin-left: 5px;

            padding-left: 10px;

            border-left:
                1px solid var(--border);
        }


        .portal-link {

            color:
                #aaa198;

            font-size:
                11px;

            padding:
                8px 6px;

            transition:
                .2s;
        }


        .portal-link:hover {

            color:
                var(--gold-light);
        }


        /*
        |--------------------------------------------------------------------------
        | USER NAV
        |--------------------------------------------------------------------------
        */

        .user-nav {

            display: flex;

            align-items: center;

            gap: 7px;
        }


        .user-name {

            color:
                var(--gold-light);

            font-size:
                12px;

            font-weight:
                600;

            max-width:
                100px;

            overflow:
                hidden;

            text-overflow:
                ellipsis;

            white-space:
                nowrap;
        }


        /*
        |--------------------------------------------------------------------------
        | BUTTONS
        |--------------------------------------------------------------------------
        */

        .btn {

            display:
                inline-flex;

            justify-content:
                center;

            align-items:
                center;

            min-height:
                46px;

            padding:
                0 22px;

            border-radius:
                8px;

            font-size:
                14px;

            font-weight:
                600;

            transition:
                .25s ease;

            border:
                1px solid transparent;

            cursor:
                pointer;
        }


        .btn-gold {

            background:
                var(--gold);

            color:
                #17120c;
        }


        .btn-gold:hover {

            background:
                var(--gold-light);

            transform:
                translateY(-2px);
        }


        .btn-outline {

            border-color:
                rgba(
                    255,
                    255,
                    255,
                    .18
                );

            color:
                var(--cream);
        }


        .btn-outline:hover {

            border-color:
                var(--gold);

            color:
                var(--gold-light);
        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE BUTTON
        |--------------------------------------------------------------------------
        */

        .menu-toggle {

            display:
                none;

            border:
                0;

            background:
                none;

            color:
                white;

            font-size:
                27px;

            cursor:
                pointer;
        }


        /*
        |--------------------------------------------------------------------------
        | HERO
        |--------------------------------------------------------------------------
        */

        .hero {

            min-height:
                760px;

            padding-top:
                78px;

            display:
                flex;

            align-items:
                center;

            position:
                relative;

            overflow:
                hidden;

            background:

                linear-gradient(
                    90deg,
                    rgba(10,9,7,.98) 0%,
                    rgba(10,9,7,.84) 42%,
                    rgba(10,9,7,.35) 72%,
                    rgba(10,9,7,.72) 100%
                ),

                url("https://images.unsplash.com/photo-1515003197210-e0cd71810b5f?auto=format&fit=crop&w=2000&q=85")
                center/cover;
        }


        .hero::after {

            content: "";

            position:
                absolute;

            inset:
                0;

            background:
                radial-gradient(
                    circle at 75% 45%,
                    transparent 0%,
                    rgba(0,0,0,.35) 65%,
                    rgba(0,0,0,.65) 100%
                );

            pointer-events:
                none;
        }


        .hero-content {

            position:
                relative;

            z-index:
                2;

            max-width:
                690px;
        }


        .eyebrow {

            display:
                inline-flex;

            align-items:
                center;

            gap:
                9px;

            color:
                var(--gold-light);

            text-transform:
                uppercase;

            letter-spacing:
                3px;

            font-size:
                12px;

            font-weight:
                700;

            margin-bottom:
                20px;
        }


        .eyebrow::before {

            content:
                "";

            width:
                32px;

            height:
                1px;

            background:
                var(--gold);
        }


        .hero h1 {

            font-family:
                "Playfair Display",
                serif;

            font-size:
                clamp(
                    52px,
                    7vw,
                    88px
                );

            line-height:
                .98;

            letter-spacing:
                -2px;

            color:
                white;

            margin-bottom:
                25px;
        }


        .hero h1 span {

            color:
                var(--gold-light);
        }


        .hero p {

            max-width:
                580px;

            color:
                #d4cec4;

            font-size:
                17px;

            line-height:
                1.8;

            margin-bottom:
                34px;
        }


        .hero-buttons {

            display:
                flex;

            flex-wrap:
                wrap;

            gap:
                13px;
        }


        .hero-note {

            margin-top:
                28px;

            display:
                flex;

            gap:
                25px;

            flex-wrap:
                wrap;

            color:
                #bcb4aa;

            font-size:
                13px;
        }


        .hero-note span {

            display:
                flex;

            align-items:
                center;

            gap:
                8px;
        }


        .hero-note strong {

            color:
                var(--gold-light);
        }


        /*
        |--------------------------------------------------------------------------
        | FEATURES
        |--------------------------------------------------------------------------
        */

        .features {

            background:
                var(--cream);

            color:
                #262019;

            padding:
                30px 0;
        }


        .feature-grid {

            display:
                grid;

            grid-template-columns:
                repeat(
                    3,
                    1fr
                );
        }


        .feature {

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                15px;

            padding:
                12px 25px;

            border-right:
                1px solid
                rgba(0,0,0,.1);
        }


        .feature:last-child {

            border-right:
                0;
        }


        .feature-icon {

            width:
                44px;

            height:
                44px;

            border-radius:
                50%;

            background:
                #e9ddc9;

            color:
                #9b702e;

            display:
                grid;

            place-items:
                center;

            font-size:
                18px;
        }


        .feature h3 {

            font-family:
                "Playfair Display",
                serif;

            font-size:
                17px;

            margin-bottom:
                2px;
        }


        .feature p {

            font-size:
                12px;

            color:
                #736b61;
        }


        /*
        |--------------------------------------------------------------------------
        | COMMON SECTION
        |--------------------------------------------------------------------------
        */

        .section {

            padding:
                105px 0;
        }


        .section-header {

            text-align:
                center;

            max-width:
                650px;

            margin:
                0 auto 55px;
        }


        .section-label {

            color:
                var(--gold);

            text-transform:
                uppercase;

            letter-spacing:
                3px;

            font-size:
                11px;

            font-weight:
                700;

            margin-bottom:
                12px;
        }


        .section-title {

            font-family:
                "Playfair Display",
                serif;

            font-size:
                clamp(
                    35px,
                    5vw,
                    53px
                );

            line-height:
                1.1;

            color:
                var(--cream);

            margin-bottom:
                16px;
        }


        .section-description {

            color:
                var(--muted);

            font-size:
                15px;
        }


        /*
        |--------------------------------------------------------------------------
        | POPULAR DISHES
        |--------------------------------------------------------------------------
        */

        .popular-section {

            background:
                var(--bg-soft);
        }


        .popular-grid {

            display:
                grid;

            grid-template-columns:
                repeat(
                    3,
                    1fr
                );

            gap:
                24px;
        }


        .popular-card {

            position:
                relative;

            overflow:
                hidden;

            border:
                1px solid
                var(--border);

            background:
                var(--card);

            border-radius:
                12px;

            transition:
                .3s ease;
        }


        .popular-card:hover {

            transform:
                translateY(-6px);

            border-color:
                rgba(
                    214,
                    168,
                    95,
                    .4
                );

            box-shadow:
                0 18px 45px
                rgba(
                    0,
                    0,
                    0,
                    .25
                );
        }


        .popular-badge {

            position:
                absolute;

            top:
                14px;

            left:
                14px;

            z-index:
                2;

            background:
                var(--gold);

            color:
                #17120c;

            padding:
                6px 10px;

            border-radius:
                5px;

            font-size:
                10px;

            font-weight:
                800;

            text-transform:
                uppercase;

            letter-spacing:
                1px;
        }


        /*
        |--------------------------------------------------------------------------
        | FOOD CARD
        |--------------------------------------------------------------------------
        */

        .food-image-wrap {

            height:
                230px;

            overflow:
                hidden;

            background:
                #151310;

            position:
                relative;
        }


        .food-image {

            width:
                100%;

            height:
                100%;

            object-fit:
                cover;

            transition:
                transform
                .45s ease;
        }


        .food-card:hover .food-image,
        .popular-card:hover .food-image {

            transform:
                scale(1.05);
        }


        .food-placeholder {

            height:
                100%;

            display:
                grid;

            place-items:
                center;

            font-size:
                52px;

            color:
                #6d6256;
        }


        .food-content {

            padding:
                21px;
        }


        .food-meta {

            display:
                flex;

            justify-content:
                space-between;

            align-items:
                center;

            gap:
                10px;

            margin-bottom:
                10px;
        }


        .food-category {

            color:
                var(--gold);

            text-transform:
                uppercase;

            letter-spacing:
                1.5px;

            font-size:
                10px;

            font-weight:
                700;
        }


        .food-price {

            color:
                var(--gold-light);

            font-weight:
                700;

            font-size:
                17px;
        }


        .food-content h3 {

            font-family:
                "Playfair Display",
                serif;

            color:
                var(--cream);

            font-size:
                23px;

            margin-bottom:
                7px;
        }


        .food-content p {

            color:
                var(--muted);

            font-size:
                13px;

            line-height:
                1.7;

            min-height:
                44px;
        }


        .food-action {

            display:
                inline-block;

            margin-top:
                17px;

            color:
                var(--cream);

            font-size:
                13px;

            font-weight:
                600;
        }


        .food-action:hover {

            color:
                var(--gold-light);
        }


        .center-button {

            text-align:
                center;

            margin-top:
                42px;
        }


        /*
        |--------------------------------------------------------------------------
        | FEATURED MENU
        |--------------------------------------------------------------------------
        */

        .menu-section {

            background:
                var(--bg);
        }


        .menu-grid {

            display:
                grid;

            grid-template-columns:
                repeat(
                    3,
                    1fr
                );

            gap:
                24px;
        }


        .food-card {

            overflow:
                hidden;

            border:
                1px solid
                var(--border);

            background:
                var(--card);

            border-radius:
                12px;

            transition:
                .3s ease;
        }


        .food-card:hover {

            transform:
                translateY(-6px);

            border-color:
                rgba(
                    214,
                    168,
                    95,
                    .4
                );

            box-shadow:
                0 18px 45px
                rgba(
                    0,
                    0,
                    0,
                    .25
                );
        }


        /*
        |--------------------------------------------------------------------------
        | ABOUT
        |--------------------------------------------------------------------------
        */

        .about-section {

            background:
                var(--bg-soft);
        }


        .about-grid {

            display:
                grid;

            grid-template-columns:
                1fr 1fr;

            gap:
                70px;

            align-items:
                center;
        }


        .about-image {

            min-height:
                520px;

            border-radius:
                12px;

            overflow:
                hidden;

            background:

                url("https://images.unsplash.com/photo-1559339352-11d035aa65de?auto=format&fit=crop&w=1200&q=85")
                center/cover;
        }


        .about-content h2 {

            font-family:
                "Playfair Display",
                serif;

            font-size:
                clamp(
                    37px,
                    5vw,
                    57px
                );

            line-height:
                1.08;

            color:
                var(--cream);

            margin-bottom:
                23px;
        }


        .about-content p {

            color:
                var(--muted);

            font-size:
                15px;

            line-height:
                1.9;

            margin-bottom:
                17px;
        }


        .about-points {

            margin-top:
                28px;

            display:
                grid;

            gap:
                15px;
        }


        .about-point {

            display:
                flex;

            gap:
                13px;

            align-items:
                flex-start;
        }


        .about-point-icon {

            color:
                var(--gold);

            margin-top:
                4px;
        }


        .about-point strong {

            display:
                block;

            color:
                var(--cream);

            margin-bottom:
                3px;
        }


        .about-point span {

            color:
                var(--muted);

            font-size:
                13px;
        }


        /*
        |--------------------------------------------------------------------------
        | RESERVATION
        |--------------------------------------------------------------------------
        */

        .reservation {

            padding:
                95px 0;

            background:

                linear-gradient(
                    rgba(15,12,9,.83),
                    rgba(15,12,9,.83)
                ),

                url("https://images.unsplash.com/photo-1414235077428-338989a2e8c0?auto=format&fit=crop&w=2000&q=85")
                center/cover;
        }


        .reservation-box {

            max-width:
                850px;

            margin:
                auto;

            text-align:
                center;
        }


        .reservation-box h2 {

            font-family:
                "Playfair Display",
                serif;

            color:
                white;

            font-size:
                clamp(
                    38px,
                    5vw,
                    58px
                );

            line-height:
                1.1;

            margin-bottom:
                18px;
        }


        .reservation-box p {

            color:
                #d2cbc0;

            max-width:
                600px;

            margin:
                0 auto 30px;
        }


        /*
        |--------------------------------------------------------------------------
        | FOOTER
        |--------------------------------------------------------------------------
        */

        footer {

            background:
                #0b0a08;

            border-top:
                1px solid
                var(--border);

            padding:
                65px 0 25px;
        }


        .footer-grid {

            display:
                grid;

            grid-template-columns:
                1.5fr
                1fr
                1fr
                1fr;

            gap:
                45px;

            padding-bottom:
                50px;
        }


        .footer-brand p {

            color:
                var(--muted);

            font-size:
                13px;

            line-height:
                1.8;

            max-width:
                300px;

            margin-top:
                15px;
        }


        .footer-title {

            color:
                var(--cream);

            font-family:
                "Playfair Display",
                serif;

            font-size:
                18px;

            margin-bottom:
                17px;
        }


        .footer-links {

            display:
                grid;

            gap:
                10px;
        }


        .footer-links a {

            color:
                var(--muted);

            font-size:
                13px;

            transition:
                .2s;
        }


        .footer-links a:hover {

            color:
                var(--gold-light);
        }


        .footer-bottom {

            padding-top:
                23px;

            border-top:
                1px solid
                var(--border);

            display:
                flex;

            justify-content:
                space-between;

            gap:
                20px;

            color:
                #756e65;

            font-size:
                12px;
        }


        /*
        |--------------------------------------------------------------------------
        | EMPTY MENU
        |--------------------------------------------------------------------------
        */

        .empty-menu {

            grid-column:
                1 / -1;

            text-align:
                center;

            padding:
                50px 20px;

            border:
                1px dashed
                var(--border);

            border-radius:
                12px;

            color:
                var(--muted);
        }


        .empty-menu-icon {

            font-size:
                40px;

            margin-bottom:
                12px;

            opacity:
                .7;
        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 1050px) {

            .portal-links {

                display:
                    none;
            }

            .nav-links {

                gap:
                    18px;
            }
        }


        @media (max-width: 900px) {

            .nav-links,
            .nav-actions {

                display:
                    none;
            }


            .menu-toggle {

                display:
                    block;
            }


            .nav-inner {

                min-height:
                    70px;
            }


            .nav-mobile-open .nav-links {

                display:
                    flex;

                position:
                    absolute;

                left:
                    0;

                right:
                    0;

                top:
                    70px;

                padding:
                    20px;

                background:
                    #11100e;

                border-bottom:
                    1px solid
                    var(--border);

                flex-direction:
                    column;

                align-items:
                    flex-start;

                gap:
                    18px;
            }


            .nav-mobile-open .nav-actions {

                display:
                    flex;

                position:
                    absolute;

                left:
                    20px;

                right:
                    20px;

                top:
                    300px;

                padding:
                    20px 0;

                background:
                    #11100e;

                border-bottom:
                    1px solid
                    var(--border);

                flex-wrap:
                    wrap;
            }


            .feature-grid {

                grid-template-columns:
                    1fr;
            }


            .feature {

                justify-content:
                    flex-start;

                border-right:
                    0;

                border-bottom:
                    1px solid
                    rgba(0,0,0,.1);

                padding:
                    17px 10px;
            }


            .feature:last-child {

                border-bottom:
                    0;
            }


            .popular-grid,
            .menu-grid {

                grid-template-columns:
                    repeat(
                        2,
                        1fr
                    );
            }


            .about-grid {

                grid-template-columns:
                    1fr;

                gap:
                    40px;
            }


            .about-image {

                min-height:
                    400px;
            }


            .footer-grid {

                grid-template-columns:
                    1fr 1fr;
            }
        }


        @media (max-width: 600px) {

            .container {

                width:
                    min(
                        100% - 28px,
                        1180px
                    );
            }


            .hero {

                min-height:
                    690px;

                padding-top:
                    70px;

                background-position:
                    62% center;
            }


            .hero h1 {

                font-size:
                    52px;

                letter-spacing:
                    -1px;
            }


            .hero p {

                font-size:
                    15px;
            }


            .hero-buttons {

                flex-direction:
                    column;

                align-items:
                    stretch;
            }


            .hero-buttons .btn {

                width:
                    100%;
            }


            .hero-note {

                gap:
                    12px;

                flex-direction:
                    column;
            }


            .section {

                padding:
                    75px 0;
            }


            .popular-grid,
            .menu-grid {

                grid-template-columns:
                    1fr;
            }


            .food-image-wrap {

                height:
                    240px;
            }


            .about-image {

                min-height:
                    330px;
            }


            .footer-grid {

                grid-template-columns:
                    1fr;

                gap:
                    30px;
            }


            .footer-bottom {

                flex-direction:
                    column;
            }
        }

    </style>

</head>


<body>


<!-- ========================================================= -->
<!-- NAVBAR -->
<!-- ========================================================= -->

<header
    class="navbar"
    id="navbar"
>

    <div class="container nav-inner">


        <!-- LOGO -->

        <a
            href="{{ route('home') }}"
            class="logo"
        >
            Ben<span>Stoke</span>
        </a>


        <!-- MAIN NAV -->

        <nav class="nav-links">

            <a href="{{ route('home') }}">
                Home
            </a>

            <a href="#popular">
                Popular
            </a>

            <a href="#menu">
                Menu
            </a>

            <a href="#about">
                About
            </a>

            <a href="#reservation">
                Reservations
            </a>

        </nav>


        <!-- DESKTOP ACTIONS -->

        <div class="nav-actions">


            @auth

                <!-- USER -->

                <div class="user-nav">

                    <span class="user-name">
                        Hi,
                        {{ auth()->user()->name }}
                    </span>

                    <a
                        href="{{ route('user.dashboard') }}"
                        class="nav-login"
                    >
                        Dashboard
                    </a>

                    <a
                        href="{{ route('user.menu') }}"
                        class="nav-register"
                    >
                        Order Online
                    </a>

                </div>


            @else

                <!-- USER LOGIN -->

                <a
                    href="{{ route('login') }}"
                    class="nav-login"
                >
                    User Login
                </a>


                <!-- USER REGISTER -->

                <a
                    href="{{ route('register') }}"
                    class="nav-register"
                >
                    User Register
                </a>


                <!-- STAFF / ADMIN -->

                <div class="portal-links">

                    <a
                        href="{{ route('staff.login') }}"
                        class="portal-link"
                    >
                        Staff Login
                    </a>

                    <a
                        href="{{ route('staff.register') }}"
                        class="portal-link"
                    >
                        Staff Register
                    </a>

                    <a
                        href="{{ route('admin.login') }}"
                        class="portal-link"
                    >
                        Admin
                    </a>

                </div>

            @endauth

        </div>


        <!-- MOBILE -->

        <button
            type="button"
            class="menu-toggle"
            onclick="toggleMobileMenu()"
            aria-label="Open menu"
        >
            ☰
        </button>

    </div>

</header>


<!-- ========================================================= -->
<!-- HERO -->
<!-- ========================================================= -->

<section class="hero">

    <div class="container">

        <div class="hero-content">


            <div class="eyebrow">
                Welcome to BenStoke
            </div>


            <h1>

                Good food.<br>

                <span>
                    Good mood.
                </span>

            </h1>


            <p>

                Fresh ingredients, bold flavours and warm hospitality.

                Discover food made with care and served with
                a little something extra.

            </p>


            <div class="hero-buttons">


                @auth

                    <a
                        href="{{ route('user.menu') }}"
                        class="btn btn-gold"
                    >
                        Explore Our Menu →
                    </a>


                    <a
                        href="{{ route('user.book-table') }}"
                        class="btn btn-outline"
                    >
                        Book a Table
                    </a>


                @else

                    <a
                        href="{{ route('login') }}"
                        class="btn btn-gold"
                    >
                        Explore Our Menu →
                    </a>


                    <a
                        href="{{ route('login') }}"
                        class="btn btn-outline"
                    >
                        Book a Table
                    </a>

                @endauth

            </div>


            <div class="hero-note">

                <span>
                    <strong>●</strong>
                    Freshly prepared
                </span>

                <span>
                    <strong>●</strong>
                    Easy online ordering
                </span>

                <span>
                    <strong>●</strong>
                    Table reservations
                </span>

            </div>


        </div>

    </div>

</section>


<!-- ========================================================= -->
<!-- FEATURES -->
<!-- ========================================================= -->

<section class="features">

    <div class="container feature-grid">


        <div class="feature">

            <div class="feature-icon">
                ✦
            </div>

            <div>

                <h3>
                    Freshly Prepared
                </h3>

                <p>
                    Quality ingredients in every dish
                </p>

            </div>

        </div>


        <div class="feature">

            <div class="feature-icon">
                ♡
            </div>

            <div>

                <h3>
                    Made to Order
                </h3>

                <p>
                    Cooked fresh when you order
                </p>

            </div>

        </div>


        <div class="feature">

            <div class="feature-icon">
                ⌂
            </div>

            <div>

                <h3>
                    Easy Reservations
                </h3>

                <p>
                    Book your table in a few clicks
                </p>

            </div>

        </div>


    </div>

</section>


<!-- ========================================================= -->
<!-- POPULAR DISHES -->
<!-- ========================================================= -->

<section
    class="section popular-section"
    id="popular"
>

    <div class="container">


        <div class="section-header">

            <div class="section-label">
                Customer favourites
            </div>


            <h2 class="section-title">
                Popular Dishes
            </h2>


            <p class="section-description">

                Discover some of the dishes our customers
                love the most.

            </p>

        </div>


        <div class="popular-grid">


            @forelse($popularItems as $item)

                <article class="popular-card">


                    <div class="popular-badge">
                        Popular
                    </div>


                    <div class="food-image-wrap">


                        @if($item->image)

                            <img
                                src="{{ asset('storage/' . ltrim($item->image, '/')) }}"
                                alt="{{ $item->name }}"
                                class="food-image"
                                loading="lazy"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';"
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


                    <div class="food-content">


                        <div class="food-meta">

                            <span class="food-category">

                                {{ $item->subcategory ?: $item->category }}

                            </span>


                            <span class="food-price">

                                ₹{{ number_format((float) $item->price, 0) }}

                            </span>

                        </div>


                        <h3>
                            {{ $item->name }}
                        </h3>


                        <p>

                            {{
                                \Illuminate\Support\Str::limit(
                                    $item->description
                                    ?: 'Deliciously prepared with quality ingredients.',
                                    95
                                )
                            }}

                        </p>


                        @auth

                            <a
                                href="{{ route('user.menu', ['item' => $item->id]) }}"
                                class="food-action"
                            >
                                Order this dish →
                            </a>

                        @else

                            <a
                                href="{{ route('login') }}"
                                class="food-action"
                            >
                                Login to order →
                            </a>

                        @endauth


                    </div>

                </article>


            @empty


                <div class="empty-menu">

                    <div class="empty-menu-icon">
                        🍽️
                    </div>

                    <h3>
                        Popular dishes coming soon
                    </h3>

                    <p>
                        Our kitchen is preparing something delicious.
                    </p>

                </div>


            @endforelse


        </div>


        <div class="center-button">

            @auth

                <a
                    href="{{ route('user.menu') }}"
                    class="btn btn-gold"
                >
                    Explore Full Menu →
                </a>

            @else

                <a
                    href="{{ route('login') }}"
                    class="btn btn-gold"
                >
                    Login to Explore Menu →
                </a>

            @endauth

        </div>


    </div>

</section>


<!-- ========================================================= -->
<!-- FEATURED MENU -->
<!-- ========================================================= -->

<section
    class="section menu-section"
    id="menu"
>

    <div class="container">


        <div class="section-header">

            <div class="section-label">
                From our kitchen
            </div>


            <h2 class="section-title">
                Featured Dishes
            </h2>


            <p class="section-description">

                A selection of dishes from our menu.
                Explore more and find your next favourite.

            </p>

        </div>


        <div class="menu-grid">


            @forelse($featuredItems as $item)

                <article class="food-card">


                    <div class="food-image-wrap">


                        @if($item->image)

                            <img
                                src="{{ asset('storage/' . ltrim($item->image, '/')) }}"
                                alt="{{ $item->name }}"
                                class="food-image"
                                loading="lazy"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';"
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


                    <div class="food-content">


                        <div class="food-meta">

                            <span class="food-category">

                                {{ $item->subcategory ?: $item->category }}

                            </span>


                            <span class="food-price">

                                ₹{{ number_format((float) $item->price, 0) }}

                            </span>

                        </div>


                        <h3>
                            {{ $item->name }}
                        </h3>


                        <p>

                            {{
                                \Illuminate\Support\Str::limit(
                                    $item->description
                                    ?: 'Deliciously prepared with quality ingredients.',
                                    95
                                )
                            }}

                        </p>


                        @auth

                            <a
                                href="{{ route('user.menu', ['item' => $item->id]) }}"
                                class="food-action"
                            >
                                Order this dish →
                            </a>

                        @else

                            <a
                                href="{{ route('login') }}"
                                class="food-action"
                            >
                                Login to order →
                            </a>

                        @endauth


                    </div>

                </article>


            @empty


                <div class="empty-menu">

                    <div class="empty-menu-icon">
                        🍽️
                    </div>

                    <h3>
                        No featured dishes yet
                    </h3>

                    <p>
                        Our menu is being prepared.
                        Please check back soon.
                    </p>

                </div>


            @endforelse


        </div>


        <div class="center-button">

            @auth

                <a
                    href="{{ route('user.menu') }}"
                    class="btn btn-outline"
                >
                    View Full Menu
                </a>

            @else

                <a
                    href="{{ route('login') }}"
                    class="btn btn-outline"
                >
                    Login to View Menu
                </a>

            @endauth

        </div>


    </div>

</section>


<!-- ========================================================= -->
<!-- ABOUT -->
<!-- ========================================================= -->

<section
    class="section about-section"
    id="about"
>

    <div class="container about-grid">


        <div class="about-image"></div>


        <div class="about-content">


            <div class="section-label">
                Our Story
            </div>


            <h2>
                A place for good food & great moments.
            </h2>


            <p>

                At BenStoke, we believe a restaurant is more than
                just a place to eat. It is a place where people meet,
                conversations happen and memories are made.

            </p>


            <p>

                Our kitchen focuses on fresh ingredients,
                thoughtful preparation and flavours that keep
                you coming back.

            </p>


            <div class="about-points">


                <div class="about-point">

                    <div class="about-point-icon">
                        ✓
                    </div>

                    <div>

                        <strong>
                            Quality Ingredients
                        </strong>

                        <span>
                            Carefully selected ingredients for every dish.
                        </span>

                    </div>

                </div>


                <div class="about-point">

                    <div class="about-point-icon">
                        ✓
                    </div>

                    <div>

                        <strong>
                            Friendly Service
                        </strong>

                        <span>
                            Warm hospitality from the moment you arrive.
                        </span>

                    </div>

                </div>


                <div class="about-point">

                    <div class="about-point-icon">
                        ✓
                    </div>

                    <div>

                        <strong>
                            Made With Care
                        </strong>

                        <span>
                            Every order is prepared fresh for you.
                        </span>

                    </div>

                </div>


            </div>


        </div>

    </div>

</section>


<!-- ========================================================= -->
<!-- RESERVATION -->
<!-- ========================================================= -->

<section
    class="reservation"
    id="reservation"
>

    <div class="container">


        <div class="reservation-box">


            <div class="section-label">
                Your table is waiting
            </div>


            <h2>
                Make your next meal memorable.
            </h2>


            <p>

                Planning a dinner, celebration or simply looking
                for a great meal? Reserve your table and let us
                take care of the rest.

            </p>


            @auth

                <a
                    href="{{ route('user.book-table') }}"
                    class="btn btn-gold"
                >
                    Book a Table →
                </a>

            @else

                <a
                    href="{{ route('login') }}"
                    class="btn btn-gold"
                >
                    Login to Book a Table →
                </a>

            @endauth


        </div>

    </div>

</section>


<!-- ========================================================= -->
<!-- FOOTER -->
<!-- ========================================================= -->

<footer>

    <div class="container">


        <div class="footer-grid">


            <!-- BRAND -->

            <div class="footer-brand">

                <a
                    href="{{ route('home') }}"
                    class="logo"
                >
                    Ben<span>Stoke</span>
                </a>


                <p>

                    Fresh food, warm hospitality and memorable
                    dining experiences. Welcome to your new
                    favourite place to eat.

                </p>

            </div>


            <!-- EXPLORE -->

            <div>

                <h3 class="footer-title">
                    Explore
                </h3>


                <div class="footer-links">

                    <a href="{{ route('home') }}">
                        Home
                    </a>

                    <a href="#popular">
                        Popular Dishes
                    </a>


                    @auth

                        <a href="{{ route('user.menu') }}">
                            Menu
                        </a>

                        <a href="{{ route('user.orders') }}">
                            My Orders
                        </a>

                    @else

                        <a href="{{ route('login') }}">
                            Menu
                        </a>

                    @endauth


                    <a href="#about">
                        About Us
                    </a>

                </div>

            </div>


            <!-- USER ACCOUNT -->

            <div>

                <h3 class="footer-title">
                    User Account
                </h3>


                <div class="footer-links">


                    @auth

                        <a href="{{ route('user.dashboard') }}">
                            Dashboard
                        </a>


                        <a href="{{ route('user.profile') }}">
                            Profile
                        </a>


                        <a href="{{ route('user.book-table') }}">
                            Reservations
                        </a>


                    @else

                        <a href="{{ route('login') }}">
                            User Login
                        </a>


                        <a href="{{ route('register') }}">
                            User Registration
                        </a>

                    @endauth


                </div>

            </div>


            <!-- STAFF / ADMIN -->

            <div>

                <h3 class="footer-title">
                    Restaurant Portal
                </h3>


                <div class="footer-links">


                    <a
                        href="{{ route('staff.login') }}"
                    >
                        Staff Login
                    </a>


                    <a
                        href="{{ route('staff.register') }}"
                    >
                        Staff Registration
                    </a>


                    <a
                        href="{{ route('admin.login') }}"
                    >
                        Admin Login
                    </a>


                    <a href="#reservation">
                        Book a Table
                    </a>


                    @auth

                        <a href="{{ route('user.menu') }}">
                            Order Online
                        </a>

                    @else

                        <a href="{{ route('login') }}">
                            Order Online
                        </a>

                    @endauth


                </div>

            </div>


        </div>


        <div class="footer-bottom">


            <span>

                © {{ date('Y') }}
                {{ config('app.name', 'BenStoke') }}.

                All rights reserved.

            </span>


            <span>
                Good food. Good mood.
            </span>


        </div>


    </div>

</footer>


<!-- ========================================================= -->
<!-- JAVASCRIPT -->
<!-- ========================================================= -->

<script>

    function toggleMobileMenu() {

        const navbar =
            document.getElementById('navbar');

        navbar.classList.toggle(
            'nav-mobile-open'
        );
    }


    document
        .querySelectorAll('.nav-links a')
        .forEach(function(link) {

            link.addEventListener(
                'click',
                function() {

                    document
                        .getElementById('navbar')
                        .classList
                        .remove(
                            'nav-mobile-open'
                        );

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | CLOSE MOBILE MENU WHEN CLICKING OUTSIDE
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function(event) {

            const navbar =
                document.getElementById('navbar');

            const toggle =
                document.querySelector('.menu-toggle');


            if (
                navbar.classList.contains(
                    'nav-mobile-open'
                ) &&
                !navbar.contains(event.target)
            ) {

                navbar.classList.remove(
                    'nav-mobile-open'
                );

            }

        }
    );

</script>


</body>

</html>

