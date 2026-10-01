<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | BenStoke</title>

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet"
    >

    <style>

        /* ================================
           RESET
           ================================ */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
        }

        body {
            font-family: 'Inter', sans-serif;

            background:
                linear-gradient(
                    135deg,
                    rgba(28, 25, 23, 0.97),
                    rgba(12, 10, 9, 1)
                );

            color: #fff;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 25px;

            overflow-x: hidden;
        }


        /* ================================
           BACKGROUND
           ================================ */

        body::before {
            content: "";

            position: fixed;

            width: 500px;
            height: 500px;

            background: rgba(245, 158, 11, 0.08);

            border-radius: 50%;

            filter: blur(100px);

            top: -200px;
            right: -150px;

            pointer-events: none;
        }

        body::after {
            content: "";

            position: fixed;

            width: 400px;
            height: 400px;

            background: rgba(245, 158, 11, 0.05);

            border-radius: 50%;

            filter: blur(100px);

            bottom: -200px;
            left: -150px;

            pointer-events: none;
        }


        /* ================================
           LOGIN CONTAINER
           ================================ */

        .login-wrapper {

            width: 100%;
            max-width: 1050px;

            min-height: 620px;

            display: grid;

            grid-template-columns: 1fr 1fr;

            background: #1c1917;

            border: 1px solid #292524;

            border-radius: 28px;

            overflow: hidden;

            box-shadow:
                0 30px 80px rgba(0, 0, 0, 0.5);

            position: relative;

            z-index: 1;
        }


        /* ================================
           LEFT SIDE
           ================================ */

        .login-image {

            position: relative;

            min-height: 620px;

            background:
                linear-gradient(
                    rgba(12, 10, 9, 0.45),
                    rgba(12, 10, 9, 0.85)
                ),
                url("https://images.unsplash.com/photo-1515003197210-e0cd71810b5f?auto=format&fit=crop&w=1000&q=85");

            background-size: cover;

            background-position: center;

            display: flex;

            align-items: flex-end;

            padding: 50px;
        }


        .login-image::after {

            content: "";

            position: absolute;

            inset: 0;

            background:
                linear-gradient(
                    180deg,
                    transparent 30%,
                    rgba(12, 10, 9, 0.9) 100%
                );
        }


        .brand-content {

            position: relative;

            z-index: 2;
        }


        .brand-logo {

            width: 55px;
            height: 55px;

            background: #f59e0b;

            color: #1c1917;

            border-radius: 16px;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 24px;

            font-weight: 800;

            margin-bottom: 22px;

            box-shadow:
                0 10px 30px rgba(245, 158, 11, 0.25);
        }


        .brand-content h2 {

            font-family: 'Playfair Display', serif;

            font-size: 42px;

            line-height: 1.1;

            margin-bottom: 12px;

            color: white;
        }


        .brand-content p {

            color: #d6d3d1;

            font-size: 14px;

            line-height: 1.7;

            max-width: 400px;
        }


        /* ================================
           RIGHT LOGIN AREA
           ================================ */

        .login-panel {

            padding: 55px;

            display: flex;

            flex-direction: column;

            justify-content: center;

            background:
                linear-gradient(
                    145deg,
                    #1c1917,
                    #171412
                );
        }


        .login-header {

            margin-bottom: 30px;
        }


        .login-header .small-title {

            color: #f59e0b;

            font-size: 11px;

            font-weight: 700;

            letter-spacing: 3px;

            text-transform: uppercase;

            margin-bottom: 10px;
        }


        .login-header h1 {

            font-family: 'Playfair Display', serif;

            font-size: 36px;

            line-height: 1.2;

            color: white;

            margin-bottom: 8px;
        }


        .login-header p {

            color: #a8a29e;

            font-size: 13px;

            line-height: 1.6;
        }


        /* ================================
           SUCCESS MESSAGE
           ================================ */

        .success-message {

            display: flex;

            align-items: center;

            gap: 10px;

            background: rgba(16, 185, 129, 0.08);

            border: 1px solid rgba(16, 185, 129, 0.25);

            color: #6ee7b7;

            padding: 13px 15px;

            border-radius: 12px;

            font-size: 13px;

            margin-bottom: 20px;
        }


        /* ================================
           ERROR MESSAGE
           ================================ */

        .error-box {

            background: rgba(239, 68, 68, 0.08);

            border: 1px solid rgba(239, 68, 68, 0.25);

            color: #fca5a5;

            padding: 13px 15px;

            border-radius: 12px;

            margin-bottom: 20px;

            font-size: 13px;
        }


        .error-box ul {

            margin-left: 18px;
        }


        .error-box li {

            margin-bottom: 4px;
        }


        /* ================================
           FORM
           ================================ */

        .form-group {

            margin-bottom: 20px;
        }


        .form-group label {

            display: block;

            font-size: 12px;

            font-weight: 600;

            color: #d6d3d1;

            margin-bottom: 8px;
        }


        .input-wrapper {

            position: relative;
        }


        .input-wrapper i {

            position: absolute;

            left: 16px;

            top: 50%;

            transform: translateY(-50%);

            color: #78716c;

            font-size: 14px;

            transition: color 0.25s ease;

            pointer-events: none;
        }


        .input-wrapper input {

            width: 100%;

            height: 50px;

            padding:
                0 15px 0 45px;

            border-radius: 12px;

            border: 1px solid #44403c;

            background: #0c0a09;

            color: white;

            font-family: 'Inter', sans-serif;

            font-size: 14px;

            outline: none;

            transition:
                border-color 0.25s ease,
                box-shadow 0.25s ease,
                background 0.25s ease;
        }


        .input-wrapper input::placeholder {

            color: #57534e;
        }


        .input-wrapper input:focus {

            border-color: #f59e0b;

            background: #141210;

            box-shadow:
                0 0 0 4px rgba(245, 158, 11, 0.08);
        }


        .input-wrapper:focus-within i {

            color: #f59e0b;
        }


        /* ================================
           LOGIN BUTTON
           ================================ */

        .login-button {

            width: 100%;

            height: 50px;

            border: none;

            border-radius: 12px;

            background:
                linear-gradient(
                    135deg,
                    #f59e0b,
                    #d97706
                );

            color: #1c1917;

            font-family: 'Inter', sans-serif;

            font-size: 14px;

            font-weight: 700;

            cursor: pointer;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 9px;

            margin-top: 5px;

            box-shadow:
                0 10px 25px rgba(245, 158, 11, 0.12);

            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease,
                filter 0.25s ease;
        }


        .login-button:hover {

            transform: translateY(-2px);

            filter: brightness(1.05);

            box-shadow:
                0 14px 30px rgba(245, 158, 11, 0.2);
        }


        .login-button:active {

            transform: translateY(0);
        }


        /* ================================
           REGISTER LINK
           ================================ */

        .register-link {

            text-align: center;

            margin-top: 25px;

            color: #78716c;

            font-size: 13px;
        }


        .register-link a {

            color: #f59e0b;

            font-weight: 600;

            text-decoration: none;

            transition: color 0.2s ease;
        }


        .register-link a:hover {

            color: #fbbf24;

            text-decoration: underline;
        }


        /* ================================
           FOOTER
           ================================ */

        .login-footer {

            text-align: center;

            color: #57534e;

            font-size: 11px;

            margin-top: 30px;
        }


        /* ================================
           MOBILE
           ================================ */

        @media (max-width: 800px) {

            body {
                padding: 15px;
            }

            .login-wrapper {

                grid-template-columns: 1fr;

                max-width: 500px;

                min-height: auto;

                border-radius: 22px;
            }

            .login-image {

                min-height: 230px;

                padding: 30px;
            }

            .brand-content h2 {

                font-size: 30px;
            }

            .brand-content p {

                font-size: 12px;
            }

            .brand-logo {

                width: 45px;
                height: 45px;

                font-size: 19px;

                margin-bottom: 14px;
            }

            .login-panel {

                padding: 35px 25px;
            }

            .login-header h1 {

                font-size: 30px;
            }
        }


        /* ================================
           SMALL MOBILE
           ================================ */

        @media (max-width: 450px) {

            .login-image {

                min-height: 190px;
            }

            .login-panel {

                padding: 30px 20px;
            }

            .login-header h1 {

                font-size: 27px;
            }
        }


        /* ================================
           ACCESSIBILITY
           ================================ */

        :focus-visible {

            outline:
                3px solid
                rgba(245, 158, 11, 0.4);

            outline-offset: 3px;
        }

    </style>

