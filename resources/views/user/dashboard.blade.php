@extends('layouts.user')

@section('styles')
<style>
    .dashboard-page {
        max-width: 1250px;
        margin: 0 auto;
        padding: 24px;
        color: #29221c;
    }

    .dashboard-hero {
        background: linear-gradient(120deg, #29221c, #59432f);
        color: #fff;
        padding: 42px;
        border-radius: 20px;
        margin-bottom: 28px;
    }

    .hero-eyebrow {
        color: #e5bd78;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .hero-content h1 {
        font-size: clamp(26px, 4vw, 38px);
        margin: 12px 0;
        font-weight: 800;
    }

    .hero-content p {
        color: #e8ded2;
        max-width: 650px;
        line-height: 1.7;
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 24px;
    }

    .hero-btn {
        display: inline-block;
        padding: 12px 20px;
        border-radius: 9px;
        text-decoration: none;
        font-weight: 700;
        transition: .2s;
    }

    .hero-btn-primary {
        background: #c9974d;
        color: #fff;
    }

    .hero-btn-secondary {
        border: 1px solid #d8c4a7;
        color: #fff;
    }

    .hero-btn:hover {
        transform: translateY(-2px);
        opacity: .92;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 35px;
    }

    .stat-card {
        display: flex;
        align-items: center;
        gap: 16px;
        background: #fff;
        border: 1px solid #eee6dc;
        border-radius: 15px;
        padding: 22px;
        box-shadow: 0 4px 16px rgba(40, 30, 20, .04);
    }

    .stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 52px;
        height: 52px;
        border-radius: 13px;
        font-size: 24px;
        flex-shrink: 0;
    }

    .stat-icon.gold { background: #fff4db; }
    .stat-icon.green { background: #e6f6ec; }
    .stat-icon.blue { background: #e8f1ff; }

    .stat-label,
    .stat-value,
    .stat-subtext {
        display: block;
    }

    .stat-label {
        color: #897d71;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .stat-value {
        font-size: 22px;
        font-weight: 800;
        overflow-wrap: anywhere;
    }

    .stat-subtext {
        font-size: 12px;
        color: #9b9187;
        margin-top: 5px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .section-title-wrap h2 {
        margin: 0 0 5px;
        font-size: 23px;
    }

    .section-title-wrap p {
        margin: 0;
        color: #897d71;
        font-size: 13px;
    }

    .see-all {
        color: #a8752d;
        font-weight: 700;
        text-decoration: none;
        font-size: 14px;
    }

    .food-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 38px;
    }

    .food-card {
        background: #fff;
        border: 1px solid #eee6dc;
        border-radius: 15px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        min-width: 0;
        box-shadow: 0 4px 16px rgba(40, 30, 20, .04);
    }

    .food-image-wrap {
        height: 190px;
        background: #f8f4ed;
        overflow: hidden;
        position: relative;
    }

    .food-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .food-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        color: #c7b69e;
        background: #f8f4ed;
    }

    .food-content {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex: 1;
        padding: 16px;
        gap: 18px;
    }

    .food-meta {
        font-size: 11px;
        color: #a8752d;
        margin-bottom: 8px;
    }

    .food-subcategory {
        color: #9b9187;
    }

    .food-name-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 8px;
    }

    .food-name {
        margin: 0;
        font-size: 16px;
        line-height: 1.4;
        overflow-wrap: anywhere;
    }

    .food-price {
        color: #a8752d;
        font-weight: 800;
        white-space: nowrap;
        font-size: 14px;
    }

    .food-description {
        color: #897d71;
        font-size: 12px;
        line-height: 1.6;
        margin: 10px 0 0;
    }

    .food-action {
        display: block;
        text-align: center;
        padding: 11px;
        background: #c9974d;
        color: #fff;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
        font-size: 13px;
    }

    .food-action:hover {
        background: #b4823c;
    }

    .empty-card {
        grid-column: 1 / -1;
        text-align: center;
        padding: 35px 20px;
        background: #fff;
        border: 1px dashed #e3d6c5;
        border-radius: 14px;
    }

    .empty-icon {
        font-size: 38px;
    }

    .empty-card p {
        color: #897d71;
        font-size: 13px;
    }

    .empty-btn {
        display: inline-block;
        padding: 10px 16px;
        background: #c9974d;
        color: #fff;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
    }

    .quick-section {
        margin-top: 10px;
    }

    .quick-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 15px;
        margin-bottom: 30px;
    }

    .quick-card {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px;
        border: 1px solid #eee6dc;
        background: #fff;
        border-radius: 13px;
        text-decoration: none;
        color: #29221c;
        transition: .2s;
    }

    .quick-card:hover {
        border-color: #c9974d;
        transform: translateY(-2px);
    }

    .quick-icon {
        font-size: 26px;
        background: #f8f4ed;
        border-radius: 10px;
        padding: 10px;
    }

    .quick-text strong,
    .quick-text span {
        display: block;
    }

    .quick-text strong {
        font-size: 14px;
    }

    .quick-text span {
        font-size: 12px;
        color: #897d71;
        margin-top: 4px;
    }

    .feedback-pending {
        background: #fff;
        border: 1px solid #eee6dc;
        border-radius: 16px;
        padding: 22px;
        margin-bottom: 25px;
    }

    .feedback-pending h2 {
        color: #29221c;
        margin: 0 0 8px;
    }

    .feedback-pending > p {
        color: #897d71;
        font-size: 13px;
    }

    .pending-order-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        border-top: 1px solid #eee6dc;
        padding: 14px 0;
    }

    .pending-order-meta {
        font-size: 12px;
        color: #897d71;
        margin-top: 4px;
    }

    .pending-badge {
        background: #fff4db;
        color: #986b24;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .leave-feedback-btn {
        display: inline-block;
        background: #c9974d;
        color: #fff;
        padding: 8px 14px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
    }

    .feedback-popup-overlay {
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(0, 0, 0, .65);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        overflow-y: auto;
    }

    .feedback-popup {
        background: #fff;
        width: 100%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        border-radius: 18px;
        padding: 26px;
        position: relative;
    }

    .feedback-close {
        position: absolute;
        top: 14px;
        right: 14px;
        border: 0;
        background: #f3f4f6;
        border-radius: 50%;
        width: 34px;
        height: 34px;
        font-size: 20px;
        cursor: pointer;
    }

    .feedback-eyebrow {
        font-size: 12px;
        color: #b88746;
        font-weight: 800;
    }

    .feedback-popup h2 {
        margin: 8px 35px 8px 0;
        color: #29221c;
    }

    .feedback-popup p {
        color: #777;
        font-size: 14px;
    }

    .feedback-stars {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin: 12px 0 20px;
    }

    .feedback-star-option {
        cursor: pointer;
        text-align: center;
    }

    .feedback-star-option span {
        font-size: 24px;
        color: #f59e0b;
    }

    .feedback-aspects {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin: 12px 0 20px;
    }

    .feedback-aspect {
        background: #f8f4ed;
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 13px;
        cursor: pointer;
    }

    .feedback-popup textarea {
        width: 100%;
        min-height: 100px;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 9px;
        margin: 10px 0 18px;
        box-sizing: border-box;
        font: inherit;
    }

    .feedback-popup input[type="file"] {
        display: block;
        margin: 10px 0 20px;
        max-width: 100%;
    }

    .feedback-submit {
        width: 100%;
        padding: 13px;
        border: 0;
        border-radius: 9px;
        background: #c9974d;
        color: #fff;
        font-weight: 800;
        cursor: pointer;
    }

    .feedback-errors {
        background: #fff0f0;
        color: #a12626;
        border: 1px solid #f2caca;
        border-radius: 9px;
        padding: 12px 16px;
        margin-bottom: 18px;
    }

    @media (max-width: 1000px) {
        .food-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .stats-grid,
        .quick-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .dashboard-page {
            padding: 14px;
        }

        .dashboard-hero {
            padding: 26px 20px;
        }

        .stats-grid,
        .food-grid,
        .quick-grid {
            grid-template-columns: 1fr;
        }

        .stat-card {
            padding: 17px;
        }

        .feedback-popup {
            padding: 22px 18px;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-page">

    {{-- SUCCESS / ERROR MESSAGES --}}
    @if(session('success'))
        <div style="background:#e8f7ed;color:#216e39;padding:12px 16px;border-radius:9px;margin-bottom:18px;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="feedback-errors">
            <strong>Please correct the following:</strong>
            <ul style="margin:8px 0 0;padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FEEDBACK POPUP FOR THE ACTIVE COMPLETED ORDER --}}
    @if(
    isset($activeFeedbackOrder) &&
    $activeFeedbackOrder &&
    !$activeFeedbackOrder->feedback
)

        <div class="feedback-popup-overlay" id="feedbackPopup">
            <div class="feedback-popup">

                {{-- DISMISS BUTTON --}}
                <form method="POST"
                      action="{{ route('feedback.dismiss', $activeFeedbackOrder->id) }}"
                      style="position:absolute;top:14px;right:14px;">
                    @csrf

                    <button type="submit"
                            class="feedback-close"
                            aria-label="Close feedback popup">
                        ×
                    </button>
                </form>

                <div class="feedback-eyebrow">YOUR ORDER IS COMPLETE</div>

                <h2>How was your experience?</h2>

                <p>
                    Order #{{ $activeFeedbackOrder->id }} is complete.
                    We'd love to hear your feedback!
                </p>

                {{-- FEEDBACK SUBMISSION FORM --}}
                <form method="POST"
                      action="{{ route('feedback.store') }}"
                      enctype="multipart/form-data">
                    @csrf

                    <input type="hidden"
                           name="order_id"
                           value="{{ $activeFeedbackOrder->id }}">

                    <label><strong>Rate your experience</strong></label>

                    <div class="feedback-stars">
                        @for($star = 1; $star <= 5; $star++)
                            <label class="feedback-star-option">
                                <input type="radio"
                                       name="rating"
                                       value="{{ $star }}"
                                       required>
                                <span>{{ $star }} ★</span>
                            </label>
                        @endfor
                    </div>

                    <label>
                        <strong>What would you like to rate?</strong>
                    </label>

                    <div class="feedback-aspects">
                        @foreach([
                            'Food Quality',
                            'Taste',
                            'Packaging',
                            'Portion Size',
                            'Value for Money',
                            'Service'
                        ] as $aspect)
                            <label class="feedback-aspect">
                                <input type="checkbox"
                                       name="aspects[]"
                                       value="{{ $aspect }}">
                                {{ $aspect }}
                            </label>
                        @endforeach
                    </div>

                    <label for="feedback-comment">
                        <strong>Describe your experience</strong>
                    </label>

                    <textarea id="feedback-comment"
                              name="comment"
                              required
                              minlength="3"
                              maxlength="1000"
                              placeholder="Tell us what you liked or what we can improve...">{{ old('comment') }}</textarea>

                    <label for="feedback-images">
                        <strong>Add food photos (optional)</strong>
                    </label>

                    <input id="feedback-images"
                           type="file"
                           name="images[]"
                           accept="image/jpeg,image/png,image/webp"
                           multiple>

                    <button type="submit" class="feedback-submit">
                        Submit Feedback
                    </button>
                </form>

                <p style="font-size:12px;color:#888;margin-top:12px;">
                    You can close this popup and leave feedback later.
                </p>
            </div>
        </div>
    @endif


    {{-- FEEDBACK PENDING SECTION --}}
    @if(isset($pendingFeedbackOrders) && $pendingFeedbackOrders->isNotEmpty())

        <section class="feedback-pending">
        <h2>⭐ Your Feedback</h2>

        <p>Share your experience for each completed order.</p>

        @foreach($pendingFeedbackOrders as $pendingOrder)

            {{-- Extra protection: hide orders that already have feedback --}}
            @if(!$pendingOrder->feedback)

                <div class="pending-order-row">

                    <div>
                        <strong>Order #{{ $pendingOrder->id }}</strong>

                        <div class="pending-order-meta">
                            {{ $pendingOrder->created_at->format('d M Y') }}
                            · ₹{{ number_format($pendingOrder->total_amount, 2) }}
                        </div>
                    </div>

                    <span class="pending-badge">
                        Feedback Pending
                    </span>

                    <a href="{{ route('feedback') }}"
                       class="leave-feedback-btn">
                        Leave Feedback →
                    </a>

                </div>

            @endif

        @endforeach
    </section>
    @endif


    {{-- HERO --}}
    <section class="dashboard-hero">
        <div class="hero-content">

            <div class="hero-eyebrow">✦ Your Dining Space</div>

            <h1>Welcome back, {{ auth()->user()->name }}!</h1>

            <p>
                Discover delicious dishes, manage your orders,
                book a table, and keep track of your restaurant rewards.
            </p>

            <div class="hero-actions">
                <a href="{{ route('user.menu') }}"
                   class="hero-btn hero-btn-primary">
                    🍽️ Explore Menu
                </a>

                <a href="{{ route('user.book-table') }}"
                   class="hero-btn hero-btn-secondary">
                    🪑 Book a Table
                </a>
            </div>
        </div>
    </section>


    {{-- STATISTICS --}}
    <section class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon gold">👑</div>

            <div>
                <span class="stat-label">Loyalty Tier</span>

                <span class="stat-value">
                    {{ $loyaltyTier ?? 'Normal Member' }}
                </span>

                <span class="stat-subtext">
                    Your current membership level
                </span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">🛍️</div>

            <div>
                <span class="stat-label">Total Orders</span>

                <span class="stat-value">
                    {{ $totalBookings ?? 0 }}
                </span>

                <span class="stat-subtext">
                    Orders placed from your account
                </span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blue">⭐</div>

            <div>
                <span class="stat-label">Reward Points</span>

                <span class="stat-value">
                    {{ number_format($rewardPoints ?? 0) }}
                </span>

                <span class="stat-subtext">
                    ₹{{ number_format($totalSpent ?? 0, 2) }} total spent
                </span>
            </div>
        </div>

    </section>


    {{-- RECOMMENDATIONS --}}
    <section>
        <div class="section-header">

            <div class="section-title-wrap">
                <h2>Today's Recommendations</h2>
                <p>Fresh selections from our kitchen</p>
            </div>

            <a href="{{ route('user.menu') }}" class="see-all">
                View Full Menu →
            </a>
        </div>

        <div class="food-grid">

            @forelse(($recommendedItems ?? collect()) as $item)

                <article class="food-card">

                    <div class="food-image-wrap">

                        @if($item->image)
                            <img
                                src="{{ asset('storage/' . ltrim($item->image, '/')) }}"
                                alt="{{ $item->name }}"
                                class="food-image"
                                loading="lazy"
                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">

                            <div class="food-placeholder" style="display:none;">
                                🍽️
                            </div>
                        @else
                            <div class="food-placeholder">🍽️</div>
                        @endif

                    </div>

                    <div class="food-content">
                        <div>
                            <div class="food-meta">

                                @if($item->category)
                                    <span class="food-category">
                                        {{ $item->category }}
                                    </span>
                                @endif

                                @if($item->subcategory)
                                    <span class="food-subcategory">
                                        • {{ $item->subcategory }}
                                    </span>
                                @endif
                            </div>

                            <div class="food-name-row">
                                <h3 class="food-name">{{ $item->name }}</h3>

                                <span class="food-price">
                                    ₹{{ number_format($item->price, 2) }}
                                </span>
                            </div>

                            <p class="food-description">
                                {{ $item->description ?? 'Delicious food freshly prepared by our restaurant.' }}
                            </p>
                        </div>

                        <a href="{{ route('user.menu', ['item' => $item->id]) }}"
                           class="food-action">
                            Order Now →
                        </a>
                    </div>
                </article>

            @empty
                <div class="empty-card">
                    <div class="empty-icon">🍽️</div>

                    <h3>No Recommendations Yet</h3>

                    <p>
                        New dishes will appear here when they become available.
                    </p>

                    <a href="{{ route('user.menu') }}" class="empty-btn">
                        Explore Menu
                    </a>
                </div>
            @endforelse

        </div>
    </section>


    {{-- QUICK ACCESS --}}
    <section class="quick-section">

        <div class="section-header">
            <div class="section-title-wrap">
                <h2>Quick Access</h2>
                <p>Everything you need in one place</p>
            </div>
        </div>

        <div class="quick-grid">

            <a href="{{ route('user.cart') }}" class="quick-card">
                <div class="quick-icon">🛒</div>
                <div class="quick-text">
                    <strong>My Cart</strong>
                    <span>Review your selection</span>
                </div>
            </a>

            <a href="{{ route('user.orders') }}" class="quick-card">
                <div class="quick-icon">📦</div>
                <div class="quick-text">
                    <strong>My Orders</strong>
                    <span>View your order history</span>
                </div>
            </a>

            <a href="{{ route('user.reservations') }}" class="quick-card">
                <div class="quick-icon">📅</div>
                <div class="quick-text">
                    <strong>Reservations</strong>
                    <span>Manage your bookings</span>
                </div>
            </a>

            <a href="{{ route('user.profile') }}" class="quick-card">
                <div class="quick-icon">👤</div>
                <div class="quick-text">
                    <strong>My Profile</strong>
                    <span>Update your account</span>
                </div>
            </a>

            <a href="{{ route('feedback') }}" class="quick-card">
                <div class="quick-icon">⭐</div>
                <div class="quick-text">
                    <strong>Give Feedback</strong>
                    <span>Share your dining experience</span>
                </div>
            </a>

        </div>

        <a href="{{ route('reviews.index') }}">Customer Reviews</a>
    </section>

</div>
@endsection
