@extends('layouts.user')

@section('title', 'Customer Feedback')

@section('content')
<style>
    .feedback-container {
        max-width: 850px;
        margin: 35px auto;
        padding: 20px;
    }

    .feedback-card {
        background: #fff;
        border-radius: 14px;
        padding: 28px;
        margin-bottom: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,.07);
    }

    .feedback-title {
        font-size: 25px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #1f2937;
    }

    .feedback-subtitle {
        color: #6b7280;
        margin-bottom: 22px;
    }

    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 6px;
        margin: 12px 0 22px;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        font-size: 36px;
        color: #d1d5db;
        cursor: pointer;
        transition: color .15s;
    }

    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input:checked ~ label {
        color: #f59e0b;
    }

    .feedback-textarea {
        width: 100%;
        min-height: 130px;
        padding: 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        resize: vertical;
    }

    .feedback-submit {
        margin-top: 18px;
        padding: 12px 24px;
        border: 0;
        border-radius: 8px;
        background: #2563eb;
        color: white;
        font-weight: 600;
        cursor: pointer;
    }

    .feedback-submit:hover {
        background: #1d4ed8;
    }

    .review-stars {
        color: #f59e0b;
        font-size: 20px;
        letter-spacing: 2px;
    }

    .review-date {
        color: #9ca3af;
        font-size: 13px;
    }
</style>

<div class="feedback-container">

    <div class="feedback-card">
        <h1 class="feedback-title">Share Your Experience</h1>
        <p class="feedback-subtitle">
            Your feedback helps us improve our food and service.
        </p>

        @if(session('success'))
            <div style="padding:12px; background:#dcfce7; color:#166534;
                        border-radius:8px; margin-bottom:18px;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="padding:12px; background:#fee2e2; color:#991b1b;
                        border-radius:8px; margin-bottom:18px;">
                <ul style="margin:0; padding-left:20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('feedback.store') }}" method="POST">
            @csrf

            <label><strong>Rate your experience</strong></label>

            <div class="star-rating">
                <input type="radio" id="star5" name="rating"
                       value="5" {{ old('rating') == 5 ? 'checked' : '' }}>
                <label for="star5" title="5 stars">&#9733;</label>

                <input type="radio" id="star4" name="rating"
                       value="4" {{ old('rating') == 4 ? 'checked' : '' }}>
                <label for="star4" title="4 stars">&#9733;</label>

                <input type="radio" id="star3" name="rating"
                       value="3" {{ old('rating') == 3 ? 'checked' : '' }}>
                <label for="star3" title="3 stars">&#9733;</label>

                <input type="radio" id="star2" name="rating"
                       value="2" {{ old('rating') == 2 ? 'checked' : '' }}>
                <label for="star2" title="2 stars">&#9733;</label>

                <input type="radio" id="star1" name="rating"
                       value="1" {{ old('rating') == 1 ? 'checked' : '' }}>
                <label for="star1" title="1 star">&#9733;</label>
            </div>

            @error('rating')
                <div style="color:#dc2626;">{{ $message }}</div>
            @enderror

            <label for="comment"><strong>Your Review</strong></label>

            <textarea
                id="comment"
                name="comment"
                class="feedback-textarea"
                placeholder="Tell us about your experience..."
                required
                minlength="3"
                maxlength="1000"
            >{{ old('comment') }}</textarea>

            @error('comment')
                <div style="color:#dc2626;">{{ $message }}</div>
            @enderror

            <button type="submit" class="feedback-submit">
                Submit Feedback
            </button>
        </form>
    </div>

    <div class="feedback-card">
        <h2 class="feedback-title">My Feedback History</h2>

        @forelse($feedbacks as $feedback)
            <div style="padding:18px 0; border-bottom:1px solid #e5e7eb;">
                <div class="review-stars">
                    @for($i = 1; $i <= 5; $i++)
                        {{ $i <= $feedback->rating ? '★' : '☆' }}
                    @endfor
                </div>

                <p style="margin:10px 0;">
                    {{ $feedback->comment }}
                </p>

                <div class="review-date">
                    {{ $feedback->created_at->format('d M Y, h:i A') }}
                </div>
            </div>
        @empty
            <p style="color:#6b7280;">
                You haven't submitted any feedback yet.
            </p>
        @endforelse
    </div>

</div>
@endsection
