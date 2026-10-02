<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Complete Payment - Order #{{ $order->id }}
    </title>

    <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>

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

            background:
                linear-gradient(
                    135deg,
                    #f8fafc,
                    #e2e8f0
                );

            font-family:
                Arial,
                Helvetica,
                sans-serif;
        }

        .payment-card {
            width: 100%;
            max-width: 520px;

            background: white;

            border-radius: 18px;

            padding: 30px;

            box-shadow:
                0 15px 40px
                rgba(0, 0, 0, 0.12);
        }

        .title {
            margin: 0 0 8px;

            font-size: 26px;

            font-weight: 700;

            color: #111827;
        }

        .subtitle {
            margin: 0 0 25px;

            color: #6b7280;

            font-size: 15px;
        }

        .order-box {
            padding: 18px;

            border-radius: 12px;

            background: #f8fafc;

            margin-bottom: 25px;
        }

        .row {
            display: flex;

            justify-content: space-between;

            margin-bottom: 10px;

            font-size: 15px;
        }

        .row:last-child {
            margin-bottom: 0;
        }

        .label {
            color: #6b7280;
        }

        .value {
            font-weight: 600;

            color: #111827;
        }

        .amount {
            font-size: 22px;

            color: #16a34a;
        }

        .pay-button {
            width: 100%;

            border: 0;

            padding: 15px 20px;

            border-radius: 10px;

            background: #111827;

            color: white;

            font-size: 16px;

            font-weight: 700;

            cursor: pointer;
        }

        .pay-button:hover {
            opacity: 0.9;
        }

        .pay-button:disabled {
            opacity: 0.6;

            cursor: not-allowed;
        }

        .back-button {
            display: block;

            width: 100%;

            margin-top: 12px;

            padding: 13px 20px;

            border-radius: 10px;

            text-align: center;

            text-decoration: none;

            background: #e5e7eb;

            color: #111827;

            font-weight: 600;
        }

        .message {
            margin-top: 18px;

            padding: 12px;

            border-radius: 8px;

            background: #fef2f2;

            color: #b91c1c;

            display: none;
        }

    </style>

</head>

<body>

<div class="payment-card">

    <h1 class="title">
        Collect Online Payment
    </h1>

    <p class="subtitle">
        Complete the customer's payment before marking the order as delivered.
    </p>

    <div class="order-box">

        <div class="row">

            <span class="label">
                Order
            </span>

            <span class="value">
                #{{ $order->id }}
            </span>

        </div>

        <div class="row">

            <span class="label">
                Customer
            </span>

            <span class="value">
                {{ $order->user->name ?? 'Customer' }}
            </span>

        </div>

        <div class="row">

            <span class="label">
                Amount
            </span>

            <span class="value amount">
                ₹{{ number_format($order->total_amount, 2) }}
            </span>

        </div>

    </div>

    <button
        type="button"
        id="payButton"
        class="pay-button"
    >
        Pay Online
    </button>

    <a
        href="{{ route('staff.dashboard') }}"
        class="back-button"
    >
        Back to Staff Dashboard
    </a>

    <div
        id="message"
        class="message"
    ></div>

</div>


<script>

    const cashfree = Cashfree({
        mode: "production"
    });

    const payButton =
        document.getElementById('payButton');

    const message =
        document.getElementById('message');


    payButton.addEventListener(
        'click',
        async function () {

            payButton.disabled = true;

            payButton.innerText =
                'Opening Payment...';

            message.style.display = 'none';


            try {

                const result =
                    await cashfree.checkout({

                        paymentSessionId:
                            @json($paymentSessionId),

                        redirectTarget: "_self"
                    });


                if (result && result.error) {

                    console.error(
                        result.error
                    );

                    message.innerText =
                        result.error.message ||
                        'Unable to open payment.';

                    message.style.display =
                        'block';

                    payButton.disabled = false;

                    payButton.innerText =
                        'Pay Online';

                    return;
                }


            } catch (error) {

                console.error(error);

                message.innerText =
                    'Unable to open Cashfree payment. Please try again.';

                message.style.display =
                    'block';

                payButton.disabled = false;

                payButton.innerText =
                    'Pay Online';
            }

        }
    );

</script>

</body>

</html>

