@extends('layouts.admin')

@section('title', 'Edit Menu Item')
@section('page-title', 'Edit Menu Item')

@section('styles')

<style>
    .edit-menu-page {
        max-width: 1050px;
        margin: 0 auto;
    }

    .page-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .page-heading-left h1 {
        margin: 0 0 6px;
        font-size: 28px;
        font-weight: 800;
        color: #111827;
    }

    .page-heading-left p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 16px;
        border-radius: 10px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        color: #374151;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: 0.2s ease;
    }

    .back-link:hover {
        border-color: #ff6b35;
        color: #ff6b35;
        transform: translateY(-1px);
    }

    .edit-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(15, 23, 42, 0.06);
    }

    .card-top {
        padding: 24px 28px;
        background: linear-gradient(135deg, #fff7f3, #ffffff);
        border-bottom: 1px solid #f1f5f9;
    }

    .card-top-content {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .food-icon {
        width: 52px;
        height: 52px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: #fff0ea;
        color: #ff6b35;
        font-size: 21px;
    }

    .card-top h2 {
        margin: 0 0 4px;
        font-size: 19px;
        color: #111827;
    }

    .card-top p {
        margin: 0;
        color: #6b7280;
        font-size: 13px;
    }

    .form-container {
        padding: 30px;
    }

    .general-errors {
        margin-bottom: 24px;
        padding: 15px 17px;
        border-radius: 11px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
        font-size: 14px;
    }

    .general-errors strong {
        display: block;
        margin-bottom: 7px;
    }

    .general-errors ul {
        margin: 0;
        padding-left: 20px;
    }

    .form-section {
        margin-bottom: 30px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid #eef2f7;
    }

    .section-title i {
        color: #ff6b35;
    }

    .section-title h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #374151;
        font-size: 14px;
        font-weight: 650;
    }

    .required {
        color: #ef4444;
    }

    input,
    textarea,
    select {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        background: #ffffff;
        color: #1f2937;
        font-family: inherit;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s ease,
                    box-shadow 0.2s ease,
                    background 0.2s ease;
    }

    input:focus,
    textarea:focus,
    select:focus {
        border-color: #ff6b35;
        box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.11);
    }

    input::placeholder,
    textarea::placeholder {
        color: #9ca3af;
    }

    textarea {
        min-height: 120px;
        resize: vertical;
        line-height: 1.6;
    }

    select:disabled {
        background: #f3f4f6;
        color: #9ca3af;
        cursor: not-allowed;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .price-wrapper {
        position: relative;
    }

    .price-symbol {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        font-weight: 700;
        z-index: 2;
    }

    .price-input {
        padding-left: 34px;
    }

    .error-message {
        margin-top: 6px;
        color: #dc2626;
        font-size: 12px;
    }

    .custom-field {
        display: none;
        margin-top: 10px;
        padding: 13px;
        background: #fff8f5;
        border: 1px solid #fed7c7;
        border-radius: 10px;
    }

    .custom-field.show {
        display: block;
    }

    .custom-field label {
        margin-bottom: 7px;
        font-size: 13px;
    }

    .custom-help,
    .subcategory-help {
        margin-top: 7px;
        color: #9ca3af;
        font-size: 12px;
        line-height: 1.5;
    }

    /* IMAGE */
    .image-section {
        margin-bottom: 30px;
    }

    .image-upload {
        position: relative;
        width: 100%;
        min-height: 300px;
        border: 2px dashed #d1d5db;
        border-radius: 14px;
        background: #fafafa;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.25s ease;
    }

    .image-upload:hover {
        border-color: #ff6b35;
        background: #fff8f5;
    }

    .image-upload.dragover {
        border-color: #ff6b35;
        background: #fff1eb;
        transform: scale(1.005);
    }

    .image-preview {
        position: absolute;
        inset: 0;
        background: #ffffff;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding: 20px;
        background: linear-gradient(
            to top,
            rgba(0, 0, 0, 0.65),
            rgba(0, 0, 0, 0.05)
        );
    }

    .change-image-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 17px;
        border-radius: 9px;
        background: #ffffff;
        color: #374151;
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
    }

    .upload-content {
        padding: 30px;
        text-align: center;
    }

    .upload-icon {
        width: 68px;
        height: 68px;
        margin: 0 auto 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #fff0ea;
        color: #ff6b35;
        font-size: 27px;
    }

    .upload-content h3 {
        margin: 0 0 7px;
        color: #374151;
        font-size: 17px;
    }

    .upload-content p {
        margin: 0 0 15px;
        color: #9ca3af;
        font-size: 13px;
    }

    .browse-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 17px;
        border-radius: 9px;
        background: #ff6b35;
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
    }

    #image {
        display: none;
    }

    .remove-image {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 10;
        width: 38px;
        height: 38px;
        border: 0;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.72);
        color: #ffffff;
        font-size: 21px;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .remove-image:hover {
        background: #ef4444;
    }

    .image-hint {
        margin-top: 8px;
        color: #9ca3af;
        font-size: 12px;
    }

    /* FOOTER */
    .form-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-top: 30px;
        padding-top: 24px;
        border-top: 1px solid #e5e7eb;
    }

    .cancel-btn,
    .submit-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 45px;
        padding: 11px 20px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .cancel-btn {
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        color: #374151;
    }

    .cancel-btn:hover {
        background: #e5e7eb;
        transform: translateY(-1px);
    }

    .submit-btn {
        border: 0;
        background: #ff6b35;
        color: #ffffff;
        box-shadow: 0 5px 14px rgba(255, 107, 53, 0.23);
    }

    .submit-btn:hover {
        background: #e85a25;
        transform: translateY(-1px);
        box-shadow: 0 7px 18px rgba(255, 107, 53, 0.28);
    }

    @media (max-width: 760px) {
        .page-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .form-container {
            padding: 22px;
        }

        .card-top {
            padding: 20px 22px;
        }
    }

    @media (max-width: 560px) {
        .page-heading-left h1 {
            font-size: 23px;
        }

        .back-link {
            width: 100%;
            justify-content: center;
        }

        .image-upload {
            min-height: 230px;
        }

        .form-footer {
            flex-direction: column-reverse;
        }

        .cancel-btn,
        .submit-btn {
            width: 100%;
        }
    }
