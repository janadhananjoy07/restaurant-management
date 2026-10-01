<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | BenStoke</title>

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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 25px;
            overflow-x: hidden;
        }

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

        .register-wrapper {
            width: 100%;
            max-width: 1050px;
            min-height: 650px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: #1c1917;
            border: 1px solid #292524;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5);
            position: relative;
            z-index: 1;
            animation: pageEnter 0.5s ease both;
        }

        /* LEFT IMAGE */

        .register-image {
            position: relative;
            min-height: 650px;
            background:
                linear-gradient(
                    rgba(12, 10, 9, 0.35),
                    rgba(12, 10, 9, 0.9)
                ),
                url("https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1000&q=85");
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: flex-end;
            padding: 50px;
        }

        .register-image::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(
                    180deg,
                    transparent 25%,
                    rgba(12, 10, 9, 0.92) 100%
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
            box-shadow: 0 10px 30px rgba(245, 158, 11, 0.25);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .brand-logo:hover {
            transform: rotate(-5deg) scale(1.08);
            box-shadow: 0 15px 35px rgba(245, 158, 11, 0.35);
        }

        .brand-content h2 {
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            line-height: 1.1;
            color: white;
            margin-bottom: 12px;
        }

        .brand-content p {
            color: #d6d3d1;
            font-size: 14px;
            line-height: 1.7;
            max-width: 400px;
        }

        /* RIGHT PANEL */

        .register-panel {
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: linear-gradient(145deg, #1c1917, #171412);
        }

        .register-header {
            margin-bottom: 28px;
        }

        .small-title {
            color: #f59e0b;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .register-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            line-height: 1.2;
            color: white;
            margin-bottom: 8px;
        }

        .register-header p {
            color: #a8a29e;
            font-size: 13px;
            line-height: 1.6;
        }

        /* ERROR BOX */

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

        /* SUCCESS */

        .success-box {
            background: rgba(34, 197, 94, 0.08);
            border: 1px solid rgba(34, 197, 94, 0.25);
            color: #86efac;
            padding: 13px 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        /* FORM */

        .form-group {
            margin-bottom: 17px;
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

        .input-wrapper > i:first-child {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #78716c;
            font-size: 14px;
            pointer-events: none;
            transition: color 0.25s ease;
        }

        .input-wrapper input {
            width: 100%;
            height: 48px;
            padding: 0 15px 0 45px;
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

        .input-wrapper input:hover {
            border-color: #57534e;
        }

        .input-wrapper input:focus {
            border-color: #f59e0b;
            background: #141210;
            box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.08);
        }

        .input-wrapper:focus-within > i:first-child {
            color: #f59e0b;
        }

        /* PASSWORD INPUT */

        .password-wrapper input {
            padding-right: 48px;
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 30px;
            height: 30px;
            border: none;
            background: transparent;
            color: #78716c;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            margin: 0;
        }

        .password-toggle:hover {
            color: #f59e0b;
        }

        /* PASSWORD STRENGTH */

        .password-strength {
            margin-top: 9px;
        }

        .strength-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }

        .strength-label {
            font-size: 11px;
            color: #78716c;
        }

        .strength-text {
            font-size: 11px;
            font-weight: 700;
            color: #78716c;
        }

        .strength-bar {
            width: 100%;
            height: 5px;
            background: #292524;
            border-radius: 10px;
            overflow: hidden;
        }

        .strength-progress {
            width: 0%;
            height: 100%;
            border-radius: 10px;
            background: #57534e;
            transition: width 0.3s ease, background 0.3s ease;
        }

        /* REQUIREMENTS */

        .password-requirements {
            margin-top: 12px;
            padding: 12px 14px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid #292524;
            border-radius: 12px;
        }

        .requirements-title {
            font-size: 11px;
            font-weight: 700;
            color: #a8a29e;
            margin-bottom: 9px;
        }

        .requirements-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 7px 12px;
            list-style: none;
        }

        .requirements-list li {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 11px;
            color: #78716c;
            transition: color 0.2s ease;
        }

        .requirements-list li i {
            font-size: 9px;
            color: #57534e;
            transition: color 0.2s ease;
        }

        .requirements-list li.valid {
            color: #86efac;
        }

        .requirements-list li.valid i {
            color: #22c55e;
        }

        /* CONFIRM PASSWORD */

        .match-message {
            display: none;
            margin-top: 7px;
            font-size: 11px;
            font-weight: 600;
        }

        .match-message.match {
            display: block;
            color: #86efac;
        }

        .match-message.no-match {
            display: block;
            color: #fca5a5;
        }

        /* FIELD ERROR */

        .field-error {
            margin-top: 6px;
            font-size: 11px;
            color: #fca5a5;
        }

        .input-error {
            border-color: #ef4444 !important;
        }

        /* BUTTON */

        .register-button {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #1c1917;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            margin-top: 8px;
            box-shadow: 0 10px 25px rgba(245, 158, 11, 0.12);
            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease,
                filter 0.25s ease;
        }

        .register-button:hover {
            transform: translateY(-2px);
            filter: brightness(1.05);
            box-shadow: 0 14px 30px rgba(245, 158, 11, 0.2);
        }

        .register-button:active {
            transform: translateY(0);
        }

        .register-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* LOGIN */

        .login-link {
            text-align: center;
            margin-top: 23px;
            color: #78716c;
            font-size: 13px;
        }

        .login-link a {
            color: #f59e0b;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link a:hover {
            color: #fbbf24;
            text-decoration: underline;
        }

        .register-footer {
            text-align: center;
            color: #57534e;
            font-size: 11px;
            margin-top: 25px;
        }

        @keyframes pageEnter {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @media (max-width: 800px) {

            body {
                padding: 15px;
            }

            .register-wrapper {
                grid-template-columns: 1fr;
                max-width: 500px;
                min-height: auto;
                border-radius: 22px;
            }

            .register-image {
                min-height: 220px;
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

            .register-panel {
                padding: 35px 25px;
            }

            .register-header h1 {
                font-size: 30px;
            }
        }

        @media (max-width: 450px) {

            .register-image {
                min-height: 190px;
            }

            .register-panel {
                padding: 30px 20px;
            }

            .register-header h1 {
                font-size: 27px;
            }

            .requirements-list {
                grid-template-columns: 1fr;
            }
        }

        :focus-visible {
            outline: 3px solid rgba(245, 158, 11, 0.4);
            outline-offset: 3px;
        }
    </style>
</head>

<body>

<div class="register-wrapper">

    <!-- LEFT IMAGE -->

    <div class="register-image">

        <div class="brand-content">

            <div class="brand-logo">
                B
            </div>

            <h2>
                BenStoke
            </h2>

            <p>
                Create your account and discover an
                unforgettable dining experience.
                Explore our menu, place orders and
                reserve your favorite table.
            </p>

        </div>

    </div>


    <!-- RIGHT PANEL -->

    <div class="register-panel">

        <div class="register-header">

            <div class="small-title">
                Join BenStoke
            </div>

            <h1>
                Create your account
            </h1>

            <p>
                Register below to get started with
                your personalized dining experience.
            </p>

        </div>


        <!-- SUCCESS MESSAGE -->

        @if(session('success'))

            <div class="success-box">
                {{ session('success') }}
            </div>

        @endif


        <!-- VALIDATION ERRORS -->

        @if($errors->any())

            <div class="error-box">

                <strong>
                    Please fix the following:
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


        <!-- REGISTER FORM -->

        <form
            action="{{ route('register.store') }}"
            method="POST"
            id="registerForm"
        >

            @csrf


            <!-- NAME -->

            <div class="form-group">

                <label for="name">
                    Full Name
                </label>

                <div class="input-wrapper">

                    <i class="fa-solid fa-user"></i>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Enter your full name"
                        value="{{ old('name') }}"
                        required
                        autocomplete="name"
                    >

                </div>

                @error('name')

                    <div class="field-error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


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

                @error('email')

                    <div class="field-error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <!-- PASSWORD -->

            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <div class="input-wrapper password-wrapper">

                    <i class="fa-solid fa-lock"></i>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Create a strong password"
                        required
                        autocomplete="new-password"
                        minlength="6"
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        data-target="password"
                        aria-label="Show password"
                    >
                        <i class="fa-solid fa-eye"></i>
                    </button>

                </div>


                <!-- STRENGTH -->

                <div class="password-strength">

                    <div class="strength-header">

                        <span class="strength-label">
                            Password strength
                        </span>

                        <span
                            class="strength-text"
                            id="strengthText"
                        >
                            Enter password
                        </span>

                    </div>

                    <div class="strength-bar">

                        <div
                            class="strength-progress"
                            id="strengthProgress"
                        ></div>

                    </div>

                </div>


                <!-- REQUIREMENTS -->

                <div class="password-requirements">

                    <div class="requirements-title">
                        Password requirements
                    </div>

                    <ul class="requirements-list">

                        <li id="reqLength">

                            <i class="fa-solid fa-circle"></i>

                            At least 6 characters

                        </li>

                        <li id="reqUpper">

                            <i class="fa-solid fa-circle"></i>

                            One uppercase letter

                        </li>

                        <li id="reqLower">

                            <i class="fa-solid fa-circle"></i>

                            One lowercase letter

                        </li>

                        <li id="reqNumber">

                            <i class="fa-solid fa-circle"></i>

                            One number

                        </li>

                        <li id="reqSpecial">

                            <i class="fa-solid fa-circle"></i>

                            One special character

                        </li>

                    </ul>

                </div>


                @error('password')

                    <div class="field-error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <!-- CONFIRM PASSWORD -->

            <div class="form-group">

                <label for="password_confirmation">
                    Confirm Password
                </label>

                <div class="input-wrapper password-wrapper">

                    <i class="fa-solid fa-shield-halved"></i>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Re-enter your password"
                        required
                        autocomplete="new-password"
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        data-target="password_confirmation"
                        aria-label="Show password"
                    >
                        <i class="fa-solid fa-eye"></i>
                    </button>

                </div>

                <div
                    id="matchMessage"
                    class="match-message"
                ></div>

            </div>


            <!-- REGISTER BUTTON -->

            <button
                type="submit"
                class="register-button"
                id="registerButton"
            >

                <span>
                    Create Account
                </span>

                <i class="fa-solid fa-arrow-right"></i>

            </button>

        </form>


        <!-- LOGIN -->

        <div class="login-link">

            Already have an account?

            <a href="{{ route('login') }}">
                Login here
            </a>

        </div>


        <!-- FOOTER -->

        <div class="register-footer">

            © {{ date('Y') }} BenStoke.
            All rights reserved.

        </div>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const password =
        document.getElementById('password');

    const confirmation =
        document.getElementById('password_confirmation');

    const strengthText =
        document.getElementById('strengthText');

    const strengthProgress =
        document.getElementById('strengthProgress');

    const matchMessage =
        document.getElementById('matchMessage');

    const registerForm =
        document.getElementById('registerForm');


    /*
    |--------------------------------------------------------------------------
    | SHOW / HIDE PASSWORD
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.password-toggle')
        .forEach(function (button) {

            button.addEventListener('click', function () {

                const targetId =
                    button.getAttribute('data-target');

                const input =
                    document.getElementById(targetId);

                const icon =
                    button.querySelector('i');

                if (input.type === 'password') {

                    input.type = 'text';

                    icon.classList.remove('fa-eye');

                    icon.classList.add('fa-eye-slash');

                    button.setAttribute(
                        'aria-label',
                        'Hide password'
                    );

                } else {

                    input.type = 'password';

                    icon.classList.remove('fa-eye-slash');

                    icon.classList.add('fa-eye');

                    button.setAttribute(
                        'aria-label',
                        'Show password'
                    );
                }

            });

        });


    /*
    |--------------------------------------------------------------------------
    | PASSWORD REQUIREMENTS
    |--------------------------------------------------------------------------
    */

    function updateRequirement(
        elementId,
        valid
    ) {

        const element =
            document.getElementById(elementId);

        const icon =
            element.querySelector('i');

        if (valid) {

            element.classList.add('valid');

            icon.classList.remove(
                'fa-circle'
            );

            icon.classList.add(
                'fa-circle-check'
            );

        } else {

            element.classList.remove('valid');

            icon.classList.remove(
                'fa-circle-check'
            );

            icon.classList.add(
                'fa-circle'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | PASSWORD STRENGTH
    |--------------------------------------------------------------------------
    */

    function updatePasswordStrength() {

        const value =
            password.value;

        const lengthValid =
            value.length >= 6;

        const upperValid =
            /[A-Z]/.test(value);

        const lowerValid =
            /[a-z]/.test(value);

        const numberValid =
            /[0-9]/.test(value);

        const specialValid =
            /[^A-Za-z0-9]/.test(value);


        updateRequirement(
            'reqLength',
            lengthValid
        );

        updateRequirement(
            'reqUpper',
            upperValid
        );

        updateRequirement(
            'reqLower',
            lowerValid
        );

        updateRequirement(
            'reqNumber',
            numberValid
        );

        updateRequirement(
            'reqSpecial',
            specialValid
        );


        let score = 0;

        if (lengthValid) score++;

        if (upperValid) score++;

        if (lowerValid) score++;

        if (numberValid) score++;

        if (specialValid) score++;


        if (!value.length) {

            strengthProgress.style.width = '0%';

            strengthText.textContent =
                'Enter password';

            strengthText.style.color =
                '#78716c';

        } else if (score <= 2) {

            strengthProgress.style.width =
                '35%';

            strengthProgress.style.background =
                '#ef4444';

            strengthText.textContent =
                'Weak';

            strengthText.style.color =
                '#f87171';

        } else if (score === 3 || score === 4) {

            strengthProgress.style.width =
                '70%';

            strengthProgress.style.background =
                '#f59e0b';

            strengthText.textContent =
                'Medium';

            strengthText.style.color =
                '#fbbf24';

        } else {

            strengthProgress.style.width =
                '100%';

            strengthProgress.style.background =
                '#22c55e';

            strengthText.textContent =
                'Strong';

            strengthText.style.color =
                '#86efac';
        }


        updatePasswordMatch();

    }


    /*
    |--------------------------------------------------------------------------
    | CONFIRM PASSWORD MATCH
    |--------------------------------------------------------------------------
    */

    function updatePasswordMatch() {

        const value =
            confirmation.value;

        if (!value) {

            matchMessage.style.display =
                'none';

            confirmation.classList.remove(
                'input-error'
            );

            return;
        }


        if (password.value === value) {

            matchMessage.textContent =
                '✓ Passwords match';

            matchMessage.className =
                'match-message match';

            confirmation.classList.remove(
                'input-error'
            );

        } else {

            matchMessage.textContent =
                '✕ Passwords do not match';

            matchMessage.className =
                'match-message no-match';

            confirmation.classList.add(
                'input-error'
            );
        }
    }


    password.addEventListener(
        'input',
        updatePasswordStrength
    );

    confirmation.addEventListener(
        'input',
        updatePasswordMatch
    );


    /*
    |--------------------------------------------------------------------------
    | FORM SUBMISSION VALIDATION
    |--------------------------------------------------------------------------
    */

    registerForm.addEventListener(
        'submit',
        function (event) {

            const value =
                password.value;

            const confirmValue =
                confirmation.value;


            const strongEnough =
                value.length >= 6 &&
                /[A-Z]/.test(value) &&
                /[a-z]/.test(value) &&
                /[0-9]/.test(value) &&
                /[^A-Za-z0-9]/.test(value);


            if (!strongEnough) {

                event.preventDefault();

                password.focus();

                strengthText.textContent =
                    'Please use a stronger password';

                strengthText.style.color =
                    '#f87171';

                return;
            }


            if (value !== confirmValue) {

                event.preventDefault();

                confirmation.focus();

                matchMessage.textContent =
                    '✕ Passwords do not match';

                matchMessage.className =
                    'match-message no-match';

                return;
            }

        }
    );

});

</script>

</body>
</html>
