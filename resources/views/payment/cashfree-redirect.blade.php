<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Redirecting to Payment</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0c0a09;
            color: #ffffff;
            font-family: Arial, sans-serif;
        }

        .payment-box {
            width: 90%;
            max-width: 420px;
            padding: 40px;
            text-align: center;
            background: #1c1917;
            border: 1px solid #292524;
            border-radius: 18px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .4);
        }

        .loader {
            width: 45px;
            height: 45px;
            margin: 0 auto 20px;
            border: 4px solid #44403c;
            border-top-color: #f59e0b;
            border-radius: 50%;
            animation: spin .8s linear infinite;
        }

        h1 {
            margin: 0 0 10px;
            font-size: 22px;
        }

        p {
            margin: 0;
            color: #a8a29e;
            font-size: 14px;
            line-height: 1.6;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>

    <div class="payment-box">

        <div class="loader"></div>

        <h1>
            Redirecting to payment...
        </h1>

        <p>
            Please wait while we securely connect you
            to the payment gateway.
        </p>

        <form
            id="cashfreeForm"
            action="{{ route('payment.cashfree.create') }}"
            method="POST"
        >

            @csrf

            <input
                type="hidden"
                name="order_id"
                value="{{ $order->id }}"
            >

        </form>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {

            document
                .getElementById('cashfreeForm')
                .submit();

        });
    </script>

</body>

</html>

