<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Staff Dashboard | BenStoke</title>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- Google Fonts --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet">

    <style>
        /* =========================================================
           RESET
        ========================================================= */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #0c0a09;
            color: #f5f5f4;
            min-height: 100vh;
        }

        button,
        input,
        select {
            font-family: inherit;
        }

        a {
            color: inherit;
            text-decoration: none;
        }


        /* =========================================================
           APP
        ========================================================= */

        .app {
            min-height: 100vh;
            display: flex;
        }


        /* =========================================================
           SIDEBAR
        ========================================================= */

        .sidebar {
            width: 250px;
            min-height: 100vh;

            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;

            background:
                linear-gradient(180deg,
                    #1c1917,
                    #0f0d0c);

            border-right: 1px solid #292524;

            padding: 28px 18px;

            z-index: 100;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;

            padding: 0 10px 30px;

            border-bottom: 1px solid #292524;
        }

        .brand-icon {
            width: 44px;
            height: 44px;

            border-radius: 13px;

            display: flex;
            align-items: center;
            justify-content: center;

            background:
                linear-gradient(135deg,
                    #f59e0b,
                    #d97706);

            color: #1c1917;

            font-size: 19px;
            font-weight: 800;

            box-shadow:
                0 8px 25px rgba(245, 158, 11, .15);
        }

        .brand-text strong {
            display: block;

            font-family:
                'Playfair Display',
                serif;

            font-size: 20px;

            color: #fff;
        }

        .brand-text span {
            display: block;

            color: #78716c;

            font-size: 10px;
            font-weight: 700;

            letter-spacing: 1.5px;
            text-transform: uppercase;

            margin-top: 3px;
        }


        /* =========================================================
           NAVIGATION
        ========================================================= */

        .nav {
            padding-top: 28px;
        }

        .nav-label {
            color: #57534e;

            font-size: 10px;
            font-weight: 700;

            letter-spacing: 1.5px;
            text-transform: uppercase;

            padding: 0 12px 10px;
        }

        .nav-link {
            display: flex;
            align-items: center;

            gap: 12px;

            padding: 12px;
            margin-bottom: 5px;

            border-radius: 11px;

            color: #a8a29e;

            font-size: 13px;
            font-weight: 600;

            transition:
                background .2s ease,
                color .2s ease,
                transform .2s ease;
        }

        .nav-link i {
            width: 18px;
            text-align: center;
        }

        .nav-link:hover {
            background: rgba(245, 158, 11, .08);

            color: #fbbf24;

            transform: translateX(2px);
        }

        .nav-link.active {
            background:
                linear-gradient(135deg,
                    rgba(245, 158, 11, .16),
                    rgba(217, 119, 6, .08));

            color: #fbbf24;

            border: 1px solid rgba(245, 158, 11, .12);
        }


        /* =========================================================
           SIDEBAR BOTTOM
        ========================================================= */

        .sidebar-bottom {
            position: absolute;

            left: 18px;
            right: 18px;
            bottom: 25px;
        }

        .staff-mini {
            padding: 14px;

            border-radius: 14px;

            background: #171412;

            border: 1px solid #292524;

            margin-bottom: 10px;
        }

        .staff-mini-title {
            font-size: 10px;

            color: #78716c;

            text-transform: uppercase;

            letter-spacing: 1px;

            margin-bottom: 6px;
        }

        .staff-mini-name {
            font-size: 13px;

            font-weight: 700;

            color: #f5f5f4;
        }

        .staff-mini-role {
            color: #a8a29e;

            font-size: 11px;

            margin-top: 3px;
        }

        .logout-form button {
            width: 100%;

            border: 1px solid #292524;

            background: transparent;

            color: #a8a29e;

            border-radius: 11px;

            padding: 11px;

            cursor: pointer;

            font-size: 12px;
            font-weight: 600;

            transition: .2s ease;
        }

        .logout-form button:hover {
            background: rgba(239, 68, 68, .08);

            border-color: rgba(239, 68, 68, .25);

            color: #fca5a5;
        }


        /* =========================================================
           MAIN
        ========================================================= */

        .main {
            width: calc(100% - 250px);

            margin-left: 250px;

            min-height: 100vh;

            padding: 35px;
        }


        /* =========================================================
           MOBILE HEADER
        ========================================================= */

        .mobile-header {
            display: none;
        }


        /* =========================================================
           TOP HEADER
        ========================================================= */

        .topbar {
            display: flex;

            align-items: center;
            justify-content: space-between;

            margin-bottom: 30px;
        }

        .page-title small {
            display: block;

            color: #f59e0b;

            font-size: 10px;
            font-weight: 800;

            letter-spacing: 2px;

            text-transform: uppercase;

            margin-bottom: 7px;
        }

        .page-title h1 {
            font-family:
                'Playfair Display',
                serif;

            font-size: 34px;

            color: #fff;
        }

        .page-title p {
            color: #78716c;

            font-size: 12px;

            margin-top: 6px;
        }

        .top-date {
            padding: 11px 15px;

            border-radius: 12px;

            background: #171412;

            border: 1px solid #292524;

            color: #a8a29e;

            font-size: 12px;
        }

        .top-date i {
            color: #f59e0b;

            margin-right: 6px;
        }


        /* =========================================================
           ALERT
        ========================================================= */

        .alert {
            padding: 13px 16px;

            border-radius: 12px;

            margin-bottom: 20px;

            font-size: 13px;

            display: flex;

            align-items: flex-start;

            gap: 10px;
        }

        .alert-success {
            background: rgba(34, 197, 94, .08);

            border: 1px solid rgba(34, 197, 94, .2);

            color: #86efac;
        }

        .alert-error {
            background: rgba(239, 68, 68, .08);

            border: 1px solid rgba(239, 68, 68, .2);

            color: #fca5a5;
        }


        /* =========================================================
           STATISTICS
        ========================================================= */

        .stats-grid {
            display: grid;

            grid-template-columns:
                repeat(4, minmax(0, 1fr));

            gap: 16px;

            margin-bottom: 32px;
        }

        .stat-card {
            position: relative;

            padding: 20px;

            background:
                linear-gradient(145deg,
                    #1c1917,
                    #151210);

            border: 1px solid #292524;

            border-radius: 17px;

            overflow: hidden;

            transition:
                transform .25s ease,
                border-color .25s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);

            border-color:
                rgba(245, 158, 11, .25);
        }

        .stat-card::after {
            content: "";

            position: absolute;

            width: 100px;
            height: 100px;

            border-radius: 50%;

            background:
                rgba(245, 158, 11, .06);

            right: -40px;
            bottom: -45px;

            filter: blur(2px);
        }

        .stat-icon {
            width: 40px;
            height: 40px;

            border-radius: 11px;

            display: flex;

            align-items: center;
            justify-content: center;

            background:
                rgba(245, 158, 11, .1);

            color: #f59e0b;

            margin-bottom: 15px;
        }

        .stat-label {
            color: #78716c;

            font-size: 11px;
            font-weight: 600;

            margin-bottom: 5px;
        }

        .stat-value {
            color: #fff;

            font-size: 27px;

            font-weight: 800;
        }

        .stat-description {
            color: #57534e;

            font-size: 10px;

            margin-top: 5px;
        }


        /* =========================================================
           SECTION
        ========================================================= */

        .section-header {
            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 15px;
        }

        .section-title h2 {
            font-size: 19px;

            color: #fff;
        }

        .section-title p {
            color: #57534e;

            font-size: 11px;

            margin-top: 4px;
        }

        .section-badge {
            display: inline-flex;

            align-items: center;

            gap: 6px;

            padding: 7px 10px;

            border-radius: 9px;

            background:
                rgba(245, 158, 11, .08);

            color: #fbbf24;

            font-size: 10px;

            font-weight: 700;
        }


        /* =========================================================
           ORDERS
        ========================================================= */

        .orders-grid {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 18px;

            margin-bottom: 38px;
        }

        .order-card {
            background:
                linear-gradient(145deg,
                    #1c1917,
                    #151210);

            border: 1px solid #292524;

            border-radius: 18px;

            overflow: hidden;

            transition:
                transform .25s ease,
                border-color .25s ease,
                box-shadow .25s ease;
        }

        .order-card:hover {
            transform: translateY(-3px);

            border-color:
                rgba(245, 158, 11, .22);

            box-shadow:
                0 18px 40px rgba(0, 0, 0, .2);
        }


        /* =========================================================
           ORDER HEADER
        ========================================================= */

        .order-top {
            padding: 17px 18px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            border-bottom: 1px solid #292524;
        }

        .order-number {
            font-size: 15px;

            font-weight: 800;

            color: #fff;
        }

        .order-number span {
            color: #f59e0b;
        }

        .status-badge {
            padding: 6px 9px;

            border-radius: 8px;

            font-size: 9px;

            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: .5px;
        }

        .status-pending {
            background: rgba(234, 179, 8, .1);

            color: #fde047;
        }

        .status-confirmed {
            background: rgba(59, 130, 246, .1);

            color: #93c5fd;
        }

        .status-preparing {
            background: rgba(168, 85, 247, .1);

            color: #d8b4fe;
        }

        .status-out_for_delivery {
            background: rgba(245, 158, 11, .1);

            color: #fbbf24;
        }

        .status-completed {
            background: rgba(34, 197, 94, .1);

            color: #86efac;
        }

        .status-cancelled {
            background: rgba(239, 68, 68, .1);

            color: #fca5a5;
        }


        /* =========================================================
           ASSIGNMENT
        ========================================================= */

        .assignment {
            padding: 12px 18px;

            border-bottom: 1px solid #292524;

            font-size: 10px;
        }

        .assignment.available {
            background: rgba(245, 158, 11, .05);

            color: #fbbf24;
        }

        .assignment.mine {
            background: rgba(34, 197, 94, .04);

            color: #86efac;
        }

        .assignment i {
            margin-right: 5px;
        }


        /* =========================================================
           CUSTOMER
        ========================================================= */

        .customer {
            padding: 15px 18px;

            display: flex;

            align-items: center;

            gap: 12px;
        }

        .customer-avatar {
            width: 42px;
            height: 42px;

            flex-shrink: 0;

            border-radius: 50%;

            background:
                linear-gradient(135deg,
                    #292524,
                    #44403c);

            display: flex;

            align-items: center;

            justify-content: center;

            color: #f59e0b;

            font-weight: 800;

            font-size: 13px;
        }

        .customer-info {
            min-width: 0;

            flex: 1;
        }

        .customer-info strong {
            display: block;

            color: #e7e5e4;

            font-size: 12px;
        }

        .customer-info span {
            display: block;

            color: #78716c;

            font-size: 10px;

            margin-top: 3px;

            overflow: hidden;

            text-overflow: ellipsis;
        }


        /* =========================================================
           CUSTOMER CONTACT
        ========================================================= */

        .customer-actions {
            display: flex;

            gap: 6px;
        }

        .customer-action {
            width: 34px;
            height: 34px;

            border-radius: 9px;

            display: flex;

            align-items: center;

            justify-content: center;

            border: 1px solid #3a3531;

            background: #0c0a09;

            color: #a8a29e;

            font-size: 12px;

            transition: .2s ease;
        }

        .customer-action:hover {
            color: #fbbf24;

            border-color:
                rgba(245, 158, 11, .35);

            background:
                rgba(245, 158, 11, .06);
        }

        .customer-action.call:hover {
            color: #86efac;

            border-color:
                rgba(34, 197, 94, .35);

            background:
                rgba(34, 197, 94, .06);
        }


        /* =========================================================
           PAYMENT
        ========================================================= */

        .payment-info {
            margin: 0 18px 16px;
        }

        .payment-status {
            display: flex;

            align-items: center;

            gap: 10px;

            padding: 11px 13px;

            border-radius: 10px;
        }

        .payment-status i {
            font-size: 17px;
        }

        .payment-status div {
            display: flex;

            flex-direction: column;

            gap: 2px;
        }

        .payment-status strong {
            font-size: 12px;

            font-weight: 800;
        }

        .payment-status span {
            font-size: 10px;

            opacity: .8;
        }

        .payment-paid {
            color: #34d399;

            background:
                rgba(16, 185, 129, .08);

            border:
                1px solid rgba(16, 185, 129, .18);
        }

        .payment-pending {
            color: #fbbf24;

            background:
                rgba(245, 158, 11, .08);

            border:
                1px solid rgba(245, 158, 11, .18);
        }


        /* =========================================================
           DELIVERY LOCATION
        ========================================================= */

        .location-box {
            margin: 0 18px 16px;

            padding: 14px;

            border-radius: 13px;

            background:
                linear-gradient(135deg,
                    rgba(59, 130, 246, .07),
                    rgba(37, 99, 235, .025));

            border:
                1px solid rgba(59, 130, 246, .18);
        }

        .location-header {
            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 9px;
        }

        .location-title {
            display: flex;

            align-items: center;

            gap: 7px;

            color: #93c5fd;

            font-size: 10px;

            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: .7px;
        }

        .location-title i {
            color: #60a5fa;
        }

        .location-address {
            display: flex;

            align-items: flex-start;

            gap: 8px;

            color: #d6d3d1;

            font-size: 11px;

            line-height: 1.5;
        }

        .location-address i {
            color: #60a5fa;

            margin-top: 2px;

            flex-shrink: 0;
        }

        .location-coordinates {
            margin-top: 7px;

            color: #78716c;

            font-size: 9px;
        }

        .location-actions {
            display: flex;

            gap: 7px;

            margin-top: 11px;
        }

        .map-btn {
            flex: 1;

            min-height: 34px;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            padding: 0 10px;

            border-radius: 8px;

            font-size: 10px;

            font-weight: 700;

            transition: .2s ease;
        }

        .map-btn-primary {
            background: #2563eb;

            color: #fff;

            border:
                1px solid #3b82f6;
        }

        .map-btn-primary:hover {
            background: #1d4ed8;
        }

        .map-btn-secondary {
            background:
                rgba(255, 255, 255, .03);

            color: #93c5fd;

            border:
                1px solid rgba(59, 130, 246, .25);
        }

        .map-btn-secondary:hover {
            background:
                rgba(59, 130, 246, .08);
        }

        .no-location {
            color: #78716c;

            font-size: 10px;
        }


        /* =========================================================
           ORDER ITEMS
        ========================================================= */

        .items {
            padding: 0 18px 15px;
        }

        .item-row {
            display: flex;

            justify-content: space-between;

            align-items: center;

            padding: 8px 0;

            border-bottom:
                1px solid rgba(41, 37, 36, .7);

            font-size: 11px;
        }

        .item-row:last-child {
            border-bottom: none;
        }

        .item-name {
            color: #d6d3d1;
        }

        .item-qty {
            color: #78716c;

            margin-left: 5px;
        }

        .item-price {
            color: #a8a29e;

            font-weight: 600;
        }


        /* =========================================================
           DELIVERY COMPLETION
        ========================================================= */

        .delivery-completion {
            width: 100%;
        }

        .delivery-completion-title {
            display: flex;

            align-items: center;

            gap: 7px;

            color: #fbbf24;

            font-size: 11px;

            font-weight: 800;

            margin-bottom: 12px;
        }

        .delivery-completion-title i {
            color: #f59e0b;
        }

        .delivery-partner-info {
            display: flex;

            align-items: center;

            gap: 10px;

            padding: 10px;

            margin-bottom: 13px;

            border-radius: 10px;

            background:
                rgba(34, 197, 94, .05);

            border:
                1px solid rgba(34, 197, 94, .15);
        }

        .delivery-partner-icon {
            width: 32px;
            height: 32px;

            border-radius: 8px;

            display: flex;

            align-items: center;

            justify-content: center;

            background:
                rgba(34, 197, 94, .1);

            color: #86efac;
        }

        .delivery-partner-info span {
            display: block;

            color: #78716c;

            font-size: 9px;

            text-transform: uppercase;

            letter-spacing: .7px;
        }

        .delivery-partner-info strong {
            display: block;

            color: #d6d3d1;

            font-size: 11px;

            margin-top: 2px;
        }

        .payment-label {
            display: flex;

            align-items: center;

            gap: 6px;

            color: #a8a29e;

            font-size: 10px;

            font-weight: 700;

            margin-bottom: 8px;
        }

        .payment-options {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 7px;

            margin-bottom: 10px;
        }

        .payment-option {
            cursor: pointer;

            position: relative;
        }

        .payment-option input {
            position: absolute;

            opacity: 0;
        }

        .payment-option-content {
            min-height: 42px;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 7px;

            padding: 8px;

            border-radius: 8px;

            background: #0c0a09;

            border: 1px solid #3a3531;

            color: #a8a29e;

            font-size: 10px;

            font-weight: 700;

            transition: .2s ease;
        }

        .payment-option-content i {
            color: #78716c;
        }

        .payment-option:hover .payment-option-content {
            border-color:
                rgba(245, 158, 11, .35);

            color: #fbbf24;
        }

        .payment-option input:checked+.payment-option-content {
            background:
                rgba(245, 158, 11, .1);

            border-color:
                rgba(245, 158, 11, .5);

            color: #fbbf24;

            box-shadow:
                0 0 0 1px rgba(245, 158, 11, .08);
        }

        .payment-option input:checked+.payment-option-content i {
            color: #f59e0b;
        }

        .complete-delivery-btn {
            width: 100%;

            height: 40px;

            border:
                1px solid rgba(34, 197, 94, .3);

            border-radius: 9px;

            background:
                linear-gradient(135deg,
                    rgba(34, 197, 94, .15),
                    rgba(22, 163, 74, .08));

            color: #86efac;

            font-size: 10px;

            font-weight: 800;

            cursor: pointer;

            transition: .2s ease;
        }

        .complete-delivery-btn:hover {
            background:
                rgba(34, 197, 94, .2);

            border-color:
                rgba(34, 197, 94, .5);

            transform: translateY(-1px);
        }


        /* =========================================================
           ORDER FOOTER
        ========================================================= */

        .order-bottom {
            padding: 15px 18px;

            border-top: 1px solid #292524;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 12px;
        }

        .order-total-label {
            color: #78716c;

            font-size: 10px;
        }

        .order-total {
            color: #fbbf24;

            font-size: 16px;

            font-weight: 800;

            margin-top: 2px;
        }


        /* =========================================================
           STATUS FORM
        ========================================================= */

        .status-form {
            display: flex;

            align-items: center;

            gap: 7px;
        }

        .status-select {
            height: 35px;

            padding: 0 9px;

            border-radius: 8px;

            border: 1px solid #44403c;

            background: #0c0a09;

            color: #d6d3d1;

            font-size: 10px;

            outline: none;

            cursor: pointer;
        }

        .status-select:focus {
            border-color: #f59e0b;
        }

        .update-btn {
            height: 35px;

            padding: 0 13px;

            border: none;

            border-radius: 8px;

            background: #f59e0b;

            color: #1c1917;

            font-size: 10px;

            font-weight: 800;

            cursor: pointer;

            transition: .2s ease;
        }

        .update-btn:hover {
            background: #fbbf24;

            transform: translateY(-1px);
        }


        /* =========================================================
           ACCEPT
        ========================================================= */

        .accept-form {
            width: 100%;
        }

        .accept-btn {
            width: 100%;

            height: 40px;

            border:
                1px solid rgba(245, 158, 11, .35);

            border-radius: 9px;

            background:
                linear-gradient(135deg,
                    rgba(245, 158, 11, .16),
                    rgba(217, 119, 6, .08));

            color: #fbbf24;

            font-size: 11px;

            font-weight: 800;

            cursor: pointer;

            transition: .2s ease;
        }

        .accept-btn:hover {
            background:
                rgba(245, 158, 11, .22);

            border-color:
                rgba(245, 158, 11, .55);

            transform: translateY(-1px);
        }


        /* =========================================================
           EMPTY
        ========================================================= */

        .empty-state {
            grid-column: 1 / -1;

            padding: 55px 25px;

            text-align: center;

            background: #171412;

            border:
                1px dashed #3a3531;

            border-radius: 17px;
        }

        .empty-icon {
            width: 55px;
            height: 55px;

            margin: 0 auto 15px;

            border-radius: 15px;

            display: flex;

            align-items: center;

            justify-content: center;

            background:
                rgba(245, 158, 11, .08);

            color: #f59e0b;

            font-size: 20px;
        }

        .empty-state h3 {
            font-size: 15px;

            color: #d6d3d1;
        }

        .empty-state p {
            color: #57534e;

            font-size: 11px;

            margin-top: 5px;
        }


        /* =========================================================
           HISTORY
        ========================================================= */

        .history-wrapper {
            background: #171412;

            border: 1px solid #292524;

            border-radius: 17px;

            overflow-x: auto;

            margin-bottom: 30px;
        }

        .history-table {
            width: 100%;

            border-collapse: collapse;

            min-width: 800px;
        }

        .history-table th {
            text-align: left;

            padding: 14px 18px;

            background: #1c1917;

            color: #78716c;

            font-size: 9px;

            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: 1px;

            border-bottom: 1px solid #292524;
        }

        .history-table td {
            padding: 15px 18px;

            color: #a8a29e;

            font-size: 11px;

            border-bottom: 1px solid #292524;
        }

        .history-table tr:last-child td {
            border-bottom: none;
        }

        .history-table tr:hover td {
            background:
                rgba(255, 255, 255, .01);
        }

        .history-order {
            color: #fff;

            font-weight: 800;
        }

        .history-customer {
            color: #d6d3d1;

            font-weight: 600;
        }

        .history-total {
            color: #fbbf24;

            font-weight: 800;
        }

        .delivered-label {
            display: inline-flex;

            align-items: center;

            gap: 5px;

            color: #86efac;

            font-size: 10px;

            font-weight: 700;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1100px) {

            .stats-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .orders-grid {
                grid-template-columns: 1fr;
            }
        }


        @media (max-width: 800px) {

            .sidebar {
                display: none;
            }

            .main {
                width: 100%;

                margin-left: 0;

                padding:
                    20px 15px 35px;
            }

            .mobile-header {
                display: flex;

                align-items: center;

                justify-content: space-between;

                padding: 14px 15px;

                margin-bottom: 22px;

                background: #171412;

                border: 1px solid #292524;

                border-radius: 14px;
            }

            .mobile-brand {
                display: flex;

                align-items: center;

                gap: 9px;
            }

            .mobile-brand-icon {
                width: 34px;
                height: 34px;

                border-radius: 10px;

                display: flex;

                align-items: center;

                justify-content: center;

                background: #f59e0b;

                color: #1c1917;

                font-weight: 800;
            }

            .mobile-brand strong {
                font-size: 14px;
            }

            .topbar {
                align-items: flex-start;
            }

            .top-date {
                display: none;
            }

            .page-title h1 {
                font-size: 28px;
            }
        }


        @media (max-width: 550px) {

            .stats-grid {
                grid-template-columns: 1fr 1fr;

                gap: 10px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-value {
                font-size: 22px;
            }

            .section-header {
                align-items: flex-start;

                gap: 10px;
            }

            .order-bottom {
                align-items: stretch;

                flex-direction: column;
            }

            .status-form {
                width: 100%;

                flex-direction: column;

                align-items: stretch;
            }

            .status-select,
            .update-btn {
                width: 100%;
            }

            .customer {
                align-items: flex-start;
            }

            .customer-actions {
                flex-direction: column;
            }

            .location-actions {
                flex-direction: column;
            }

            .payment-options {
                grid-template-columns: 1fr;
            }
        }


        /* =========================================================
           ACCESSIBILITY
        ========================================================= */

        :focus-visible {
            outline:
                3px solid rgba(245, 158, 11, .4);

            outline-offset: 3px;
        }
    </style>

</head>


<body>

    <div class="app">


        {{-- =========================================================
        SIDEBAR
        ========================================================== --}}

        <aside class="sidebar">

            <div class="brand">

                <div class="brand-icon">
                    B
                </div>

                <div class="brand-text">

                    <strong>
                        BenStoke
                    </strong>

                    <span>
                        Staff Portal
                    </span>

                </div>

            </div>


            <nav class="nav">

                <div class="nav-label">
                    Workspace
                </div>

                <a href="{{ route('staff.dashboard') }}" class="nav-link active">

                    <i class="fa-solid fa-chart-line"></i>

                    Dashboard

                </a>


                <a href="#active-orders" class="nav-link">

                    <i class="fa-solid fa-bag-shopping"></i>

                    Active Orders

                </a>


                <a href="#order-history" class="nav-link">

                    <i class="fa-solid fa-clock-rotate-left"></i>

                    Delivery History

                </a>

            </nav>


            <div class="sidebar-bottom">

                <div class="staff-mini">

                    <div class="staff-mini-title">
                        Signed in as
                    </div>

                    <div class="staff-mini-name">

                        {{ Auth::user()->name }}

                    </div>

                    <div class="staff-mini-role">
                        Restaurant Staff
                    </div>

                </div>


                <form action="{{ route('logout') }}" method="POST" class="logout-form">

                    @csrf

                    <button type="submit">

                        <i class="fa-solid fa-right-from-bracket"></i>

                        &nbsp;

                        Logout

                    </button>

                </form>

            </div>

        </aside>



        {{-- =========================================================
        MAIN
        ========================================================== --}}

        <main class="main">


            {{-- MOBILE HEADER --}}

            <div class="mobile-header">

                <div class="mobile-brand">

                    <div class="mobile-brand-icon">
                        B
                    </div>

                    <strong>
                        BenStoke Staff
                    </strong>

                </div>


                <form action="{{ route('logout') }}" method="POST">

                    @csrf

                    <button type="submit" style="
                            border:none;
                            background:none;
                            color:#a8a29e;
                            cursor:pointer;
                            font-size:16px;
                        ">

                        <i class="fa-solid fa-right-from-bracket"></i>

                    </button>

                </form>

            </div>



            {{-- =====================================================
            HEADER
            ====================================================== --}}

            <div class="topbar">

                <div class="page-title">

                    <small>
                        Staff Workspace
                    </small>

                    <h1>
                        Good day, {{ Auth::user()->name }}
                    </h1>

                    <p>
                        Manage orders, customer locations,
                        active deliveries and delivery history.
                    </p>

                </div>


                <div class="top-date">

                    <i class="fa-regular fa-calendar"></i>

                    {{ now()->format('D, d M Y') }}

                </div>

            </div>



            {{-- =====================================================
            ALERTS
            ====================================================== --}}

            @if(session('success'))

                <div class="alert alert-success">

                    <i class="fa-solid fa-circle-check"></i>

                    <div>
                        {{ session('success') }}
                    </div>

                </div>

            @endif


            @if($errors->any())

                <div class="alert alert-error">

                    <i class="fa-solid fa-circle-exclamation"></i>

                    <div>

                        @foreach($errors->all() as $error)

                            <div>
                                {{ $error }}
                            </div>

                        @endforeach

                    </div>

                </div>

            @endif



            {{-- =====================================================
            STATISTICS
            ====================================================== --}}

            <div class="stats-grid">


                {{-- AVAILABLE ORDERS --}}

                <div class="stat-card">

                    <div class="stat-icon">

                        <i class="fa-solid fa-bell"></i>

                    </div>

                    <div class="stat-label">
                        Available Orders
                    </div>

                    <div class="stat-value">
                        {{ $newOrders }}
                    </div>

                    <div class="stat-description">
                        Waiting for a staff member
                    </div>

                </div>


                {{-- ACTIVE ORDERS --}}

                <div class="stat-card">

                    <div class="stat-icon">

                        <i class="fa-solid fa-truck-fast"></i>

                    </div>

                    <div class="stat-label">
                        My Active Orders
                    </div>

                    <div class="stat-value">
                        {{ $myActiveOrders }}
                    </div>

                    <div class="stat-description">
                        Currently handling
                    </div>

                </div>


                {{-- COMPLETED --}}

                <div class="stat-card">

                    <div class="stat-icon">

                        <i class="fa-solid fa-circle-check"></i>

                    </div>

                    <div class="stat-label">
                        My Deliveries
                    </div>

                    <div class="stat-value">
                        {{ $myCompletedOrders }}
                    </div>

                    <div class="stat-description">
                        Successfully delivered
                    </div>

                </div>


                {{-- TODAY --}}

                <div class="stat-card">

                    <div class="stat-icon">

                        <i class="fa-solid fa-calendar-check"></i>

                    </div>

                    <div class="stat-label">
                        Completed Today
                    </div>

                    <div class="stat-value">
                        {{ $completedToday }}
                    </div>

                    <div class="stat-description">
                        Deliveries today
                    </div>

                </div>

            </div>



            {{-- =====================================================
            ACTIVE ORDERS
            ====================================================== --}}

            <section id="active-orders">


                <div class="section-header">

                    <div class="section-title">

                        <h2>
                            Active Orders
                        </h2>

                        <p>
                            Available orders and orders currently assigned to you.
                        </p>

                    </div>


                    <div class="section-badge">

                        <i class="fa-solid fa-circle"></i>

                        {{ $activeOrders->count() }}

                        Active

                    </div>

                </div>



                <div class="orders-grid">


                    @forelse($activeOrders as $order)


                                        <div class="order-card">


                                            {{-- =================================================
                                            ORDER HEADER
                                            ================================================== --}}

                                            <div class="order-top">

                                                <div class="order-number">

                                                    Order

                                                    <span>
                                                        #{{ $order->id }}
                                                    </span>

                                                </div>


                                                <div class="
                                                    status-badge
                                                    status-{{ $order->status }}
                                                ">

                                                    {{ ucwords(
                            str_replace(
                                '_',
                                ' ',
                                $order->status
                            )
                        ) }}

                                                </div>

                                            </div>



                                            {{-- =================================================
                                            ASSIGNMENT
                                            ================================================== --}}

                                            @if($order->staff_id === null)

                                                <div class="assignment available">

                                                    <i class="fa-solid fa-bolt"></i>

                                                    Available for you

                                                </div>

                                            @else

                                                <div class="assignment mine">

                                                    <i class="fa-solid fa-user-check"></i>

                                                    Assigned to you

                                                </div>

                                            @endif



                                            {{-- =================================================
                                            CUSTOMER
                                            ================================================== --}}

                                            <div class="customer">


                                                <div class="customer-avatar">

                                                    {{
                            strtoupper(
                                substr(
                                    $order->user->name ?? 'C',
                                    0,
                                    1
                                )
                            )
                                                    }}

                                                </div>


                                                <div class="customer-info">

                                                    <strong>
                                                        {{ $order->user->name ?? 'Customer' }}
                                                    </strong>

                                                    <span>
                                                        {{ $order->user->email ?? 'No email' }}
                                                    </span>

                                                </div>


                                                @if($order->phone)

                                                    <div class="customer-actions">

                                                        <a href="tel:{{ $order->phone }}" class="customer-action call" title="Call customer">

                                                            <i class="fa-solid fa-phone"></i>

                                                        </a>

                                                    </div>

                                                @endif

                                            </div>



                                            {{-- =================================================
                                            PAYMENT STATUS
                                            FIXED: NOW INSIDE ORDER LOOP
                                            ================================================== --}}

                                            <div class="payment-info">

                                                @if($order->payment_status === 'paid')

                                                    <div class="payment-status payment-paid">

                                                        <i class="fa-solid fa-circle-check"></i>

                                                        <div>

                                                            <strong>
                                                                Payment Done
                                                            </strong>

                                                            <span>

                                                                @if($order->payment_method === 'online')

                                                                    Online Payment

                                                                @elseif($order->payment_method === 'upi')

                                                                    UPI Payment

                                                                @elseif($order->payment_method === 'cash')

                                                                    Cash Payment

                                                                @elseif($order->payment_method === 'already_paid')

                                                                    Already Paid

                                                                @else

                                                                    Paid

                                                                @endif

                                                            </span>

                                                        </div>

                                                    </div>

                                                @else

                                                    <div class="payment-status payment-pending">

                                                        <i class="fa-solid fa-triangle-exclamation"></i>

                                                        <div>

                                                            <strong>
                                                                Payment Pending
                                                            </strong>

                                                            <span>
                                                                Collect Cash or UPI on delivery
                                                            </span>

                                                        </div>

                                                    </div>

                                                @endif

                                            </div>



                                            {{-- =================================================
                                            DELIVERY LOCATION
                                            ================================================== --}}

                                            <div class="location-box">

                                                <div class="location-header">

                                                    <div class="location-title">

                                                        <i class="fa-solid fa-location-dot"></i>

                                                        Delivery Location

                                                    </div>

                                                </div>


                                                @if(!empty($order->address))

                                                    <div class="location-address">

                                                        <i class="fa-solid fa-map-pin"></i>

                                                        <span>
                                                            {{ $order->address }}
                                                        </span>

                                                    </div>


                                                    @if(
                                                            !empty($order->latitude) &&
                                                            !empty($order->longitude)
                                                        )

                                                        <div class="location-coordinates">

                                                            <i class="fa-solid fa-crosshairs"></i>

                                                            {{ $order->latitude }},
                                                            {{ $order->longitude }}

                                                        </div>

                                                    @endif


                                                    <div class="location-actions">


                                                        {{-- OPEN MAP --}}

                                                        @if(
                                                                !empty($order->latitude) &&
                                                                !empty($order->longitude)
                                                            )

                                                            <a href="https://www.google.com/maps/search/?api=1&query={{ $order->latitude }},{{ $order->longitude }}"
                                                                target="_blank" rel="noopener noreferrer" class="map-btn map-btn-primary">

                                                                <i class="fa-solid fa-location-arrow"></i>

                                                                Open Map

                                                            </a>

                                                        @else

                                                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($order->address) }}"
                                                                target="_blank" rel="noopener noreferrer" class="map-btn map-btn-primary">

                                                                <i class="fa-solid fa-map-location-dot"></i>

                                                                Find Location

                                                            </a>

                                                        @endif


                                                        {{-- DIRECTIONS --}}

                                                        @if(
                                                                !empty($order->latitude) &&
                                                                !empty($order->longitude)
                                                            )

                                                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $order->latitude }},{{ $order->longitude }}"
                                                                target="_blank" rel="noopener noreferrer" class="map-btn map-btn-secondary">

                                                                <i class="fa-solid fa-route"></i>

                                                                Directions

                                                            </a>

                                                        @else

                                                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($order->address) }}"
                                                                target="_blank" rel="noopener noreferrer" class="map-btn map-btn-secondary">

                                                                <i class="fa-solid fa-route"></i>

                                                                Directions

                                                            </a>

                                                        @endif

                                                    </div>

                                                @else

                                                    <div class="no-location">

                                                        <i class="fa-solid fa-location-crosshairs"></i>

                                                        Customer has not provided a delivery address.

                                                    </div>

                                                @endif

                                            </div>



                                            {{-- =================================================
                                            ORDER TIME
                                            ================================================== --}}

                                            <div style="
                                                padding:0 18px 15px;
                                                color:#78716c;
                                                font-size:10px;
                                            ">

                                                <i class="fa-regular fa-clock"></i>

                                                Placed:

                                                {{ $order->created_at
                            ? $order->created_at->format('d M Y, h:i A')
                            : 'N/A'
                                                }}

                                            </div>



                                            {{-- =================================================
                                            ORDER ITEMS
                                            ================================================== --}}

                                            <div class="items">

                                                @forelse($order->items as $item)

                                                                        <div class="item-row">

                                                                            <div>

                                                                                <span class="item-name">

                                                                                    {{ $item->menuItem->name ?? 'Menu Item' }}

                                                                                </span>

                                                                                <span class="item-qty">

                                                                                    × {{ $item->quantity }}

                                                                                </span>

                                                                            </div>


                                                                            <div class="item-price">

                                                                                ₹{{ number_format(
                                                        ($item->price ?? 0) *
                                                        ($item->quantity ?? 1),
                                                        2
                                                    ) }}

                                                                            </div>

                                                                        </div>

                                                @empty

                                                    <div style="
                                                            color:#57534e;
                                                            font-size:11px;
                                                            padding:8px 0;
                                                        ">

                                                        No items found.

                                                    </div>

                                                @endforelse

                                            </div>



                                            {{-- =================================================
                                            ORDER FOOTER
                                            ================================================== --}}

                                            <div class="order-bottom">


                                                <div>

                                                    <div class="order-total-label">
                                                        Order Total
                                                    </div>

                                                    <div class="order-total">

                                                        ₹{{ number_format(
                            $order->total_amount ?? 0,
                            2
                        ) }}

                                                    </div>

                                                </div>



                                                {{-- =================================================
                                                AVAILABLE ORDER
                                                ================================================== --}}

                                                @if(
                                                                            $order->staff_id === null &&
                                                                            $order->status === 'pending'
                                                                        )

                                                                        <form action="{{ route(
                                                        'staff.orders.status',
                                                        $order->id
                                                    ) }}" method="POST" class="accept-form">

                                                                            @csrf

                                                                            @method('PUT')

                                                                            <input type="hidden" name="status" value="confirmed">

                                                                            <button type="submit" class="accept-btn">

                                                                                <i class="fa-solid fa-hand-pointer"></i>

                                                                                &nbsp;

                                                                                Accept & Confirm Order

                                                                            </button>

                                                                        </form>



                                                                        {{-- =================================================
                                                                        ASSIGNED ORDER
                                                                        ================================================== --}}

                                                @elseif($order->staff_id !== null)

                                                                        <form action="{{ route(
                                                        'staff.orders.status',
                                                        $order->id
                                                    ) }}" method="POST" class="status-form">

                                                                            @csrf

                                                                            @method('PUT')


                                                                            {{-- ================================
                                                                            PENDING
                                                                            ================================= --}}

                                                                            @if($order->status === 'pending')

                                                                                <select name="status" class="status-select" required>

                                                                                    <option value="confirmed">
                                                                                        Confirm
                                                                                    </option>

                                                                                    <option value="cancelled">
                                                                                        Cancel
                                                                                    </option>

                                                                                </select>


                                                                                <button type="submit" class="update-btn">

                                                                                    Update

                                                                                </button>



                                                                                {{-- ================================
                                                                                CONFIRMED
                                                                                ================================= --}}

                                                                            @elseif($order->status === 'confirmed')

                                                                                <select name="status" class="status-select" required>

                                                                                    <option value="preparing">
                                                                                        Start Preparing
                                                                                    </option>

                                                                                    <option value="cancelled">
                                                                                        Cancel
                                                                                    </option>

                                                                                </select>


                                                                                <button type="submit" class="update-btn">

                                                                                    Update

                                                                                </button>



                                                                                {{-- ================================
                                                                                PREPARING
                                                                                ================================= --}}

                                                                            @elseif($order->status === 'preparing')

                                                                                <input type="hidden" name="status" value="out_for_delivery">

                                                                                <button type="submit" class="update-btn">

                                                                                    <i class="fa-solid fa-truck"></i>

                                                                                    Out for Delivery

                                                                                </button>



                                                                                {{-- ================================
                                                                                OUT FOR DELIVERY
                                                                                ================================= --}}

                                                                            @elseif($order->status === 'out_for_delivery')

                                                                                <div class="delivery-completion">


                                                                                    <div class="delivery-completion-title">

                                                                                        <i class="fa-solid fa-truck"></i>

                                                                                        Complete Delivery

                                                                                    </div>


                                                                                    <div class="delivery-partner-info">

                                                                                        <div class="delivery-partner-icon">

                                                                                            <i class="fa-solid fa-user"></i>

                                                                                        </div>

                                                                                        <div>

                                                                                            <span>
                                                                                                Delivery Partner
                                                                                            </span>

                                                                                            <strong>
                                                                                                {{ Auth::user()->name }}
                                                                                            </strong>

                                                                                        </div>

                                                                                    </div>


                                                                                    {{-- =================================================
                                                                                    IMPORTANT:
                                                                                    COMPLETE DELIVERY STATUS
                                                                                    ================================================== --}}

                                                                                    <input type="hidden" name="status" value="completed">


                                                                                    @if($order->payment_status === 'paid')

                                                                                        {{-- ================================
                                                                                        ALREADY PAID
                                                                                        ================================= --}}

                                                                                        <input type="hidden" name="payment_method" value="already_paid">

                                                                                        <div class="payment-status payment-paid" style="margin-bottom:10px;">

                                                                                            <i class="fa-solid fa-circle-check"></i>

                                                                                            <div>

                                                                                                <strong>
                                                                                                    Payment Already Completed
                                                                                                </strong>

                                                                                                <span>

                                                                                                    @if($order->payment_method === 'online')

                                                                                                        Online Payment

                                                                                                    @elseif($order->payment_method === 'upi')

                                                                                                        UPI Payment

                                                                                                    @elseif($order->payment_method === 'cash')

                                                                                                        Cash Payment

                                                                                                    @else

                                                                                                        Already Paid

                                                                                                    @endif

                                                                                                </span>

                                                                                            </div>

                                                                                        </div>


                                                                                    @else

                                                                                        {{-- ================================
                                                                                        PAYMENT REQUIRED
                                                                                        ================================= --}}

                                                                                        <div class="payment-label">

                                                                                            <i class="fa-solid fa-credit-card"></i>

                                                                                            Payment Method

                                                                                        </div>


                                                                                        <div class="payment-options">


                                                                                            {{-- CASH --}}

                                                                                            <label class="payment-option">

                                                                                                <input type="radio" name="payment_method" value="cash" required>

                                                                                                <span class="payment-option-content">

                                                                                                    <i class="fa-solid fa-money-bill-wave"></i>

                                                                                                    <span>
                                                                                                        Cash
                                                                                                    </span>

                                                                                                </span>

                                                                                            </label>


                                                                                            {{-- UPI --}}

                                                                                            <label class="payment-option">

                                                                                                <input type="radio" name="payment_method" value="upi">

                                                                                                <span class="payment-option-content">

                                                                                                    <i class="fa-solid fa-mobile-screen-button"></i>

                                                                                                    <span>
                                                                                                        UPI
                                                                                                    </span>

                                                                                                </span>

                                                                                            </label>


                                                                                            {{-- ONLINE --}}

                                                                                            <label class="payment-option">

                                                                                                <input type="radio" name="payment_method" value="online">

                                                                                                <span class="payment-option-content">

                                                                                                    <i class="fa-solid fa-globe"></i>

                                                                                                    <span>
                                                                                                        Online
                                                                                                    </span>

                                                                                                </span>

                                                                                            </label>


                                                                                            {{-- ALREADY PAID --}}

                                                                                            <label class="payment-option">

                                                                                                <input type="radio" name="payment_method" value="already_paid">

                                                                                                <span class="payment-option-content">

                                                                                                    <i class="fa-solid fa-circle-check"></i>

                                                                                                    <span>
                                                                                                        Already Paid
                                                                                                    </span>

                                                                                                </span>

                                                                                            </label>

                                                                                        </div>

                                                                                    @endif


                                                                                    {{-- COMPLETE DELIVERY --}}

                                                                                    <button type="submit" class="complete-delivery-btn">

                                                                                        <i class="fa-solid fa-check-double"></i>

                                                                                        &nbsp;

                                                                                        Complete Delivery

                                                                                    </button>

                                                                                </div>

                                                                            @endif

                                                                        </form>

                                                @endif

                                            </div>

                                        </div>


                    @empty


                        <div class="empty-state">

                            <div class="empty-icon">

                                <i class="fa-solid fa-check"></i>

                            </div>

                            <h3>
                                No active orders
                            </h3>

                            <p>
                                New orders will appear here when they are available.
                            </p>

                        </div>


                    @endforelse

                </div>

            </section>



            {{-- =====================================================
            DELIVERY HISTORY
            ====================================================== --}}

            <section id="order-history">


                <div class="section-header">

                    <div class="section-title">

                        <h2>
                            My Delivery History
                        </h2>

                        <p>
                            Completed orders delivered by you only.
                        </p>

                    </div>


                    <div class="section-badge">

                        <i class="fa-solid fa-clock-rotate-left"></i>

                        {{ $previousOrders->count() }}

                        Delivered

                    </div>

                </div>



                <div class="history-wrapper">


                    @if($previousOrders->count() > 0)

                        <table class="history-table">

                            <thead>

                                <tr>

                                    <th>
                                        Order
                                    </th>

                                    <th>
                                        Customer
                                    </th>

                                    <th>
                                        Delivery Location
                                    </th>

                                    <th>
                                        Items
                                    </th>

                                    <th>
                                        Total
                                    </th>

                                    <th>
                                        Delivered
                                    </th>

                                </tr>

                            </thead>


                            <tbody>


                                @foreach($previousOrders as $order)

                                                        <tr>


                                                            <td>

                                                                <span class="history-order">

                                                                    #{{ $order->id }}

                                                                </span>

                                                            </td>


                                                            <td>

                                                                <span class="history-customer">

                                                                    {{ $order->user->name ?? 'Customer' }}

                                                                </span>

                                                            </td>


                                                            <td>

                                                                @if($order->address)

                                                                    <span style="
                                                                                color:#a8a29e;
                                                                                max-width:230px;
                                                                                display:block;
                                                                            ">

                                                                        <i class="fa-solid fa-location-dot" style="color:#60a5fa;">
                                                                        </i>

                                                                        {{ $order->address }}

                                                                    </span>

                                                                @else

                                                                    <span style="
                                                                                color:#57534e;
                                                                            ">

                                                                        No address

                                                                    </span>

                                                                @endif

                                                            </td>


                                                            <td>

                                                                {{ $order->items->sum('quantity') }}

                                                                item(s)

                                                            </td>


                                                            <td>

                                                                <span class="history-total">

                                                                    ₹{{ number_format(
                                        $order->total_amount ?? 0,
                                        2
                                    ) }}

                                                                </span>

                                                            </td>


                                                            <td>

                                                                <span class="delivered-label">

                                                                    <i class="fa-solid fa-circle-check"></i>

                                                                    {{ $order->updated_at
                                        ? $order->updated_at->format(
                                            'd M Y, h:i A'
                                        )
                                        : 'Completed'
                                                                        }}

                                                                </span>

                                                            </td>

                                                        </tr>

                                @endforeach

                            </tbody>

                        </table>


                    @else


                        <div class="empty-state">

                            <div class="empty-icon">

                                <i class="fa-solid fa-box-open"></i>

                            </div>

                            <h3>
                                No delivery history yet
                            </h3>

                            <p>
                                Orders you successfully deliver will appear here.
                            </p>

                        </div>


                    @endif

                </div>

            </section>



            {{-- =====================================================
            FOOTER
            ====================================================== --}}

            <div style="
            text-align:center;
            color:#44403c;
            font-size:10px;
            padding:10px 0 20px;
        ">

                BenStoke Staff Portal

                &nbsp;•&nbsp;

                {{ now()->format('Y') }}

            </div>


        </main>

    </div>

</body>

</html>