</head>


<body>


    <!-- =====================================================
         LOGIN WRAPPER
         ===================================================== -->

    <div class="login-wrapper">


        <!-- =================================================
             LEFT IMAGE / BRAND
             ================================================= -->

        <div class="login-image">

            <div class="brand-content">

                <div class="brand-logo">
                    B
                </div>

                <h2>
                    BenStoke
                </h2>

                <p>
                    Welcome back to your dining experience.
                    Sign in to explore our menu, manage your
                    orders and reserve your favorite table.
                </p>

            </div>

        </div>


        <!-- =================================================
             RIGHT LOGIN FORM
             ================================================= -->

        <div class="login-panel">


            <!-- HEADER -->

            <div class="login-header">

                <div class="small-title">
                    Welcome Back
                </div>

                <h1>
                    Sign in to your account
                </h1>

                <p>
                    Enter your details below to continue
                    to your dashboard.
                </p>

            </div>


            <!-- SUCCESS MESSAGE -->

            @if(session('success'))

                <div class="success-message">

                    <i class="fa-solid fa-circle-check"></i>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            @endif


            <!-- ERROR MESSAGE -->

            @if($errors->any())

                <div class="error-box">

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <!-- LOGIN FORM -->

            <form
                action="/login"
                method="POST"
            >

                @csrf


                <!-- EMAIL -->

                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <div class="input-wrapper">

                        <i class="fa-solid fa-envelope"></i>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Enter your email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                        >

                    </div>

                </div>


                <!-- PASSWORD -->

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <div class="input-wrapper">

                        <i class="fa-solid fa-lock"></i>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            required
                            autocomplete="current-password"
                        >

                    </div>

                </div>


                <!-- LOGIN BUTTON -->

                <button
                    type="submit"
                    class="login-button"
                >

                    <span>
                        Login to Dashboard
                    </span>

                    <i class="fa-solid fa-arrow-right"></i>

                </button>

            </form>


            <!-- REGISTER -->

            <div class="register-link">

                Don't have an account?

                <a href="/register">
                    Create an account
                </a>

            </div>


            <!-- FOOTER -->

            <div class="login-footer">

                © {{ date('Y') }} BenStoke.
                All rights reserved.

            </div>

        </div>

    </div>


</body>

</html>
