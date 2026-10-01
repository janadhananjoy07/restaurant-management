
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Registration | Restaurant</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 20px;
            background: #f3f4f6;
            font-family: Arial, sans-serif;
            color: #111827;
        }

        .card {
            width: 100%;
            max-width: 460px;
            background: white;
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 10px 35px #00000012;
        }

        h1 { margin: 0 0 8px; }
        .muted { color: #6b7280; line-height: 1.5; }

        label {
            display: block;
            margin: 16px 0 7px;
            font-size: 14px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
        }

        button {
            width: 100%;
            margin-top: 20px;
            padding: 13px;
            border: 0;
            border-radius: 8px;
            background: #111827;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .alert {
            padding: 12px;
            border-radius: 8px;
            margin: 15px 0;
            background: #fee2e2;
            color: #991b1b;
            font-size: 14px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        a { color: #b45309; font-weight: bold; }
        .bottom { margin-top: 20px; text-align: center; font-size: 14px; }
    </style>
</head>
<body>

<div class="card">
    <h1>Staff Registration</h1>
    <p class="muted">
        Apply to join our restaurant team. Your account will require admin approval.
    </p>

    @if (session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('staff.register.store') }}">
        @csrf

        <label for="name">Full Name</label>
        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name') }}"
            required
            maxlength="255"
            autocomplete="name"
        >

        <label for="email">Email Address</label>
        <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            required
            maxlength="255"
            autocomplete="email"
        >

        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            required
            minlength="8"
            autocomplete="new-password"
        >

        <label for="password_confirmation">Confirm Password</label>
        <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            required
            minlength="8"
            autocomplete="new-password"
        >

        <button type="submit">Submit Staff Application</button>
    </form>

    <div class="bottom">
        Already approved?
        <a href="{{ route('staff.login') }}">Staff Login</a>
    </div>

    <div class="bottom">
        <a href="{{ route('home') }}">Back to Website</a>
    </div>
</div>

</body>
</html>
