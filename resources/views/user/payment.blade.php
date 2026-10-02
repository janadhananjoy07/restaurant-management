<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Payment | BenStoke</title>

    <!-- Cashfree JS SDK -->
    <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;

            font-family: Arial, sans-serif;

            background:
                linear-gradient(135deg,
                    #1c1917,
                    #0c0a09);

            color: white;
        }

        .payment-card {
            width: 100%;
            max-width: 500px;

            padding: 40px;

            background: #1c1917;

            border: 1px solid #292524;

            border-radius: 20px;

            text-align: center;

            box-shadow:
                0 25px 60px rgba(0, 0, 0, 0.5);
        }

        .logo {
            width: 60px;
            height: 60px;

            margin: 0 auto 20px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #f59e0b;

            color: #1c1917;

            border-radius: 15px;

            font-size: 26px;
            font-weight: 800;
        }

        h1 {
            margin-bottom: 10px;
        }

        .subtitle {
            color: #a8a29e;
            margin-bottom: 25px;
        }

        .order-info {
            padding: 20px;

            margin-bottom: 25px;

            background: #0c0a09;

            border: 1px solid #292524;

            border-radius: 14px;

            text-align: left;
        }

        .row {
            display: flex;
            justify-content: space-between;

            margin-bottom: 12px;

            color: #d6d3d1;
        }

        .row:last-child {
            margin-bottom: 0;
        }

        .amount {
            color: #f59e0b;
            font-size: 22px;
            font-weight: 700;
        }

        #pay-button {
            width: 100%;

            height: 52px;

            border: none;

            border-radius: 12px;

            background:
                linear-gradient(135deg,
                    #f59e0b,
                    #d97706);

            color: #1c1917;

            font-size: 15px;

            font-weight: 700;

            cursor: pointer;
        }

        #pay-button:hover {
            filter: brightness(1.08);
        }

        #pay-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .back-link {
            display: inline-block;

            margin-top: 20px;

            color: #a8a29e;

            text-decoration: none;
        }

        .back-link:hover {
            color: #f59e0b;
        }
    </style>
</head>

<body>

    <div class="payment-card">

        <div class="logo">
            B
        </div>

        <h1>
            Complete Payment
        </h1>

        <p class="subtitle">
            Secure payment for your BenStoke order
        </p>

        <div class="order-info">

            <div class="row">

                <span>
                    Order ID
                </span>

                <strong>
                    #{{ $order->id }}
                </strong>

            </div>

            <div class="row">

                <span>
                    Amount
                </span>

                <strong class="amount">
                    ₹{{ number_format($order->total_amount, 2) }}
                </strong>

            </div>

            <div class="row">

                <span>
                    Payment Status
                </span>

                <strong>
                    {{ ucfirst($order->payment_status ?? 'pending') }}
                </strong>

            </div>

        </div>

        <button type="button" id="pay-button">
            Pay ₹{{ number_format($order->total_amount, 2) }}
        </button>

        <a href="{{ route('user.orders') }}" class="back-link">
            ← Back to Orders
        </a>

    </div>


    <script>


        document.addEventListener('DOMContentLoaded', function () {

            const cashfree = Cashfree({
                mode: "{{ config('services.cashfree.environment', 'sandbox') }}"
            });

            const paymentSessionId = @json($paymentSessionId);

            const payButton = document.getElementById('pay-button');

            if (!paymentSessionId) {

                payButton.disabled = true;

                payButton.textContent = 'Payment session unavailable';

                return;
            }


            payButton.addEventListener('click', function () {

                payButton.disabled = true;

                payButton.textContent =
                    'Opening secure payment...';


                cashfree.checkout({

                    paymentSessionId: paymentSessionId,

                    redirectTarget: '_self'

                }).then(function (result) {

                    console.log(
                        'Cashfree checkout result:',
                        result
                    );


                    if (result?.error) {

                        console.error(
                            'Cashfree checkout error:',
                            result.error
                        );

                        alert(
                            result.error.message ||
                            'Unable to open payment gateway.'
                        );

                        payButton.disabled = false;

                        payButton.textContent =
                            'Pay ₹{{ number_format($order->total_amount, 2) }}';

                        return;
                    }


                    if (result?.paymentDetails) {

                        console.log(
                            'Payment completed. Server will verify status.',
                            result.paymentDetails
                        );

                    }

                }).catch(function (error) {

                    console.error(
                        'Cashfree checkout exception:',
                        error
                    );

                    alert(
                        'Unable to open Cashfree checkout.'
                    );

                    payButton.disabled = false;

                    payButton.textContent =
                        'Pay ₹{{ number_format($order->total_amount, 2) }}';

                });

            });

        });


        document.addEventListener('DOMContentLoaded', function () {

            const cashfree = Cashfree({
                mode: "{{ config('services.cashfree.environment', 'sandbox') }}"
            });

            const paymentSessionId =
                @json($paymentSessionId);

            const payButton =
                document.getElementById('pay-button');


            payButton.addEventListener('click', function () {

                payButton.disabled = true;

                payButton.textContent =
                    'Opening secure payment...';


                cashfree.checkout({

                    paymentSessionId: paymentSessionId,

                    redirectTarget: '_self'

                }).then(function (result) {

                    if (result.error) {

                        console.error(
                            'Cashfree checkout error:',
                            result.error
                        );

                        alert(
                            result.error.message ||
                            'Unable to open payment gateway.'
                        );

                        payButton.disabled = false;

                        payButton.textContent =
                            'Pay ₹{{ number_format($order->total_amount, 2) }}';

                    }

                });

            });

        });

    </script>

</body>

</html>