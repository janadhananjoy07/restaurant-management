@extends('layouts.admin')

@section('content')

<style>
    .feedback-page {
        --fb-primary: #4f46e5;
        --fb-text: #172033;
        --fb-muted: #64748b;
        color: var(--fb-text);
        padding: 10px 0 30px;
    }

    .feedback-page * {
        box-sizing: border-box;
    }

    .feedback-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 26px;
    }

    .feedback-header h2 {
        font-size: 27px;
        font-weight: 800;
        margin: 0 0 6px;
        letter-spacing: -0.7px;
    }

    .feedback-header p {
        color: var(--fb-muted);
        margin: 0;
        font-size: 14px;
    }

    .feedback-header .header-tag {
        background: #eef2ff;
        color: #4338ca;
        padding: 9px 14px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
    }

    .feedback-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 25px;
    }

    .feedback-stat {
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, .035);
    }

    .feedback-stat .stat-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 13px;
    }

    .feedback-stat .stat-label {
        color: var(--fb-muted);
        font-size: 13px;
        font-weight: 600;
    }

    .feedback-stat .stat-icon {
        display: grid;
        place-items: center;
        width: 38px;
        height: 38px;
        border-radius: 11px;
        font-size: 18px;
    }

    .feedback-stat .stat-value {
        font-size: 29px;
        font-weight: 800;
        line-height: 1.2;
    }

    .stat-total .stat-icon {
        background: #eef2ff;
        color: #4f46e5;
    }

    .stat-pending .stat-icon {
        background: #fff7ed;
        color: #ea580c;
    }

    .stat-approved .stat-icon {
        background: #ecfdf5;
        color: #059669;
    }

    .feedback-alert {
        padding: 13px 16px;
        border-radius: 11px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    .feedback-alert.success {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    .feedback-alert.error {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .feedback-panel {
        background: #fff;
        border: 1px solid #e8edf4;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(15, 23, 42, .04);
    }

    .feedback-panel-head {
        padding: 20px 23px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid #edf0f5;
        flex-wrap: wrap;
    }

    .feedback-panel-head h3 {
        font-size: 17px;
        font-weight: 750;
        margin: 0 0 4px;
    }

    .feedback-panel-head p {
        color: var(--fb-muted);
        font-size: 12px;
        margin: 0;
    }

    .feedback-count {
        background: #f1f5f9;
        color: #475569;
        border-radius: 8px;
        padding: 7px 11px;
        font-size: 12px;
        font-weight: 700;
    }

    .feedback-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .feedback-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    .feedback-table thead {
        background: #f8fafc;
    }

    .feedback-table th {
        color: #64748b;
        text-transform: uppercase;
        font-size: 10px;
        letter-spacing: .7px;
        font-weight: 800;
        padding: 14px 18px;
        text-align: left;
        white-space: nowrap;
        border-bottom: 1px solid #edf0f5;
    }

    .feedback-table td {
        padding: 17px 18px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: top;
        font-size: 13px;
    }

    .feedback-table tbody tr:hover {
        background: #fafbff;
    }

    .feedback-table tbody tr:last-child td {
        border-bottom: none;
    }

    .customer-cell {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 150px;
    }

    .customer-avatar {
        width: 38px;
        height: 38px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        border-radius: 12px;
        background: #eef2ff;
        color: #4f46e5;
        font-weight: 800;
        font-size: 14px;
    }

    .customer-name {
        font-weight: 750;
        color: #1e293b;
        margin-bottom: 3px;
    }

    .customer-id {
        font-size: 11px;
        color: #94a3b8;
    }

    .rating-stars {
        color: #f59e0b;
        letter-spacing: 1px;
        white-space: nowrap;
        font-size: 15px;
    }

    .rating-number {
        display: block;
        font-size: 11px;
        color: #64748b;
        margin-top: 3px;
    }

    .review-comment {
        color: #475569;
        line-height: 1.6;
        max-width: 270px;
        overflow-wrap: anywhere;
    }

    .review-date {
        white-space: nowrap;
        color: #64748b;
        font-size: 12px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 750;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .status-badge::before {
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

    .feedback-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        min-width: 170px;
    }

    .feedback-actions form {
        margin: 0;
    }

    .feedback-action-btn {
        border: 1px solid transparent;
        border-radius: 8px;
        padding: 7px 10px;
        font-size: 11px;
        font-weight: 750;
        cursor: pointer;
        transition: .2s ease;
    }

    .feedback-action-btn:hover {
        transform: translateY(-1px);
        filter: brightness(.97);
    }

    .btn-approve {
        background: #ecfdf5;
        color: #047857;
        border-color: #a7f3d0;
    }

    .btn-reject {
        background: #fef2f2;
        color: #b91c1c;
        border-color: #fecaca;
    }

    .btn-pending {
        background: #fff7ed;
        color: #c2410c;
        border-color: #fed7aa;
    }

    .feedback-empty {
        text-align: center;
        padding: 55px 20px;
    }

    .feedback-empty .empty-icon {
        width: 60px;
        height: 60px;
        display: grid;
        place-items: center;
        margin: 0 auto 15px;
        background: #f1f5f9;
        border-radius: 18px;
        font-size: 25px;
    }

    .feedback-empty h4 {
        font-size: 17px;
        font-weight: 750;
        margin-bottom: 7px;
    }

    .feedback-empty p {
        color: #64748b;
        font-size: 13px;
        margin: 0;
    }

    .feedback-pagination {
        padding: 18px 22px;
        border-top: 1px solid #edf0f5;
    }

    .feedback-pagination nav {
        display: flex;
        justify-content: flex-end;
    }

    @media (max-width: 768px) {
        .feedback-stats {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .feedback-header h2 {
            font-size: 23px;
        }

        .feedback-panel-head {
            padding: 17px;
        }
    }
</style>

<div class="feedback-page">

    {{-- Page Header --}}
    <div class="feedback-header">
        <div>
            <h2>Customer Reviews</h2>
            <p>Review, manage, and moderate customer feedback.</p>
        </div>

        <div class="header-tag">
            ✦ Feedback Management
        </div>
    </div>


    {{-- Statistics --}}
    <div class="feedback-stats">

        <div class="feedback-stat stat-total">
            <div class="stat-top">
                <span class="stat-label">Total Reviews</span>
                <span class="stat-icon">▤</span>
            </div>

            <div class="stat-value">
                {{ \App\Models\Feedback::count() }}
            </div>
        </div>

        <div class="feedback-stat stat-pending">
            <div class="stat-top">
                <span class="stat-label">Pending Reviews</span>
                <span class="stat-icon">◷</span>
            </div>

            <div class="stat-value">
                {{ \App\Models\Feedback::where('status', 'pending')->count() }}
            </div>
        </div>

        <div class="feedback-stat stat-approved">
            <div class="stat-top">
                <span class="stat-label">Approved Reviews</span>
                <span class="stat-icon">✓</span>
            </div>

            <div class="stat-value">
                {{ \App\Models\Feedback::where('status', 'approved')->count() }}
            </div>
        </div>

    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="feedback-alert success">
            ✓ {{ session('success') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="feedback-alert error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif


    {{-- Feedback Table --}}
    <div class="feedback-panel">

        <div class="feedback-panel-head">
            <div>
                <h3>All Customer Feedback</h3>
                <p>Manage review visibility on the public reviews page.</p>
            </div>

            <span class="feedback-count">
                {{ $feedbacks->total() }} Reviews
            </span>
        </div>


        @if($feedbacks->count())

            <div class="feedback-table-wrap">
                <table class="feedback-table">

                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Moderation</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($feedbacks as $feedback)

                            <tr>

                                {{-- Customer --}}
                                <td>
                                    <div class="customer-cell">

                                        <div class="customer-avatar">
                                            {{ strtoupper(substr($feedback->user->name ?? 'C', 0, 1)) }}
                                        </div>

                                        <div>
                                            <div class="customer-name">
                                                {{ $feedback->user->name ?? 'Customer' }}
                                            </div>

                                            <div class="customer-id">
                                                Review #{{ $feedback->id }}
                                            </div>
                                        </div>

                                    </div>
                                </td>


                                {{-- Rating --}}
                                <td>
                                    <div class="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            {{ $i <= $feedback->rating ? '★' : '☆' }}
                                        @endfor
                                    </div>

                                    <span class="rating-number">
                                        {{ $feedback->rating }}/5
                                    </span>
                                </td>


                                {{-- Review --}}
                                <td>
                                    <div class="review-comment">
                                        {{ $feedback->comment ?: 'No written comment.' }}
                                    </div>
                                </td>


                                {{-- Date --}}
                                <td>
                                    <div class="review-date">
                                        {{ $feedback->created_at?->format('d M Y') ?? '—' }}
                                    </div>
                                </td>


                                {{-- Status --}}
                                <td>
                                    <span class="status-badge status-{{ $feedback->status }}">
                                        {{ $feedback->status }}
                                    </span>
                                </td>


                                {{-- Actions --}}
                                <td>
                                    <div class="feedback-actions">

                                        @if($feedback->status !== 'approved')
                                            <form method="POST"
                                                  action="{{ route('admin.feedback.status', $feedback->id) }}">
                                                @csrf
                                                @method('PATCH')

                                                <input type="hidden"
                                                       name="status"
                                                       value="approved">

                                                <button type="submit"
                                                        class="feedback-action-btn btn-approve">
                                                    ✓ Approve
                                                </button>
                                            </form>
                                        @endif


                                        @if($feedback->status !== 'rejected')
                                            <form method="POST"
                                                  action="{{ route('admin.feedback.status', $feedback->id) }}">
                                                @csrf
                                                @method('PATCH')

                                                <input type="hidden"
                                                       name="status"
                                                       value="rejected">

                                                <button type="submit"
                                                        class="feedback-action-btn btn-reject">
                                                    ✕ Reject
                                                </button>
                                            </form>
                                        @endif


                                        @if($feedback->status !== 'pending')
                                            <form method="POST"
                                                  action="{{ route('admin.feedback.status', $feedback->id) }}">
                                                @csrf
                                                @method('PATCH')

                                                <input type="hidden"
                                                       name="status"
                                                       value="pending">

                                                <button type="submit"
                                                        class="feedback-action-btn btn-pending">
                                                    ↺ Pending
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>

                            </tr>

                        @endforeach
                    </tbody>

                </table>
            </div>


            {{-- Pagination --}}
            <div class="feedback-pagination">
                {{ $feedbacks->links() }}
            </div>

        @else

            <div class="feedback-empty">
                <div class="empty-icon">☆</div>
                <h4>No customer reviews yet</h4>
                <p>Customer feedback will appear here when submitted.</p>
            </div>

        @endif

    </div>

</div>

@endsection
