@extends('layouts.admin')

@section('title', 'Add Menu Item')
@section('page-title', 'Add Menu Item')

@section('styles')
<style>
    /* =========================================================
       ADD MENU ITEM
    ========================================================= */

    .menu-create-page {
        max-width: 1100px;
        margin: 0 auto;
    }

    .page-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .page-heading-content h1 {
        margin: 0 0 6px;
        font-size: 26px;
        font-weight: 800;
        color: #111827;
    }

    .page-heading-content p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 9px;
        background: #ffffff;
        color: #374151;
        border: 1px solid #e5e7eb;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: 0.2s ease;
        white-space: nowrap;
    }

    .back-btn:hover {
        background: #f9fafb;
        border-color: #d1d5db;
        color: #111827;
        transform: translateY(-1px);
    }

    .menu-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 6px 24px rgba(15, 23, 42, 0.06);
    }

    .menu-card-header {
        padding: 24px 28px;
        background: linear-gradient(135deg, #ff6b35, #f4511e);
        color: #ffffff;
    }

    .menu-card-header-inner {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .header-icon {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.18);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
    }

    .menu-card-header h2 {
        margin: 0 0 4px;
        font-size: 20px;
        font-weight: 750;
    }

    .menu-card-header p {
        margin: 0;
        font-size: 13px;
        opacity: 0.9;
    }

    .form-container {
        padding: 30px;
    }

    /* =========================================================
       VALIDATION
    ========================================================= */

    .general-errors {
        margin-bottom: 24px;
        padding: 15px 17px;
        border-radius: 10px;
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

    .error-message {
        margin-top: 7px;
        color: #dc2626;
        font-size: 13px;
    }

    /* =========================================================
       FORM
    ========================================================= */

    .form-section {
        margin-bottom: 28px;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 18px;
        padding-bottom: 11px;
        border-bottom: 1px solid #f0f0f0;
        color: #111827;
        font-size: 16px;
        font-weight: 750;
    }

    .section-title i {
        color: #ff6b35;
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
        font-size: 13px;
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
        border-radius: 9px;
        background: #ffffff;
        color: #1f2937;
        font-family: inherit;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s ease,
                    box-shadow 0.2s ease,
                    background 0.2s ease;
    }

    input::placeholder,
    textarea::placeholder {
        color: #9ca3af;
    }

    input:focus,
    textarea:focus,
    select:focus {
        border-color: #ff6b35;
        box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.11);
    }

    textarea {
        min-height: 125px;
        resize: vertical;
        line-height: 1.6;
    }

    select {
        cursor: pointer;
    }

    .row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    /* =========================================================
       PRICE
    ========================================================= */

    .price-wrapper {
        position: relative;
    }

    .price-symbol {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        font-size: 14px;
        font-weight: 700;
        pointer-events: none;
    }

    .price-input {
        padding-left: 34px;
    }

    /* =========================================================
       CUSTOM CATEGORY / SUBCATEGORY
    ========================================================= */

    .custom-field {
        display: none;
        margin-top: 10px;
        padding: 14px;
        border: 1px solid #fed7c7;
        border-radius: 10px;
        background: #fff8f5;
    }

    .custom-field.show {
        display: block;
    }

    .custom-field label {
        margin-bottom: 7px;
    }

    .custom-help,
    .subcategory-help {
        margin-top: 7px;
        color: #9ca3af;
        font-size: 12px;
        line-height: 1.5;
    }

    /* =========================================================
       IMAGE UPLOAD
    ========================================================= */

    .image-section {
        margin-bottom: 30px;
    }

    .image-upload {
        position: relative;
        min-height: 300px;
        width: 100%;
        overflow: hidden;
        border: 2px dashed #d1d5db;
        border-radius: 14px;
        background: #fafafa;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.25s ease;
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

    .upload-content {
        padding: 30px;
        text-align: center;
    }

    .upload-icon {
        width: 68px;
        height: 68px;
        margin: 0 auto 16px;
        border-radius: 50%;
        background: #fff0ea;
        color: #ff6b35;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .upload-content h3 {
        margin: 0 0 7px;
        color: #374151;
        font-size: 17px;
        font-weight: 700;
    }

    .upload-content p {
        margin: 0 0 16px;
        color: #9ca3af;
        font-size: 13px;
    }

    .browse-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 17px;
        border-radius: 8px;
        background: #ff6b35;
        color: #ffffff;
        font-size: 13px;
        font-weight: 650;
    }

    #image {
        display: none;
    }

    .preview-container {
        display: none;
        position: absolute;
        inset: 0;
        background: #ffffff;
    }

    .preview-container img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .remove-image {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 5;
        width: 38px;
        height: 38px;
        border: none;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.72);
        color: #ffffff;
        font-size: 22px;
        line-height: 1;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .remove-image:hover {
        background: #ef4444;
        transform: scale(1.05);
    }

    .image-hint {
        margin-top: 8px;
        color: #9ca3af;
        font-size: 12px;
    }

    /* =========================================================
       FOOTER / BUTTONS
    ========================================================= */

    .form-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
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
        min-height: 44px;
        padding: 11px 20px;
        border-radius: 9px;
        font-size: 14px;
        font-weight: 650;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .cancel-btn {
        background: #ffffff;
        color: #374151;
        border: 1px solid #d1d5db;
    }

    .cancel-btn:hover {
        background: #f9fafb;
        border-color: #9ca3af;
    }

    .submit-btn {
        border: none;
        background: #ff6b35;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(255, 107, 53, 0.22);
    }

    .submit-btn:hover {
        background: #e85a25;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(255, 107, 53, 0.28);
    }

    /* =========================================================
       MOBILE
    ========================================================= */

    @media (max-width: 768px) {
        .page-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .back-btn {
            width: 100%;
            justify-content: center;
        }

        .form-container {
            padding: 22px 18px;
        }

        .menu-card-header {
            padding: 20px 18px;
        }

        .row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .image-upload {
            min-height: 240px;
        }

        .form-footer {
            flex-direction: column-reverse;
        }

        .cancel-btn,
        .submit-btn {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .page-heading-content h1 {
            font-size: 22px;
        }

        .header-icon {
            width: 42px;
            height: 42px;
        }

        .menu-card-header h2 {
            font-size: 18px;
        }

        .upload-content {
            padding: 20px;
        }
    }
</style>
@endsection

@section('content')

<div class="menu-create-page">

    {{-- PAGE HEADING --}}
    <div class="page-heading">

        <div class="page-heading-content">
            <h1>Add Menu Item</h1>
            <p>Create a new food or beverage item for your restaurant menu.</p>
        </div>

        <a href="{{ route('admin.menu') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Menu
        </a>

    </div>

    <div class="menu-card">

        {{-- CARD HEADER --}}
        <div class="menu-card-header">
            <div class="menu-card-header-inner">

                <div class="header-icon">
                    <i class="fa-solid fa-utensils"></i>
                </div>

                <div>
                    <h2>New Menu Item</h2>
                    <p>Add details, pricing, category and a beautiful food image.</p>
                </div>

            </div>
        </div>

        <div class="form-container">

            {{-- VALIDATION ERRORS --}}
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
                action="{{ route('admin.menu.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

                {{-- =====================================================
                     IMAGE
                ====================================================== --}}
                <div class="form-section image-section">

                    <div class="section-title">
                        <i class="fa-solid fa-image"></i>
                        Food Image
                    </div>

                    <div
                        class="image-upload"
                        id="imageUpload"
                    >

                        <div
                            class="upload-content"
                            id="uploadContent"
                        >
                            <div class="upload-icon">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>

                            <h3>Upload Food Image</h3>

                            <p>
                                Drag & drop an image here or choose one from your computer.
                            </p>

                            <span class="browse-btn">
                                <i class="fa-solid fa-folder-open"></i>
                                Choose Image
                            </span>
                        </div>

                        <div
                            class="preview-container"
                            id="previewContainer"
                        >
                            <img
                                id="imagePreview"
                                src=""
                                alt="Food Preview"
                            >

                            <button
                                type="button"
                                class="remove-image"
                                id="removeImageBtn"
                                aria-label="Remove image"
                            >
                                ×
                            </button>
                        </div>

                    </div>

                    <div class="image-hint">
                        Recommended: JPG, JPEG, PNG or WEBP • Maximum 2MB
                    </div>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept="image/png,image/jpeg,image/jpg,image/webp"
                    >

                    @error('image')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- =====================================================
                     BASIC INFORMATION
                ====================================================== --}}
                <div class="form-section">

                    <div class="section-title">
                        <i class="fa-solid fa-circle-info"></i>
                        Basic Information
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
                            value="{{ old('name') }}"
                            placeholder="e.g. Chicken Biryani"
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
                            placeholder="Describe your delicious dish..."
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

                {{-- =====================================================
                     PRICE + CATEGORY
                ====================================================== --}}
                <div class="form-section">

                    <div class="section-title">
                        <i class="fa-solid fa-tags"></i>
                        Pricing & Category
                    </div>

                    <div class="row">

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
                                    value="{{ old('price') }}"
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
                                    {{ old('category') == 'Food' ? 'selected' : '' }}
                                >
                                    Food
                                </option>

                                <option
                                    value="Beverages"
                                    {{ old('category') == 'Beverages' ? 'selected' : '' }}
                                >
                                    Beverages
                                </option>

                                <option
                                    value="Desserts"
                                    {{ old('category') == 'Desserts' ? 'selected' : '' }}
                                >
                                    Desserts
                                </option>

                                <option
                                    value="Other"
                                    {{ old('category') == 'Other' ? 'selected' : '' }}
                                >
                                    Other
                                </option>

                                <option
                                    value="Others"
                                    {{ old('category') == 'Others' ? 'selected' : '' }}
                                >
                                    Others — Custom
                                </option>

                            </select>

                            {{-- CUSTOM CATEGORY --}}
                            <div
                                id="customCategoryWrapper"
                                class="custom-field"
                            >
                                <label for="custom_category">
                                    Enter Custom Category
                                    <span class="required">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="custom_category"
                                    name="custom_category"
                                    value="{{ old('custom_category') }}"
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

                {{-- =====================================================
                     SUBCATEGORY
                ====================================================== --}}
                <div class="form-section">

                    <div class="section-title">
                        <i class="fa-solid fa-list"></i>
                        Subcategory
                    </div>

                    <div class="form-group">

                        <label for="subcategory">
                            Subcategory
                        </label>

                        <select
                            id="subcategory"
                            name="subcategory"
                        >
                            <option value="">
                                Select Category First
                            </option>
                        </select>

                        {{-- CUSTOM SUBCATEGORY --}}
                        <div
                            id="customSubcategoryWrapper"
                            class="custom-field"
                        >
                            <label for="custom_subcategory">
                                Enter Custom Subcategory
                                <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                id="custom_subcategory"
                                name="custom_subcategory"
                                value="{{ old('custom_subcategory') }}"
                                placeholder="e.g. Chef's Special Fish"
                            >

                            <div class="custom-help">
                                Enter your own subcategory name.
                            </div>
                        </div>

                        <div class="subcategory-help">
                            Select a category to see available subcategories.
                            Choose <strong>Others</strong> if you want to enter your own subcategory.
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

                {{-- =====================================================
                     AVAILABILITY
                ====================================================== --}}
                <div class="form-section">

                    <div class="section-title">
                        <i class="fa-solid fa-toggle-on"></i>
                        Availability
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
                                {{ old('available', '1') == '1' ? 'selected' : '' }}
                            >
                                ✓ Available
                            </option>

                            <option
                                value="0"
                                {{ old('available') == '0' ? 'selected' : '' }}
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

                {{-- =====================================================
                     BUTTONS
                ====================================================== --}}
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
                        <i class="fa-solid fa-plus"></i>
                        Add Food
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
    /* =========================================================
       SUBCATEGORY DATA
    ========================================================= */

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
        ],

        Others: [
            "Others"
        ]
    };


    /* =========================================================
       ELEMENTS
    ========================================================= */

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

    const oldSubcategory =
        @json(old('subcategory'));


    /* =========================================================
       CUSTOM CATEGORY
    ========================================================= */

    function updateCustomCategory() {

        if (categorySelect.value === 'Others') {

            customCategoryWrapper.classList.add('show');

            customCategoryInput.required = true;

        } else {

            customCategoryWrapper.classList.remove('show');

            customCategoryInput.required = false;
        }
    }


    /* =========================================================
       CUSTOM SUBCATEGORY
    ========================================================= */

    function updateCustomSubcategory() {

        if (subcategorySelect.value === 'Others') {

            customSubcategoryWrapper.classList.add('show');

            customSubcategoryInput.required = true;

        } else {

            customSubcategoryWrapper.classList.remove('show');

            customSubcategoryInput.required = false;
        }
    }


    /* =========================================================
       CATEGORY → SUBCATEGORY
    ========================================================= */

    function updateSubcategories() {

        const category = categorySelect.value;

        const currentSubcategory =
            oldSubcategory ||
            subcategorySelect.dataset.current ||
            '';

        subcategorySelect.innerHTML = '';

        /* ---------------------------------------------
           NO CATEGORY
        --------------------------------------------- */

        if (!category || !subcategories[category]) {

            const option =
                document.createElement('option');

            option.value = '';

            option.textContent =
                'Select Category First';

            subcategorySelect.appendChild(option);

            subcategorySelect.disabled = true;

            customSubcategoryWrapper.classList.remove('show');

            customSubcategoryInput.required = false;

            return;
        }


        /* ---------------------------------------------
           DEFAULT OPTION
        --------------------------------------------- */

        const firstOption =
            document.createElement('option');

        firstOption.value = '';

        firstOption.textContent =
            'Select Subcategory';

        subcategorySelect.appendChild(firstOption);


        /* ---------------------------------------------
           ADD SUBCATEGORIES
        --------------------------------------------- */

        subcategories[category].forEach(function(subcategory) {

            const option =
                document.createElement('option');

            option.value = subcategory;

            option.textContent = subcategory;

            if (subcategory === currentSubcategory) {

                option.selected = true;
            }

            subcategorySelect.appendChild(option);
        });


        subcategorySelect.disabled = false;

        updateCustomSubcategory();
    }


    /* =========================================================
       CATEGORY CHANGE
    ========================================================= */

    categorySelect.addEventListener(
        'change',
        function() {

            subcategorySelect.dataset.current = '';

            updateCustomCategory();

            updateSubcategories();
        }
    );


    /* =========================================================
       SUBCATEGORY CHANGE
    ========================================================= */

    subcategorySelect.addEventListener(
        'change',
        function() {

            updateCustomSubcategory();
        }
    );


    /* =========================================================
       INITIAL LOAD
    ========================================================= */

    updateCustomCategory();

    updateSubcategories();


    /* =========================================================
       IMAGE PREVIEW
    ========================================================= */

    const imageUpload =
        document.getElementById('imageUpload');

    const imageInput =
        document.getElementById('image');

    const imagePreview =
        document.getElementById('imagePreview');

    const previewContainer =
        document.getElementById('previewContainer');

    const uploadContent =
        document.getElementById('uploadContent');

    const removeImageBtn =
        document.getElementById('removeImageBtn');


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

            previewContainer.style.display =
                'block';

            uploadContent.style.display =
                'none';
        };


        reader.readAsDataURL(file);
    }


    /* =========================================================
       OPEN FILE SELECTOR
    ========================================================= */

    imageUpload.addEventListener(
        'click',
        function() {

            imageInput.click();
        }
    );


    imageInput.addEventListener(
        'change',
        function() {

            previewImage(this);
        }
    );


    /* =========================================================
       REMOVE IMAGE
    ========================================================= */

    removeImageBtn.addEventListener(
        'click',
        function(event) {

            event.stopPropagation();

            imageInput.value = '';

            imagePreview.src = '';

            previewContainer.style.display =
                'none';

            uploadContent.style.display =
                'block';
        }
    );


    /* =========================================================
       DRAG & DROP
    ========================================================= */

    imageUpload.addEventListener(
        'dragover',
        function(e) {

            e.preventDefault();

            imageUpload.classList.add(
                'dragover'
            );
        }
    );


    imageUpload.addEventListener(
        'dragleave',
        function() {

            imageUpload.classList.remove(
                'dragover'
            );
        }
    );


    imageUpload.addEventListener(
        'drop',
        function(e) {

            e.preventDefault();

            imageUpload.classList.remove(
                'dragover'
            );


            const files =
                e.dataTransfer.files;


            if (files.length > 0) {

                imageInput.files =
                    files;

                previewImage(
                    imageInput
                );
            }
        }
    );
</script>
@endsection