</style>

@endsection

@section('content')

<div class="edit-menu-page">


{{-- PAGE HEADER --}}
<div class="page-heading">
    <div class="page-heading-left">
        <h1>Edit Menu Item</h1>
        <p>Update the food details, pricing, category and image.</p>
    </div>

    <a href="{{ route('admin.menu') }}" class="back-link">
        <i class="fa-solid fa-arrow-left"></i>
        Back to Menu
    </a>
</div>

<div class="edit-card">

    {{-- CARD HEADER --}}
    <div class="card-top">
        <div class="card-top-content">
            <div class="food-icon">
                <i class="fa-solid fa-utensils"></i>
            </div>

            <div>
                <h2>
                    {{ $menuItem->name }}
                </h2>

                <p>
                    Make changes to this menu item and save the updated information.
                </p>
            </div>
        </div>
    </div>

    <div class="form-container">

        {{-- ERRORS --}}
        @if ($errors->any())
            <div class="general-errors">
                <strong>
                    <i class="fa-solid fa-circle-exclamation"></i>
                    Please fix the following errors:
                </strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('admin.menu.update', $menuItem->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            {{-- FOOD IMAGE --}}
            <div class="form-section image-section">

                <div class="section-title">
                    <i class="fa-solid fa-image"></i>
                    <h3>Food Image</h3>
                </div>

                <div
                    class="image-upload"
                    id="imageUpload"
                    onclick="openFilePicker()"
                >

                    {{-- CURRENT / PREVIEW IMAGE --}}
                    <div
                        class="image-preview"
                        id="currentImage"
                        style="{{ $menuItem->image ? '' : 'display:none;' }}"
                    >
                        <img
                            id="imagePreview"
                            src="{{ $menuItem->image ? asset('storage/' . $menuItem->image) : '' }}"
                            alt="{{ $menuItem->name }}"
                            onerror="showUploadBox()"
                        >

                        <div
                            class="image-overlay"
                            id="imageOverlay"
                        >
                            <span class="change-image-btn">
                                <i class="fa-solid fa-camera"></i>
                                Change Food Image
                            </span>
                        </div>
                    </div>

                    {{-- UPLOAD BOX --}}
                    <div
                        class="upload-content"
                        id="uploadContent"
                        style="{{ $menuItem->image ? 'display:none;' : '' }}"
                    >
                        <div class="upload-icon">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                        </div>

                        <h3>Upload Food Image</h3>

                        <p>
                            Add a clear and attractive photo of your dish
                        </p>

                        <span class="browse-btn">
                            <i class="fa-solid fa-folder-open"></i>
                            Choose Image
                        </span>
                    </div>

                    <button
                        type="button"
                        class="remove-image"
                        id="removeImage"
                        onclick="removeImage(event)"
                        style="display:none;"
                        aria-label="Remove selected image"
                    >
                        ×
                    </button>

                </div>

                <div class="image-hint">
                    JPG, JPEG, PNG or WEBP • Maximum 2MB
                </div>

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept="image/png,image/jpeg,image/jpg,image/webp"
                    onchange="previewImage(this)"
                >

                @error('image')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            {{-- BASIC INFORMATION --}}
            <div class="form-section">

                <div class="section-title">
                    <i class="fa-solid fa-circle-info"></i>
                    <h3>Basic Information</h3>
                </div>

                {{-- FOOD NAME --}}
                <div class="form-group">

                    <label for="name">
                        Food Name
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $menuItem->name) }}"
                        placeholder="Enter food name"
                        required
                    >

                    @error('name')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- DESCRIPTION --}}
                <div class="form-group">

                    <label for="description">
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        placeholder="Enter a short description of the food"
                    >{{ old('description', $menuItem->description) }}</textarea>

                    @error('description')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- PRICE + CATEGORY --}}
                <div class="form-row">

                    {{-- PRICE --}}
                    <div class="form-group">

                        <label for="price">
                            Price
                            <span class="required">*</span>
                        </label>

                        <div class="price-wrapper">

                            <span class="price-symbol">₹</span>

                            <input
                                type="number"
                                id="price"
                                name="price"
                                class="price-input"
                                step="0.01"
                                min="0"
                                value="{{ old('price', $menuItem->price) }}"
                                placeholder="0.00"
                                required
                            >

                        </div>

                        @error('price')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- CATEGORY --}}
                    <div class="form-group">

                        @php
                            $currentCategory = old('category', $menuItem->category);

                            $standardCategories = [
                                'Food',
                                'Beverages',
                                'Desserts',
                                'Others',
                                            ];

                            $isCustomCategory =
                                $currentCategory &&
                                !in_array($currentCategory, $standardCategories);

                            $customCategoryValue =
                                $isCustomCategory
                                    ? $currentCategory
                                    : old('custom_category', '');
                        @endphp

                        <label for="category">
                            Category
                            <span class="required">*</span>
                        </label>

                        <select
                            id="category"
                            name="category"
                            required
                        >
                            <option value="">
                                Select Category
                            </option>

                            <option
                                value="Food"
                                {{ $currentCategory === 'Food' ? 'selected' : '' }}
                            >
                                Food
                            </option>

                            <option
                                value="Beverages"
                                {{ $currentCategory === 'Beverages' ? 'selected' : '' }}
                            >
                                Beverages
                            </option>

                            <option
                                value="Desserts"
                                {{ $currentCategory === 'Desserts' ? 'selected' : '' }}
                            >
                                Desserts
                            </option>

                            <option
                                value="Others"
                                {{ $isCustomCategory || $currentCategory === 'Others' ? 'selected' : '' }}
                            >
                                Others
                            </option>
                        </select>

                        {{-- CUSTOM CATEGORY --}}
                        <div
                            id="customCategoryWrapper"
                            class="custom-field {{ $isCustomCategory || $currentCategory === 'Others' ? 'show' : '' }}"
                        >
                            <label for="custom_category">
                                Enter Custom Category
                                <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                id="custom_category"
                                name="custom_category"
                                value="{{ $customCategoryValue }}"
                                placeholder="e.g. Bengali Special"
                            >

                            <div class="custom-help">
                                Enter your own category name.
                            </div>
                        </div>

                        @error('category')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror

                        @error('custom_category')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

            </div>

            {{-- SUBCATEGORY --}}
            <div class="form-section">

                <div class="section-title">
                    <i class="fa-solid fa-layer-group"></i>
                    <h3>Food Classification</h3>
                </div>

                @php
                    $currentSubcategory = old(
                        'subcategory',
                        $menuItem->subcategory
                    );

                    $standardSubcategories = [
                        'Starters',
                        'Soups',
                        'Salads',
                        'Snacks',
                        'Street Food',
                        'Fast Food',
                        'Pizza',
                        'Burger',
                        'Sandwich',
                        'Pasta',
                        'Noodles',
                        'Momos',
                        'Rolls & Wraps',
                        'Biryani',
                        'Rice',
                        'Fried Rice',
                        'Indian Main Course',
                        'Bengali',
                        'North Indian',
                        'South Indian',
                        'Chinese',
                        'Mughlai',
                        'Tandoori',
                        'Seafood',
                        'Chicken',
                        'Mutton',
                        'Egg',
                        'Vegetarian',
                        'Vegan',
                        'Thali',
                        'Kids Menu',
                        'Desserts',
                        'Ice Cream',
                        'Cakes & Pastries',
                        'Cakes',
                        'Pastries',
                        'Brownies',
                        'Pudding',
                        'Gulab Jamun',
                        'Rasgulla',
                        'Rasmalai',
                        'Kulfi',
                        'Fruit Desserts',
                        'Sweets',
                        'Tea',
                        'Coffee',
                        'Cold Coffee',
                        'Milkshake',
                        'Smoothies',
                        'Fresh Juice',
                        'Mocktails',
                        'Soft Drinks',
                        'Lemonade',
                        'Lassi',
                        'Hot Beverages',
                        'Cold Beverages',
                        'Breakfast',
                        'Combo Meals',
                        'Family Pack',
                        'Party Pack',
                        'Special Offers',
                        "Chef's Special",
                        'Seasonal',
                        'Custom',
                        'Others',
                    ];

                    $isCustomSubcategory =
                        $currentSubcategory &&
                        !in_array(
                            $currentSubcategory,
                            $standardSubcategories
                        );

                    $customSubcategoryValue =
                        $isCustomSubcategory
                            ? $currentSubcategory
                            : old('custom_subcategory', '');
                @endphp

                <div class="form-group">

                    <label for="subcategory">
                        Subcategory
                    </label>

                    <select
                        id="subcategory"
                        name="subcategory"
                        data-current="{{ $currentSubcategory }}"
                    >
                        <option value="">
                            Select Category First
                        </option>
                    </select>

                    {{-- CUSTOM SUBCATEGORY --}}
                    <div
                        id="customSubcategoryWrapper"
                        class="custom-field {{ $isCustomSubcategory || $currentSubcategory === 'Others' ? 'show' : '' }}"
                    >
                        <label for="custom_subcategory">
                            Enter Custom Subcategory
                            <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="custom_subcategory"
                            name="custom_subcategory"
                            value="{{ $customSubcategoryValue }}"
                            placeholder="e.g. Chef's Special Fish"
                        >

                        <div class="custom-help">
                            Enter your own subcategory name.
                        </div>
                    </div>

                    <div class="subcategory-help">
                        Select a category to see available food subcategories.
                        Choose <strong>Others</strong> to enter a custom subcategory.
                    </div>

                    @error('subcategory')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror

                    @error('custom_subcategory')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

            {{-- AVAILABILITY --}}
            <div class="form-section">

                <div class="section-title">
                    <i class="fa-solid fa-toggle-on"></i>
                    <h3>Availability</h3>
                </div>

                <div class="form-group">

                    <label for="available">
                        Menu Status
                    </label>

                    <select
                        id="available"
                        name="available"
                    >
                        <option
                            value="1"
                            {{ old('available', $menuItem->available) == 1 ? 'selected' : '' }}
                        >
                            ✓ Available
                        </option>

                        <option
                            value="0"
                            {{ old('available', $menuItem->available) == 0 ? 'selected' : '' }}
                        >
                            ✕ Not Available
                        </option>
                    </select>

                    @error('available')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

            {{-- FOOTER BUTTONS --}}
            <div class="form-footer">

                <a
                    href="{{ route('admin.menu') }}"
                    class="cancel-btn"
                >
                    <i class="fa-solid fa-xmark"></i>
                    Cancel
                </a>

                <button
                    type="submit"
                    class="submit-btn"
                >
                    <i class="fa-solid fa-check"></i>
                    Update Food
                </button>

            </div>

        </form>

    </div>
