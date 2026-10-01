@extends('layouts.user')

@section('content')
<style>
    .reviews-page {
        --review-accent: #c77b35;
        --review-dark: #24211e;
        --review-muted: #77736e;
        color: var(--review-dark);
        padding: 28px 0 55px;
        font-family: inherit;
    }

    .reviews-page * { box-sizing: border-box; }

    .reviews-hero {
        position: relative;
        overflow: hidden;
        border-radius: 22px;
        padding: 48px 42px;
        margin-bottom: 28px;
        background: linear-gradient(120deg, #28231f, #514033);
        color: #fff;
    }

    .reviews-hero:after {
        content: "✦";
        position: absolute;
        right: 7%;
        top: -45px;
        font-size: 190px;
        color: rgba(255,255,255,.06);
        pointer-events: none;
    }

    .reviews-eyebrow {
        color: #e9b77f;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        margin-bottom: 12px;
    }

    .reviews-hero h1 {
        color: #fff;
        font-size: clamp(28px, 4vw, 42px);
        font-weight: 800;
        margin: 0 0 12px;
        letter-spacing: -.8px;
    }

    .reviews-hero p {
        color: #e2d8ce;
        max-width: 520px;
        margin: 0;
        line-height: 1.7;
        font-size: 15px;
    }

    .reviews-summary {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-bottom: 35px;
    }

    .summary-card {
        background: #fff;
        border: 1px solid #eee9e3;
        border-radius: 18px;
        padding: 25px 28px;
        box-shadow: 0 8px 25px rgba(45,35,25,.035);
    }

    .summary-label {
        color: var(--review-muted);
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .summary-number {
        font-size: 34px;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 8px;
    }

    .review-stars {
        color: #e7a33e;
        letter-spacing: 2px;
        font-size: 17px;
        white-space: nowrap;
    }

    .summary-note {
        color: var(--review-muted);
        font-size: 12px;
        margin-top: 8px;
    }

    .reviews-heading {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 18px;
    }

    .reviews-heading h2 {
        font-size: 24px;
        font-weight: 800;
        margin: 0 0 5px;
    }

    .reviews-heading p {
        color: var(--review-muted);
        font-size: 13px;
        margin: 0;
    }

    .reviews-count {
        color: #8b5a2b;
        background: #f8eee2;
        padding: 7px 13px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .reviews-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .review-card {
        background: #fff;
        border: 1px solid #eee9e3;
        border-radius: 18px;
        padding: 23px;
        transition: transform .2s ease, box-shadow .2s ease;
        min-width: 0;
    }

    .review-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(45,35,25,.08);
    }

    .review-card-top {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 17px;
    }

    .review-avatar {
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #f4e5d3;
        color: #875323;
        font-size: 16px;
        font-weight: 800;
    }

    .review-customer {
        font-size: 14px;
        font-weight: 750;
        margin-bottom: 4px;
        overflow-wrap: anywhere;
    }

    .review-date {
        color: #99918a;
        font-size: 11px;
    }

    .review-verified {
        display: inline-block;
        color: #397a58;
        background: #eaf5ed;
        border-radius: 20px;
        padding: 4px 8px;
        font-size: 10px;
        font-weight: 700;
        margin-left: auto;
        white-space: nowrap;
    }

    .review-comment {
        color: #5f5a55;
        font-size: 13px;
        line-height: 1.8;
        margin: 14px 0 0;
        overflow-wrap: anywhere;
        white-space: normal;
    }

    .review-quote {
        color: #d7b18a;
        font-size: 27px;
        line-height: 1;
        font-family: Georgia, serif;
    }

    .reviews-empty {
        text-align: center;
        background: #fff;
        border: 1px dashed #dfd5ca;
        border-radius: 18px;
        padding: 50px 20px;
    }

    .reviews-empty-icon {
        font-size: 38px;
        margin-bottom: 12px;
    }

    .reviews-empty h3 {
        font-size: 19px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .reviews-empty p {
        color: var(--review-muted);
        font-size: 13px;
        margin: 0;
    }

    .reviews-pagination {
        margin-top: 28px;
    }

    .reviews-pagination nav {
        display: flex;
        justify-content: center;
    }

    .reviews-pagination svg {
        width: 16px;
        height: 16px;
    }

    .reviews-pagination p {
        font-size: 12px;
        color: var(--review-muted);
    }

    @media (max-width: 1000px) {
        .reviews-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 600px) {
        .reviews-page { padding: 16px 0 35px; }
        .reviews-hero { padding: 32px 24px; border-radius: 16px; }
        .reviews-summary { gap: 10px; }
        .summary-card { padding: 18px 15px; }
        .summary-number { font-size: 27px; }
        .reviews-grid { grid-template-columns: 1fr; }
        .reviews-heading h2 { font-size: 21px; }
        .review-card { padding: 20px; }
        .review-verified { font-size: 9px; }
    }
</style>

<div class="reviews-page">
    <div class="reviews-hero">
        <div class="reviews-eyebrow">From Our Guests</div>
        <h1>Stories Worth Savoring</h1>
        <p>
            Every meal has a story. Discover what our guests are saying
            about their dining experiences with us.
        </p>
    </div>

    <div class="reviews-summary">
        <div class="summary-card">
            <div class="summary-label">Guest Satisfaction</div>
            <div class="summary-number">
                {{ number_format((float) $averageRating, 1) }}
                <span style="font-size:16px;color:#999;">/ 5</span>
            </div>
            <div class="review-stars">
                @for ($i = 1; $i <= 5; $i++)
                    {{ $i <= round((float) $averageRating) ? '★' : '☆' }}
                @endfor
            </div>
            <div class="summary-note">Average guest rating</div>
        </div>

        <div class="summary-card">
            <div class="summary-label">Guest Reviews</div>
            <div class="summary-number">
                {{ number_format($totalReviews) }}
            </div>
            <div class="review-stars">✦ <span style="color:#777;font-size:12px;letter-spacing:0;">Guest experiences shared</span></div>
            <div class="summary-note">Reviews published by our guests</div>
        </div>
    </div>

    <div class="reviews-heading">
        <div>
            <h2>What Guests Say</h2>
            <p>Real experiences from our dining community.</p>
        </div>

        <span class="reviews-count">
            {{ $totalReviews }} {{ $totalReviews == 1 ? 'REVIEW' : 'REVIEWS' }}
        </span>
    </div>

    @if ($reviews->count())
        <div class="reviews-grid">
            @foreach ($reviews as $review)
                <article class="review-card">
                    <div class="review-card-top">
                        <div class="review-avatar">
                            {{ strtoupper(substr($review->user->name ?? 'G', 0, 1)) }}
                        </div>

                        <div style="min-width:0;">
                            <div class="review-customer">
                                {{ $review->user->name ?? 'Guest' }}
                            </div>
                            <div class="review-date">
                                {{ $review->created_at->format('M d, Y') }}
                            </div>
                        </div>

                        <span class="review-verified">✓ Verified</span>
                    </div>

                    <div class="review-stars" aria-label="{{ $review->rating }} out of 5 stars">
                        @for ($i = 1; $i <= 5; $i++)
                            {{ $i <= $review->rating ? '★' : '☆' }}
                        @endfor
                    </div>

                    <p class="review-comment">
                        <span class="review-quote">“</span>
                        {{ $review->comment ?: 'A wonderful dining experience!' }}
                    </p>
                </article>
            @endforeach
        </div>

        <div class="reviews-pagination">
            {{ $reviews->links() }}
        </div>
    @else
        <div class="reviews-empty">
            <div class="reviews-empty-icon">☆</div>
            <h3>Our story is just getting started</h3>
            <p>There are no published reviews yet. Be the first to share your experience!</p>
        </div>
    @endif
</div>
@endsection
