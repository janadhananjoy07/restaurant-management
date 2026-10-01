<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Foodie | Welcome</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;

            font-family: Arial, Helvetica, sans-serif;

            background:
                linear-gradient(
                    135deg,
                    #111827,
                    #374151
                );

            display: flex;

            justify-content: center;

            align-items: center;

            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 900px;

            text-align: center;
        }

        .logo {
            font-size: 65px;

            margin-bottom: 10px;
        }

        h1 {
            color: #f59e0b;

            font-size: 45px;

            margin-bottom: 10px;
        }

        .subtitle {
            color: #d1d5db;

            font-size: 17px;

            margin-bottom: 45px;
        }

        .cards {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 25px;
        }

        .card {
            background: white;

            padding: 40px 30px;

            border-radius: 20px;

            text-decoration: none;

            transition: .25s;

            box-shadow:
                0 15px 40px rgba(0,0,0,.25);
        }

        .card:hover {
            transform: translateY(-8px);

            box-shadow:
                0 25px 50px rgba(0,0,0,.35);
        }

        .icon {
            font-size: 55px;

            margin-bottom: 18px;
        }

        .card h2 {
            color: #111827;

            font-size: 25px;

            margin-bottom: 10px;
        }

        .card p {
            color: #777;

            font-size: 14px;

            line-height: 1.6;

            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;

            padding: 12px 25px;

            border-radius: 8px;

            color: white;

            font-weight: bold;

            background: #f59e0b;
        }

        .admin .btn {
            background: #111827;
        }

        .register {
            margin-top: 35px;

            color: #d1d5db;
        }

        .register a {
            color: #f59e0b;

            font-weight: bold;

            text-decoration: none;
        }

        @media(max-width: 650px) {

            .cards {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 36px;
            }

        }

    </style>

</head>


<body>


<div class="container">


    <div class="logo">
        🍴
    </div>

    <h1>
        Welcome to Foodie
    </h1>

    <p class="subtitle">
        Choose how you want to continue
    </p>


    <div class="cards">


        <!-- USER -->

        <a
            href="{{ url('/login') }}"
            class="card">

            <div class="icon">
                👤
            </div>

            <h2>
                Login as User
            </h2>

            <p>
                Browse our delicious menu,
                place orders and enjoy your
                favorite food.
            </p>

            <span class="btn">
                User Login →
            </span>

        </a>



        <!-- ADMIN -->

        <a
            href="{{ url('/admin') }}"
            class="card admin">

            <div class="icon">
                👨‍💼
            </div>

            <h2>
                Login as Admin
            </h2>

            <p>
                Manage menu items, users,
                restaurant content and
                your dashboard.
            </p>

            <span class="btn">
                Admin Login →
            </span>

        </a>

    </div>


    <div class="register">

        New customer?

        <a href="{{ url('/register') }}">
            Create an account
        </a>

    </div>


</div>


</body>

</html>