</div>


</div>

@endsection

@section('scripts')

<script>
    const subcategories = {
        Food: [
            "Starters",
            "Soups",
            "Salads",
            "Snacks",
            "Street Food",
            "Fast Food",
            "Pizza",
            "Burger",
            "Sandwich",
            "Pasta",
            "Noodles",
            "Momos",
            "Rolls & Wraps",
            "Biryani",
            "Rice",
            "Fried Rice",
            "Indian Main Course",
            "Bengali",
            "North Indian",
            "South Indian",
            "Chinese",
            "Mughlai",
            "Tandoori",
            "Seafood",
            "Chicken",
            "Mutton",
            "Egg",
            "Vegetarian",
            "Vegan",
            "Thali",
            "Kids Menu",
            "Desserts",
            "Ice Cream",
            "Cakes & Pastries",
            "Sweets",
            "Others"
        ],

        Beverages: [
            "Tea",
            "Coffee",
            "Cold Coffee",
            "Milkshake",
            "Smoothies",
            "Fresh Juice",
            "Mocktails",
            "Soft Drinks",
            "Lemonade",
            "Lassi",
            "Hot Beverages",
            "Cold Beverages",
            "Others"
        ],

        Desserts: [
            "Ice Cream",
            "Cakes",
            "Pastries",
            "Brownies",
            "Pudding",
            "Gulab Jamun",
            "Rasgulla",
            "Rasmalai",
            "Kulfi",
            "Fruit Desserts",
            "Others"
        ],

        Other: [
            "Breakfast",
            "Combo Meals",
            "Family Pack",
            "Party Pack",
            "Special Offers",
            "Chef's Special",
            "Seasonal",
            "Custom",
            "Others"
        ]
    };

    const categorySelect =
        document.getElementById('category');

    const subcategorySelect =
        document.getElementById('subcategory');

    const customCategoryWrapper =
        document.getElementById('customCategoryWrapper');

    const customCategoryInput =
        document.getElementById('custom_category');

    const customSubcategoryWrapper =
        document.getElementById('customSubcategoryWrapper');

    const customSubcategoryInput =
        document.getElementById('custom_subcategory');

    const currentCategory =
        @json($currentCategory);

    const currentSubcategory =
        @json($currentSubcategory);

    const isCustomSubcategory =
        @json($isCustomSubcategory);

    function updateCustomCategory() {

        if (categorySelect.value === 'Others') {

            customCategoryWrapper.classList.add('show');
            customCategoryInput.required = true;

        } else {

            customCategoryWrapper.classList.remove('show');
            customCategoryInput.required = false;
        }
    }

    function updateCustomSubcategory() {

        if (subcategorySelect.value === 'Others') {

            customSubcategoryWrapper.classList.add('show');
            customSubcategoryInput.required = true;

        } else {

            customSubcategoryWrapper.classList.remove('show');
            customSubcategoryInput.required = false;
        }
    }

    function updateSubcategories(selectedValue = '') {

        const category = categorySelect.value;

        subcategorySelect.innerHTML = '';

        if (category === 'Others') {

            const firstOption =
                document.createElement('option');

            firstOption.value = '';
            firstOption.textContent = 'Select Subcategory';

            subcategorySelect.appendChild(firstOption);

            const othersOption =
                document.createElement('option');

            othersOption.value = 'Others';
            othersOption.textContent = 'Others';

            if (
                selectedValue === 'Others' ||
                isCustomSubcategory
            ) {
                othersOption.selected = true;
            }

            subcategorySelect.appendChild(othersOption);

            subcategorySelect.disabled = false;

            updateCustomSubcategory();

            return;
        }

        if (!category || !subcategories[category]) {

            const option =
                document.createElement('option');

            option.value = '';
            option.textContent = 'Select Category First';

            subcategorySelect.appendChild(option);

            subcategorySelect.disabled = true;

            customSubcategoryWrapper.classList.remove('show');
            customSubcategoryInput.required = false;

            return;
        }

        const firstOption =
            document.createElement('option');

        firstOption.value = '';
        firstOption.textContent = 'Select Subcategory';

        subcategorySelect.appendChild(firstOption);

        subcategories[category].forEach(function(subcategory) {

            const option =
                document.createElement('option');

            option.value = subcategory;
            option.textContent = subcategory;

            if (subcategory === selectedValue) {
                option.selected = true;
            }

            subcategorySelect.appendChild(option);
        });

        if (isCustomSubcategory) {

            const othersOption =
                Array.from(subcategorySelect.options)
                    .find(option => option.value === 'Others');

            if (othersOption) {
                othersOption.selected = true;
            }
        }

        subcategorySelect.disabled = false;

        updateCustomSubcategory();
    }

    categorySelect.addEventListener('change', function() {

        updateCustomCategory();

        updateSubcategories('');
    });

    subcategorySelect.addEventListener('change', function() {

        updateCustomSubcategory();
    });

    updateCustomCategory();

    updateSubcategories(currentSubcategory);


    /* IMAGE UPLOAD */

    const imageUpload =
        document.getElementById('imageUpload');

    const imageInput =
        document.getElementById('image');

    const currentImage =
        document.getElementById('currentImage');

    const uploadContent =
        document.getElementById('uploadContent');

    const imagePreview =
        document.getElementById('imagePreview');

    const removeButton =
        document.getElementById('removeImage');

    const imageOverlay =
        document.getElementById('imageOverlay');

    function openFilePicker() {

        imageInput.click();
    }

    function previewImage(input) {

        const file = input.files[0];

        if (!file) {
            return;
        }

        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (!allowedTypes.includes(file.type)) {

            alert(
                'Please select a JPG, JPEG, PNG or WEBP image.'
            );

            input.value = '';

            return;
        }

        if (file.size > 2 * 1024 * 1024) {

            alert(
                'Image size must be less than 2MB.'
            );

            input.value = '';

            return;
        }

        const reader =
            new FileReader();

        reader.onload = function(e) {

            imagePreview.src =
                e.target.result;

            currentImage.style.display =
                'block';

            uploadContent.style.display =
                'none';

            removeButton.style.display =
                'block';

            imageOverlay.style.display =
                'none';
        };

        reader.readAsDataURL(file);
    }

    function removeImage(event) {

        event.stopPropagation();

        imageInput.value = '';

        removeButton.style.display =
            'none';

        @if ($menuItem->image)

            imagePreview.src =
                "{{ asset('storage/' . $menuItem->image) }}";

            currentImage.style.display =
                'block';

            uploadContent.style.display =
                'none';

            imageOverlay.style.display =
                'flex';

        @else

            imagePreview.src = '';

            currentImage.style.display =
                'none';

            uploadContent.style.display =
                'block';

        @endif
    }

    function showUploadBox() {

        currentImage.style.display =
            'none';

        uploadContent.style.display =
            'block';

        removeButton.style.display =
            'none';
    }

    imageUpload.addEventListener('dragover', function(e) {

        e.preventDefault();

        imageUpload.classList.add('dragover');
    });

    imageUpload.addEventListener('dragleave', function() {

        imageUpload.classList.remove('dragover');
    });

    imageUpload.addEventListener('drop', function(e) {

        e.preventDefault();
        e.stopPropagation();

        imageUpload.classList.remove('dragover');

        const files = e.dataTransfer.files;

        if (files.length > 0) {

            imageInput.files = files;

            previewImage(imageInput);
        }
    });
</script>

@endsection
