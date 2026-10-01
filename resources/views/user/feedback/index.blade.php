@extends('layouts.user')

@section('styles')
<style>
    .feedback-page {
        max-width: 950px;
        margin: 0 auto;
        padding: 30px 20px 50px;
        color: #2d251e;
    }

    .feedback-header {
        text-align: center;
        margin-bottom: 28px;
    }

    .feedback-header .eyebrow {
        color: #b88746;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .feedback-header h1 {
        font-size: clamp(27px, 4vw, 36px);
        margin: 10px 0;
        font-weight: 800;
    }

    .feedback-header p {
        color: #83776c;
        font-size: 15px;
        line-height: 1.6;
        margin: 0;
    }

    .feedback-card {
        background: #fff;
        border: 1px solid #eee5d9;
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 12px 35px rgba(50, 35, 20, .07);
    }

    .feedback-card h2 {
        margin: 0 0 8px;
        font-size: 21px;
    }

    .form-intro {
        margin: 0 0 25px;
        color: #8a7e72;
        font-size: 13px;
        line-height: 1.6;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        font-weight: 700;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .required {
        color: #dc2626;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
        padding: 13px 14px;
        border: 1px solid #e5ddd2;
        border-radius: 10px;
        background: #fff;
        color: #2d251e;
        font: inherit;
        font-size: 14px;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .form-control:focus {
        border-color: #c9974d;
        box-shadow: 0 0 0 3px rgba(201, 151, 77, .13);
    }

    textarea.form-control {
        min-height: 140px;
        resize: vertical;
        line-height: 1.6;
    }

    .rating-options {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 7px;
    }

    .rating-options input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .rating-options label {
        color: #d6d3d1;
        font-size: 38px;
        cursor: pointer;
        transition: color .15s, transform .15s;
        line-height: 1;
    }

    .rating-options label:hover,
    .rating-options label:hover ~ label,
    .rating-options input:checked ~ label {
        color: #f5ad24;
    }

    .rating-options label:hover {
        transform: scale(1.08);
    }

    .rating-hint {
        font-size: 12px;
        color: #9a8e82;
        margin-top: 9px;
    }

    .aspect-options {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .aspect-option {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #faf7f2;
        border: 1px solid #eee5d9;
        border-radius: 30px;
        padding: 9px 13px;
        font-size: 13px;
        cursor: pointer;
        transition: .2s;
    }

    .aspect-option:has(input:checked) {
        background: #fff3dc;
        border-color: #c9974d;
        color: #8a5c1f;
    }

    .aspect-option input {
        accent-color: #c9974d;
    }

    .file-note {
        color: #968a7e;
        font-size: 12px;
        margin-top: 8px;
    }

    .feedback-submit {
        width: 100%;
        border: 0;
        border-radius: 11px;
        background: linear-gradient(135deg, #d5a456, #b77d2d);
        color: #fff;
        padding: 15px 20px;
        font-size: 15px;
        font-weight: 800;
        cursor: pointer;
        transition: transform .2s, box-shadow .2s;
    }

    .feedback-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 18px rgba(183, 125, 45, .22);
    }

    .feedback-alert {
        padding: 14px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .feedback-alert.success {
        background: #eaf8ef;
        color: #216e39;
        border: 1px solid #c8ead2;
    }

    .feedback-alert.error {
        background: #fff0f0;
        color: #a12626;
        border: 1px solid #f2caca;
    }

    .feedback-empty {
        background: #fff;
        text-align: center;
        border: 1px dashed #e3d6c5;
        border-radius: 16px;
        padding: 35px 20px;
        color: #83776c;
    }

    .feedback-empty .empty-icon {
        font-size: 42px;
        margin-bottom: 10px;
    }

    @media (max-width: 600px) {
        .feedback-page {
            padding: 20px 12px 35px;
        }

        .feedback-card {
            padding: 22px 17px;
        }

        .rating-options label {
            font-size: 33px;
        }
    }
</style>
@endsection

@section('content')
<div class="feedback-page">

    <div class="feedback-header">
        <div class="eyebrow">Your Voice Matters</div>
        <h1>Share Your Experience</h1>
        <p>
            Your feedback helps us improve our food and service.
            Tell us about your recent order.
        </p>
    </div>

    @if(session('success'))
        <div class="feedback-alert success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="feedback-alert error">
            <strong>Please check the following:</strong>
            <ul style="margin:8px 0 0;padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(isset($pendingOrders) && $pendingOrders->isNotEmpty())

        <div class="feedback-card">
            <h2>⭐ Rate Your Order</h2>
            <p class="form-intro">
                Select the completed order you want to review.
                Fields marked with <span class="required">*</span> are required.
            </p>

            <form method="POST"
                  action="{{ route('feedback.store') }}"
                  enctype="multipart/form-data">

                @csrf

                {{-- ORDER ID: REQUIRED BY THE CONTROLLER --}}
                <div class="form-group">
                    <label for="order_id" class="form-label">
                        Select Order <span class="required">*</span>
                    </label>

                    <select name="order_id"
                            id="order_id"
                            class="form-control"
                            required>
                        <option value="">-- Choose a completed order --</option>

                        @foreach($pendingOrders as $order)
                            <option value="{{ $order->id }}"
                                {{ (string) old('order_id') === (string) $order->id ? 'selected' : '' }}>
                                Order #{{ $order->id }}
                                — {{ $order->created_at->format('d M Y') }}
                                — ₹{{ number_format($order->total_amount, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- STAR RATING --}}
                <div class="form-group">
                    <label class="form-label">
                        Rate your experience <span class="required">*</span>
                    </label>

                    <div class="rating-options">
                        @for($star = 5; $star >= 1; $star--)
                            <input type="radio"
                                   id="rating-{{ $star }}"
                                   name="rating"
                                   value="{{ $star }}"
                                   required
                                   {{ (string) old('rating') === (string) $star ? 'checked' : '' }}>

                            <label for="rating-{{ $star }}"
                                   title="{{ $star }} out of 5 stars">
                                ★
                            </label>
                        @endfor
                    </div>

                    <div class="rating-hint">
                        1 = Poor &nbsp; · &nbsp; 5 = Excellent
                    </div>
                </div>

                {{-- REVIEW --}}
                <div class="form-group">
                    <label for="comment" class="form-label">
                        Your Review <span class="required">*</span>
                    </label>

                    <textarea id="comment"
                              name="comment"
                              class="form-control"
                              minlength="3"
                              maxlength="1000"
                              required
                              placeholder="What did you enjoy? How was the food, packaging, and service?">{{ old('comment') }}</textarea>
                </div>

                {{-- OPTIONAL ASPECTS --}}
                <div class="form-group">
                    <label class="form-label">
                        What stood out to you? (Optional)
                    </label>

                    <div class="aspect-options">
                        @foreach([
                            'Food Quality',
                            'Taste',
                            'Packaging',
                            'Portion Size',
                            'Value for Money',
                            'Service'
                        ] as $aspect)
                            <label class="aspect-option">
                                <input type="checkbox"
                                       name="aspects[]"
                                       value="{{ $aspect }}"
                                       {{ in_array($aspect, old('aspects', [])) ? 'checked' : '' }}>
                                {{ $aspect }}
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- OPTIONAL PHOTOS --}}
                <div class="form-group">
                    <label for="images" class="form-label">
                        Add Food Photos (Optional)
                    </label>

                    <input type="file"
                           id="images"
                           name="images[]"
                           class="form-control"
                           accept="image/jpeg,image/png,image/webp"
                           multiple>

                    <div class="file-note">
                        JPG, PNG, or WEBP. Maximum 2 MB per image.
                    </div>
                </div>

                <button type="submit" class="feedback-submit">
                    Submit My Feedback →
                </button>
            </form>
        </div>

    @else

        <div class="feedback-empty">
            <div class="empty-icon">🍽️</div>
            <h2>No Pending Orders to Review</h2>
            <p>
                Once you have a completed order, you can share your experience here.
            </p>

            <a href="{{ route('user.menu') }}"
               style="display:inline-block;margin-top:10px;background:#c9974d;color:#fff;padding:11px 18px;border-radius:9px;text-decoration:none;font-weight:700;">
                Explore Menu
            </a>
        </div>

    @endif

</div>
@endsection
