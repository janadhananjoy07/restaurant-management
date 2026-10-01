<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Staff Management | BenStoke Admin</title>

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fb;
            color: #111827;
            min-height: 100vh;
        }

        .page {
            width: 100%;
            min-height: 100vh;
        }

        /* =========================================================
           TOPBAR
        ========================================================= */

        .topbar {
            background: #111827;
            color: white;
            border-bottom: 1px solid #1f2937;
        }

        .topbar-inner {
            width: min(1400px, 94%);
            margin: auto;
            min-height: 72px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background: #f59e0b;
            color: #111827;

            font-size: 20px;
            font-weight: 800;
        }

        .brand h1 {
            font-size: 17px;
            font-weight: 800;
        }

        .brand p {
            margin-top: 3px;
            color: #9ca3af;
            font-size: 11px;
        }

        .back-btn {
            text-decoration: none;
            color: white;

            padding: 9px 15px;

            border: 1px solid #374151;
            border-radius: 9px;

            font-size: 13px;
            font-weight: 600;

            transition: 0.2s ease;
        }

        .back-btn:hover {
            background: #1f2937;
            border-color: #4b5563;
        }

        /* =========================================================
           MAIN
        ========================================================= */

        .container {
            width: min(1400px, 94%);
            margin: auto;
        }

        main {
            padding: 35px 0 60px;
        }

        .page-header {
            margin-bottom: 28px;
        }

        .page-header h2 {
            font-size: 28px;
            font-weight: 800;
        }

        .page-header p {
            margin-top: 7px;
            color: #6b7280;
            font-size: 14px;
        }

        /* =========================================================
           ALERTS
        ========================================================= */

        .alert {
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .alert-success {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        /* =========================================================
           STATISTICS
        ========================================================= */

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 20px;

            box-shadow:
                0 5px 20px rgba(15, 23, 42, 0.04);
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-label {
            color: #6b7280;
            font-size: 12px;
            font-weight: 700;
        }

        .stat-icon {
            width: 40px;
            height: 40px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 11px;

            background: #fff7ed;
            color: #ea580c;

            font-size: 18px;
        }

        .stat-value {
            margin-top: 13px;

            font-size: 29px;
            font-weight: 800;
        }

        /* =========================================================
           FILTER CARD
        ========================================================= */

        .filter-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 16px;

            padding: 20px;
            margin-bottom: 22px;

            box-shadow:
                0 5px 20px rgba(15, 23, 42, 0.04);
        }

        .filter-form {
            display: grid;
            grid-template-columns: 1fr 220px auto;
            gap: 12px;
            align-items: end;
        }

        .field label {
            display: block;

            margin-bottom: 7px;

            color: #374151;

            font-size: 12px;
            font-weight: 700;
        }

        .field input,
        .field select {
            width: 100%;
            height: 44px;

            padding: 0 13px;

            border: 1px solid #d1d5db;
            border-radius: 9px;

            background: white;
            color: #111827;

            font-family: inherit;
            font-size: 13px;

            outline: none;
        }

        .field input:focus,
        .field select:focus {
            border-color: #f59e0b;

            box-shadow:
                0 0 0 3px rgba(245, 158, 11, 0.10);
        }

        .filter-btn {
            height: 44px;

            padding: 0 20px;

            border: none;
            border-radius: 9px;

            background: #111827;
            color: white;

            font-family: inherit;
            font-size: 13px;
            font-weight: 700;

            cursor: pointer;
        }

        .filter-btn:hover {
            background: #1f2937;
        }

        /* =========================================================
           STAFF TABLE
        ========================================================= */

        .staff-card {
            background: white;

            border: 1px solid #e5e7eb;
            border-radius: 16px;

            overflow: hidden;

            box-shadow:
                0 5px 20px rgba(15, 23, 42, 0.04);
        }

        .staff-card-header {
            padding: 20px 22px;

            border-bottom: 1px solid #e5e7eb;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .staff-card-header h3 {
            font-size: 16px;
            font-weight: 800;
        }

        .staff-count {
            color: #6b7280;
            font-size: 12px;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 950px;
        }

        th {
            padding: 13px 18px;

            text-align: left;

            background: #f9fafb;

            color: #6b7280;

            font-size: 11px;
            font-weight: 800;

            text-transform: uppercase;
            letter-spacing: 0.5px;

            border-bottom: 1px solid #e5e7eb;
        }

        td {
            padding: 16px 18px;

            border-bottom: 1px solid #f0f1f3;

            font-size: 13px;
            vertical-align: middle;
        }

        tbody tr:hover {
            background: #fafafa;
        }

        .staff-user {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .avatar {
            width: 38px;
            height: 38px;

            flex-shrink: 0;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #fff7ed;
            color: #c2410c;

            font-size: 13px;
            font-weight: 800;
        }

        .staff-name {
            font-weight: 700;
        }

        .staff-email {
            margin-top: 3px;

            color: #6b7280;

            font-size: 11px;
        }

        /* =========================================================
           STATUS
        ========================================================= */

        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;

            padding: 6px 9px;

            border-radius: 999px;

            font-size: 10px;
            font-weight: 800;

            text-transform: uppercase;
        }

        .status::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .status-pending {
            background: #fff7ed;
            color: #c2410c;
        }

        .status-approved {
            background: #ecfdf5;
            color: #047857;
        }

        .status-rejected {
            background: #fef2f2;
            color: #b91c1c;
        }

        .status-suspended {
            background: #fef3c7;
            color: #92400e;
        }

        /* =========================================================
           ACTIONS
        ========================================================= */

        .actions {
            display: flex;
            align-items: center;
            gap: 7px;
            flex-wrap: wrap;
        }

        .action-form {
            display: inline;
        }

        .action-btn {
            border: none;

            padding: 7px 10px;

            border-radius: 7px;

            font-family: inherit;

            font-size: 10px;
            font-weight: 800;

            cursor: pointer;
        }

        .approve-btn {
            background: #dcfce7;
            color: #166534;
        }

        .approve-btn:hover {
            background: #bbf7d0;
        }

        .reject-btn {
            background: #fee2e2;
            color: #991b1b;
        }

        .reject-btn:hover {
            background: #fecaca;
        }

        .suspend-btn {
            background: #fef3c7;
            color: #92400e;
        }

        .suspend-btn:hover {
            background: #fde68a;
        }

        .reactivate-btn {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .reactivate-btn:hover {
            background: #bfdbfe;
        }

        .no-action {
            color: #9ca3af;
            font-size: 11px;
        }

        /* =========================================================
           EMPTY
        ========================================================= */

        .empty {
            padding: 55px 20px;

            text-align: center;
        }

        .empty-icon {
            width: 58px;
            height: 58px;

            margin: auto auto 15px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #f3f4f6;

            font-size: 24px;
        }

        .empty h3 {
            font-size: 16px;
            font-weight: 800;
        }

        .empty p {
            margin-top: 6px;

            color: #6b7280;

            font-size: 12px;
        }

        /* =========================================================
           PAGINATION
        ========================================================= */

        .pagination {
            padding: 18px 22px;

            border-top: 1px solid #e5e7eb;
        }

        .pagination nav {
            display: flex;
            justify-content: center;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1000px) {

            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-form {
                grid-template-columns: 1fr 1fr;
            }

            .filter-btn {
                width: 100%;
            }
        }

        @media (max-width: 650px) {

            .topbar-inner {
                min-height: auto;
                padding: 15px 0;

                align-items: flex-start;
                flex-direction: column;
            }

            .back-btn {
                width: 100%;
                text-align: center;
            }

            main {
                padding-top: 25px;
            }

            .page-header h2 {
                font-size: 24px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .filter-form {
                grid-template-columns: 1fr;
            }

            .filter-btn {
                width: 100%;
            }
        }

    </style>

</head>

<body>

<div class="page">

    {{-- =========================================================
         TOP BAR
    ========================================================== --}}

    <header class="topbar">

        <div class="topbar-inner">

            <div class="brand">

                <div class="brand-icon">
                    👥
                </div>

                <div>

                    <h1>
                        BenStoke Admin
                    </h1>

                    <p>
                        Staff Management
                    </p>

                </div>

            </div>

            <a
                href="{{ route('admin.dashboard') }}"
                class="back-btn"
            >
                ← Back to Dashboard
            </a>

        </div>

    </header>


    {{-- =========================================================
         MAIN
    ========================================================== --}}

    <main>

        <div class="container">

            {{-- PAGE HEADER --}}

            <div class="page-header">

                <h2>
                    Staff Management
                </h2>

                <p>
                    Review applications and manage restaurant staff accounts.
                </p>

            </div>


            {{-- =================================================
                 SUCCESS MESSAGE
            ================================================== --}}

            @if(session('success'))

                <div class="alert alert-success">
                    ✓ {{ session('success') }}
                </div>

            @endif


            {{-- =================================================
                 ERROR MESSAGE
            ================================================== --}}

            @if($errors->any())

                <div class="alert alert-error">

                    @foreach($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            @endif


            {{-- =================================================
                 STATISTICS
            ================================================== --}}

            <div class="stats">

                <div class="stat-card">

                    <div class="stat-top">

                        <div class="stat-label">
                            Pending Requests
                        </div>

                        <div class="stat-icon">
                            ⏳
                        </div>

                    </div>

                    <div class="stat-value">
                        {{ $pendingStaff }}
                    </div>

                </div>


                <div class="stat-card">

                    <div class="stat-top">

                        <div class="stat-label">
                            Approved Staff
                        </div>

                        <div class="stat-icon">
                            ✓
                        </div>

                    </div>

                    <div class="stat-value">
                        {{ $approvedStaff }}
                    </div>

                </div>


                <div class="stat-card">

                    <div class="stat-top">

                        <div class="stat-label">
                            Suspended
                        </div>

                        <div class="stat-icon">
                            ⚠
                        </div>

                    </div>

                    <div class="stat-value">
                        {{ $suspendedStaff }}
                    </div>

                </div>


                <div class="stat-card">

                    <div class="stat-top">

                        <div class="stat-label">
                            Rejected
                        </div>

                        <div class="stat-icon">
                            ✕
                        </div>

                    </div>

                    <div class="stat-value">
                        {{ $rejectedStaff }}
                    </div>

                </div>

            </div>


            {{-- =================================================
                 FILTER
            ================================================== --}}

            <div class="filter-card">

                <form
                    action="{{ route('admin.staff-requests.index') }}"
                    method="GET"
                    class="filter-form"
                >

                    <div class="field">

                        <label for="search">
                            Search Staff
                        </label>

                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search by name or email..."
                        >

                    </div>


                    <div class="field">

                        <label for="status">
                            Status
                        </label>

                        <select
                            id="status"
                            name="status"
                        >

                            <option value="">
                                All Staff
                            </option>

                            <option
                                value="pending"
                                {{ $status === 'pending' ? 'selected' : '' }}
                            >
                                Pending
                            </option>

                            <option
                                value="approved"
                                {{ $status === 'approved' ? 'selected' : '' }}
                            >
                                Approved
                            </option>

                            <option
                                value="suspended"
                                {{ $status === 'suspended' ? 'selected' : '' }}
                            >
                                Suspended
                            </option>

                            <option
                                value="rejected"
                                {{ $status === 'rejected' ? 'selected' : '' }}
                            >
                                Rejected
                            </option>

                        </select>

                    </div>


                    <button
                        type="submit"
                        class="filter-btn"
                    >
                        Search / Filter
                    </button>

                </form>

            </div>


            {{-- =================================================
                 STAFF TABLE
            ================================================== --}}

            <div class="staff-card">

                <div class="staff-card-header">

                    <h3>
                        Staff Accounts
                    </h3>

                    <div class="staff-count">
                        {{ $staff->total() }} total
                    </div>

                </div>


                @if($staff->count())

                    <div class="table-wrapper">

                        <table>

                            <thead>

                                <tr>

                                    <th>
                                        Staff
                                    </th>

                                    <th>
                                        Role
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                    <th>
                                        Joined
                                    </th>

                                    <th>
                                        Actions
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($staff as $member)

                                    <tr>

                                        {{-- STAFF --}}

                                        <td>

                                            <div class="staff-user">

                                                <div class="avatar">

                                                    {{ strtoupper(
                                                        substr($member->name ?? 'S', 0, 1)
                                                    ) }}

                                                </div>

                                                <div>

                                                    <div class="staff-name">
                                                        {{ $member->name }}
                                                    </div>

                                                    <div class="staff-email">
                                                        {{ $member->email }}
                                                    </div>

                                                </div>

                                            </div>

                                        </td>


                                        {{-- ROLE --}}

                                        <td>

                                            <strong>
                                                Staff
                                            </strong>

                                        </td>


                                        {{-- STATUS --}}

                                        <td>

                                            @php
                                                $statusClass = match($member->staff_status) {
                                                    'approved' => 'status-approved',
                                                    'rejected' => 'status-rejected',
                                                    'suspended' => 'status-suspended',
                                                    default => 'status-pending',
                                                };
                                            @endphp

                                            <span
                                                class="status {{ $statusClass }}"
                                            >
                                                {{ ucfirst($member->staff_status ?? 'pending') }}
                                            </span>

                                        </td>


                                        {{-- JOINED --}}

                                        <td>

                                            {{ $member->created_at
                                                ? $member->created_at->format('d M Y')
                                                : '—'
                                            }}

                                        </td>


                                        {{-- ACTIONS --}}

                                        <td>

                                            <div class="actions">


                                                {{-- PENDING --}}

                                                @if($member->staff_status === 'pending')

                                                    <form
                                                        method="POST"
                                                        action="{{ route(
                                                            'admin.staff-requests.approve',
                                                            $member->id
                                                        ) }}"
                                                        class="action-form"
                                                    >

                                                        @csrf

                                                        @method('PUT')

                                                        <button
                                                            type="submit"
                                                            class="action-btn approve-btn"
                                                        >
                                                            ✓ Approve
                                                        </button>

                                                    </form>


                                                    <form
                                                        method="POST"
                                                        action="{{ route(
                                                            'admin.staff-requests.reject',
                                                            $member->id
                                                        ) }}"
                                                        class="action-form"
                                                    >

                                                        @csrf

                                                        @method('PUT')

                                                        <button
                                                            type="submit"
                                                            class="action-btn reject-btn"
                                                            onclick="return confirm('Reject this staff application?')"
                                                        >
                                                            ✕ Reject
                                                        </button>

                                                    </form>


                                                {{-- APPROVED --}}

                                                @elseif($member->staff_status === 'approved')

                                                    <form
                                                        method="POST"
                                                        action="{{ route(
                                                            'admin.staff-requests.suspend',
                                                            $member->id
                                                        ) }}"
                                                        class="action-form"
                                                    >

                                                        @csrf

                                                        @method('PUT')

                                                        <button
                                                            type="submit"
                                                            class="action-btn suspend-btn"
                                                            onclick="return confirm('Suspend this staff account?')"
                                                        >
                                                            ⚠ Suspend
                                                        </button>

                                                    </form>


                                                {{-- SUSPENDED --}}

                                                @elseif($member->staff_status === 'suspended')

                                                    <form
                                                        method="POST"
                                                        action="{{ route(
                                                            'admin.staff-requests.reactivate',
                                                            $member->id
                                                        ) }}"
                                                        class="action-form"
                                                    >

                                                        @csrf

                                                        @method('PUT')

                                                        <button
                                                            type="submit"
                                                            class="action-btn reactivate-btn"
                                                        >
                                                            ↻ Reactivate
                                                        </button>

                                                    </form>


                                                {{-- REJECTED --}}

                                                @elseif($member->staff_status === 'rejected')

                                                    <span class="no-action">
                                                        Application rejected
                                                    </span>

                                                @else

                                                    <span class="no-action">
                                                        No actions
                                                    </span>

                                                @endif

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    {{-- PAGINATION --}}

                    <div class="pagination">

                        {{ $staff->links() }}

                    </div>


                @else

                    <div class="empty">

                        <div class="empty-icon">
                            👥
                        </div>

                        <h3>
                            No staff found
                        </h3>

                        <p>
                            No staff accounts match your current search or filter.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </main>

</div>

</body>

</html>

