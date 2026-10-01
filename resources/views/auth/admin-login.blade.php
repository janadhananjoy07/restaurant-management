<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login | TastyBite</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;

            font-family: Arial, Helvetica, sans-serif;

            display: flex;
            align-items: center;
            justify-content: center;

            background:
                linear-gradient(
                    135deg,
                    rgba(0,0,0,.94),
                    rgba(25,25,25,.94)
                );
        }


        .login-container {
            width: 900px;
            max-width: 94%;

            min-height: 540px;

            display: grid;
            grid-template-columns: 1fr 1fr;

            background: #171717;

            border-radius: 25px;

            overflow: hidden;

            box-shadow:
                0 25px 80px rgba(0,0,0,.55);

            border: 1px solid #292929;
        }


        /* LEFT SIDE */

        .login-left {
            padding: 55px;

            display: flex;
            flex-direction: column;
            justify-content: center;

            background:
                linear-gradient(
                    rgba(0,0,0,.65),
                    rgba(0,0,0,.78)
                ),
                url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1000&q=85');

            background-size: cover;
            background-position: center;
        }


        .brand {
            font-size: 28px;

            font-weight: 800;

            margin-bottom: 70px;
        }


        .brand span {
            color: #f4b41a;
        }


        .login-left h1 {
            font-size: 48px;

            line-height: 1.1;

            margin-bottom: 20px;
        }


        .login-left h1 span {
            color: #f4b41a;
        }


        .login-left p {
            color: #c0c0c0;

            line-height: 1.7;

            max-width: 350px;
        }


        .admin-badge {
            display: inline-block;

            margin-top: 35px;

            width: fit-content;

            padding: 10px 18px;

            border: 1px solid #f4b41a;

            border-radius: 30px;

            color: #f4b41a;

            font-size: 13px;

            font-weight: 700;

            letter-spacing: 1px;
        }


        /* RIGHT SIDE */

        .login-right {
            padding: 55px;

            display: flex;
            flex-direction: column;
            justify-content: center;
        }


        .login-right h2 {
            font-size: 32px;

            margin-bottom: 10px;
        }


        .subtitle {
            color: #888;

            margin-bottom: 35px;

            font-size: 14px;
        }


        /* SUCCESS */

        .success {
            background: rgba(40, 180, 100, .12);

            border: 1px solid rgba(40, 180, 100, .35);

            color: #69e29a;

            padding: 12px 15px;

            border-radius: 10px;

            margin-bottom: 20px;

            font-size: 14px;
        }


        /* ERROR */

        .errors {
            background: rgba(220, 50, 50, .12);

            border: 1px solid rgba(220, 50, 50, .35);

            color: #ff7777;

            padding: 12px 15px;

            border-radius: 10px;

            margin-bottom: 20px;

            font-size: 14px;
        }


        .form-group {
            margin-bottom: 20px;
        }


        .form-group label {
            display: block;

            margin-bottom: 8px;

            color: #ddd;

            font-size: 14px;

            font-weight: 600;
        }


        .input-wrapper {
            position: relative;
        }


        .input-wrapper span {
            position: absolute;

            left: 15px;

            top: 50%;

            transform: translateY(-50%);

            color: #777;
        }


        .form-control {
            width: 100%;

            padding: 14px 15px 14px 43px;

            background: #222;

            border: 1px solid #333;

            color: #fff;

            border-radius: 10px;

            outline: none;

            font-size: 14px;

            transition: .3s;
        }


        .form-control:focus {
            border-color: #f4b41a;

            box-shadow: 0 0 0 3px rgba(244,180,26,.08);
        }


        .login-button {
            width: 100%;

            border: none;

            padding: 15px;

            margin-top: 10px;

            border-radius: 10px;

            background: #f4b41a;

            color: #111;

            font-size: 15px;

            font-weight: 800;

            cursor: pointer;

            transition: .3s;
        }


        .login-button:hover {
            background: #fff;

            transform: translateY(-2px);
        }


        .back-link {
            text-align: center;

            margin-top: 25px;

            color: #777;

            font-size: 13px;
        }


        .back-link a {
            color: #f4b41a;

            text-decoration: none;
        }


        .security-note {
            margin-top: 30px;

            padding: 12px;

            border-radius: 10px;

            background: #202020;

            color: #777;

            font-size: 12px;

            text-align: center;
        }


        /* MOBILE */

        @media(max-width: 700px) {

            .login-container {
                grid-template-columns: 1fr;
            }

            .login-left {
                min-height: 250px;

                padding: 35px;
            }

            .brand {
                margin-bottom: 30px;
            }

            .login-left h1 {
                font-size: 35px;
            }

            .login-right {
                padding: 35px;
            }
        }

    </style>

</head>


<body>


<div class="login-container">


    <!-- LEFT -->

    <div class="login-left">

        <div class="brand">
            Tasty<span>Bite</span>
        </div>


        <h1>
            Welcome,
            <br>
            <span>Admin.</span>
        </h1>


        <p>
            Manage your restaurant, food menu, orders,
            customers and everything from one powerful
            dashboard.
        </p>


        <div class="admin-badge">
            ADMINISTRATION PANEL
        </div>

    </div>


    <!-- RIGHT -->

    <div class="login-right">

        <h2>
            Admin Login
        </h2>


        <p class="subtitle">
            Sign in to access the restaurant management system.
        </p>


        @if(session('success'))

            <div class="success">
                {{ session('success') }}
            </div>

        @endif


        @if($errors->any())

            <div class="errors">

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif


        <form
            method="POST"
            action="{{ route('admin.login.store') }}"
        >

            @csrf


            <!-- EMAIL -->

            <div class="form-group">

                <label for="email">
                    Email Address
                </label>


                <div class="input-wrapper">

                    <span>
                        ✉
                    </span>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        placeholder="admin@example.com"
                        value="{{ old('email') }}"
                        required
                    >

                </div>

            </div>


            <!-- PASSWORD -->

            <div class="form-group">

                <label for="password">
                    Password
                </label>


                <div class="input-wrapper">

                    <span>
                        🔒
                    </span>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="Enter your password"
                        required
                    >

                </div>

            </div>


            <!-- LOGIN -->

            <button
                type="submit"
                class="login-button"
            >
                Login to Admin Panel
            </button>

        </form>


        <div class="back-link">

            <!-- <a href="{{ ->name('home'); }}"> -->
             <a href="{{ route('home') }}">
                ← Back to Restaurant
            </a>

        </div>


        <div class="security-note">

            🔐 This area is restricted to authorized administrators.

        </div>

    </div>

</div>


</body>

</html>
