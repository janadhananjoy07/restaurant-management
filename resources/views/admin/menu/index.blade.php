@extends('layouts.admin')

@section('title', 'Menu Management')
@section('page-title', 'Menu Management')

@section('styles')

<style>
    .menu-page {
        max-width: 1400px;
        margin: 0 auto;
    }

    .page-intro {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .page-intro-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .page-icon {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        background: rgba(245, 158, 11, 0.10);
        border: 1px solid rgba(245, 158, 11, 0.18);
        color: #f59e0b;
        font-size: 20px;
        flex-shrink: 0;
    }

    .page-intro h2 {
        margin: 0;
        color: #fff;
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .page-intro p {
        margin: 5px 0 0;
        color: #78716c;
        font-size: 13px;
    }

    .add-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 18px;
        border-radius: 12px;
        background: #f59e0b;
        color: #1c1917;
        text-decoration: none;
        font-size: 13px;
        font-weight: 800;
        border: 1px solid #f59e0b;
        transition: all .2s ease;
        white-space: nowrap;
    }

    .add-button:hover {
        background: #fbbf24;
        color: #1c1917;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(245, 158, 11, .18);
    }

    .add-button:active {
        transform: translateY(0);
    }

    .menu-card {
        background: #1c1917;
        border: 1px solid #292524;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, .45);
    }

    .card-header {
        padding: 22px 24px;
        border-bottom: 1px solid #292524;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .card-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .card-title-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: rgba(245, 158, 11, .08);
        border: 1px solid rgba(245, 158, 11, .14);
        color: #f59e0b;
    }

    .card-title h3 {
        margin: 0;
        color: #fff;
        font-size: 16px;
        font-weight: 800;
    }

    .card-title p {
        margin: 4px 0 0;
        color: #78716c;
        font-size: 12px;
    }

    .filter-section {
        padding: 20px 24px;
        background: rgba(12, 10, 9, .35);
        border-bottom: 1px solid #292524;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: minmax(220px, 1fr) 190px 210px 170px auto;
        gap: 12px;
        align-items: end;
    }

    .filter-group label {
        display: block;
        margin-bottom: 7px;
        color: #78716c;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #78716c;
        font-size: 13px;
        pointer-events: none;
    }

    .filter-input,
    .filter-select {
        width: 100%;
        min-height: 42px;
        padding: 10px 12px;
        background: #292524;
        border: 1px solid #44403c;
        border-radius: 11px;
        color: #f5f5f4;
        font-size: 13px;
        outline: none;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .filter-input {
        padding-left: 38px;
    }

    .filter-input::placeholder {
        color: #78716c;
    }

    .filter-input:focus,
    .filter-select:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, .08);
    }

    .filter-select option {
        background: #1c1917;
        color: #fff;
    }

    .clear-filter {
        min-height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 10px 15px;
        border-radius: 11px;
        background: #292524;
        border: 1px solid #44403c;
        color: #a8a29e;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all .2s ease;
    }

    .clear-filter:hover {
        background: #3f3a36;
        color: #fff;
    }

    .filter-summary {
        margin-top: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .filter-count {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 999px;
        background: rgba(245, 158, 11, .08);
        border: 1px solid rgba(245, 158, 11, .15);
        color: #fbbf24;
        font-size: 11px;
        font-weight: 700;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .menu-table {
        width: 100%;
        min-width: 1050px;
        border-collapse: collapse;
    }

    .menu-table thead {
        background: #292524;
    }

    .menu-table th {
        padding: 15px 18px;
        color: #a8a29e;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .08em;
        text-align: left;
        white-space: nowrap;
    }

    .menu-table td {
        padding: 17px 18px;
        border-top: 1px solid #292524;
        color: #d6d3d1;
        font-size: 13px;
        vertical-align: middle;
    }

    .menu-row {
        transition: background .2s ease;
    }

    .menu-row:hover {
        background: rgba(245, 158, 11, .035);
    }

    .image-preview,
    .image-placeholder {
        width: 52px;
        height: 52px;
        border-radius: 12px;
    }

    .image-preview {
        display: block;
        object-fit: cover;
        border: 1px solid #44403c;
    }

    .image-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #292524;
        border: 1px solid #44403c;
        color: #78716c;
    }

    .food-name {
        color: #fff;
        font-weight: 700;
        font-size: 13px;
    }

    .item-id {
        margin-top: 4px;
        color: #57534e;
        font-size: 11px;
    }

    .food-category,
    .food-subcategory {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 9px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .food-category {
        color: #fbbf24;
        background: rgba(245, 158, 11, .08);
        border: 1px solid rgba(245, 158, 11, .15);
    }

    .food-subcategory {
        color: #93c5fd;
        background: rgba(96, 165, 250, .08);
        border: 1px solid rgba(96, 165, 250, .15);
    }

    .no-subcategory {
        color: #78716c;
        font-size: 12px;
    }

    .price {
        color: #fbbf24 !important;
        font-weight: 800 !important;
        white-space: nowrap;
    }

    .status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .status::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
    }

    .available {
        color: #34d399;
        background: rgba(16, 185, 129, .08);
        border: 1px solid rgba(16, 185, 129, .15);
    }

    .available::before {
        background: #10b981;
        box-shadow: 0 0 8px rgba(16, 185, 129, .7);
    }

    .unavailable {
        color: #f87171;
        background: rgba(239, 68, 68, .08);
        border: 1px solid rgba(239, 68, 68, .15);
    }

    .unavailable::before {
        background: #ef4444;
    }

    .actions {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .action-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        min-height: 34px;
        padding: 7px 11px;
        border-radius: 9px;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: all .2s ease;
    }

    .action-button:hover {
        transform: translateY(-1px);
    }

    .edit-button {
        background: rgba(59, 130, 246, .10);
        color: #60a5fa;
        border: 1px solid rgba(59, 130, 246, .15);
    }

    .edit-button:hover {
        background: rgba(59, 130, 246, .18);
    }

    .delete-button {
        background: rgba(239, 68, 68, .08);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, .15);
    }

    .delete-button:hover {
        background: rgba(239, 68, 68, .18);
    }

    .alert {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 16px;
        margin-bottom: 18px;
        border-radius: 14px;
        font-size: 13px;
    }

    .success-alert {
        color: #6ee7b7;
        background: rgba(16, 185, 129, .08);
        border: 1px solid rgba(16, 185, 129, .20);
    }

    .error-alert {
        color: #fca5a5;
        background: rgba(239, 68, 68, .08);
        border: 1px solid rgba(239, 68, 68, .20);
    }

    .alert-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        flex-shrink: 0;
    }

    .success-alert .alert-icon {
        background: rgba(16, 185, 129, .12);
        color: #34d399;
    }

    .error-alert .alert-icon {
        background: rgba(239, 68, 68, .12);
        color: #f87171;
    }

    .empty-state {
        padding: 70px 24px;
        text-align: center;
    }

    .empty-icon {
        width: 68px;
        height: 68px;
        margin: 0 auto 17px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 19px;
        background: rgba(245, 158, 11, .08);
        border: 1px solid rgba(245, 158, 11, .12);
        color: #f59e0b;
        font-size: 25px;
    }

    .empty-state h3 {
        margin: 0;
        color: #fff;
        font-size: 17px;
        font-weight: 800;
    }

    .empty-state p {
        max-width: 460px;
        margin: 8px auto 22px;
        color: #78716c;
        font-size: 13px;
        line-height: 1.6;
    }

    .page-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 15px;
        color: #57534e;
        font-size: 11px;
    }

    .page-footer strong {
        color: #a8a29e;
    }

    .legend {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .legend span {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .legend .available-dot {
        color: #10b981;
    }

    .legend .unavailable-dot {
        color: #ef4444;
    }

    .hidden {
        display: none !important;
    }

    @media (max-width: 1100px) {
        .filter-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .filter-grid .search-group {
            grid-column: 1 / -1;
        }
    }

    @media (max-width: 700px) {
        .page-intro {
            align-items: flex-start;
            flex-direction: column;
        }

        .add-button {
            width: 100%;
        }

        .card-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .card-header .add-button {
            width: auto;
        }

        .filter-grid {
            grid-template-columns: 1fr;
        }

        .filter-grid .search-group {
            grid-column: auto;
        }

        .filter-summary,
        .page-footer {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

@endsection

@section('content')

<div class="menu-page">

{{-- FLASH SUCCESS --}}
@if(session('success'))
    <div class="alert success-alert">
        <div class="alert-icon">
            <i class="fa-solid fa-check"></i>
        </div>
        <div>
            {{ session('success') }}
        </div>
    </div>
@endif

{{-- FLASH ERROR --}}
@if(session('error'))
    <div class="alert error-alert">
        <div class="alert-icon">
            <i class="fa-solid fa-circle-exclamation"></i>
        </div>
        <div>
            {{ session('error') }}
        </div>
    </div>
@endif

{{-- VALIDATION ERRORS --}}
@if($errors->any())
    <div class="alert error-alert">
        <div class="alert-icon">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>

        <div>
            <strong>Please fix the following:</strong>

            <ul style="margin: 6px 0 0 18px; padding: 0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

{{-- PAGE INTRO --}}
<div class="page-intro">
    <div class="page-intro-left">
        <div class="page-icon">
            <i class="fa-solid fa-utensils"></i>
        </div>

        <div>
            <h2>Restaurant Menu</h2>
            <p>Manage food items, categories, pricing and availability.</p>
        </div>
    </div>

    <a href="{{ route('admin.menu.create') }}" class="add-button">
        <i class="fa-solid fa-plus"></i>
        Add Food
    </a>
</div>

{{-- MENU CARD --}}
<div class="menu-card">

    {{-- CARD HEADER --}}
    <div class="card-header">
        <div class="card-title">
            <div class="card-title-icon">
                <i class="fa-solid fa-burger"></i>
            </div>

            <div>
                <h3>Menu Items</h3>
                <p>Add, edit, remove and manage your restaurant menu.</p>
            </div>
        </div>

        <span class="filter-count">
            <i class="fa-solid fa-list"></i>
            {{ $menuItems->count() }} Total
        </span>
    </div>

    @if($menuItems->count() > 0)

        {{-- FILTERS --}}
        <div class="filter-section">

            <div class="filter-grid">

                {{-- SEARCH --}}
                <div class="filter-group search-group">
                    <label for="menuSearch">Search Food</label>

                    <div class="input-wrapper">
                        <i class="fa-solid fa-magnifying-glass"></i>

                        <input
                            type="text"
                            id="menuSearch"
                            class="filter-input"
                            placeholder="Search food item..."
                        >
                    </div>
                </div>

                {{-- CATEGORY --}}
                <div class="filter-group">
                    <label for="categoryFilter">Category</label>

                    <select id="categoryFilter" class="filter-select">
                        <option value="">All Categories</option>
                        <option value="food">Food</option>
                        <option value="beverages">Beverages</option>
                        <option value="desserts">Desserts</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                {{-- SUBCATEGORY --}}
                <div class="filter-group">
                    <label for="subcategoryFilter">Subcategory</label>

                    <select id="subcategoryFilter" class="filter-select">
                        <option value="">All Subcategories</option>
                    </select>
                </div>

                {{-- STATUS --}}
                <div class="filter-group">
                    <label for="statusFilter">Status</label>

                    <select id="statusFilter" class="filter-select">
                        <option value="">All Status</option>
                        <option value="available">Available</option>
                        <option value="unavailable">Unavailable</option>
                    </select>
                </div>

                {{-- CLEAR --}}
                <button
                    type="button"
                    id="clearFilters"
                    class="clear-filter"
                >
                    <i class="fa-solid fa-rotate-left"></i>
                    Clear
                </button>

            </div>

            <div class="filter-summary">
                <span class="filter-count">
                    <i class="fa-solid fa-filter"></i>

                    Showing
                    <span id="visibleCount">
                        {{ $menuItems->count() }}
                    </span>
                    item(s)
                </span>
            </div>

        </div>

        {{-- TABLE --}}
        <div class="table-wrapper" id="tableWrapper">
            <table class="menu-table">

                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Food Item</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody id="menuTableBody">

                    @foreach($menuItems as $item)

                        <tr
                            class="menu-row menu-item-row"
                            data-name="{{ strtolower($item->name) }}"
                            data-category="{{ strtolower($item->category ?? '') }}"
                            data-subcategory="{{ strtolower($item->subcategory ?? '') }}"
                            data-status="{{ $item->available ? 'available' : 'unavailable' }}"
                        >

                            {{-- IMAGE --}}
                            <td>
                                @if($item->image)
                                    <img
                                        src="{{ asset('storage/' . $item->image) }}"
                                        alt="{{ $item->name }}"
                                        class="image-preview"
                                    >
                                @else
                                    <div class="image-placeholder">
                                        <i class="fa-solid fa-utensils"></i>
                                    </div>
                                @endif
                            </td>

                            {{-- NAME --}}
                            <td>
                                <div class="food-name">
                                    {{ $item->name }}
                                </div>

                                <div class="item-id">
                                    Menu Item #{{ $item->id }}
                                </div>
                            </td>

                            {{-- CATEGORY --}}
                            <td>
                                @if($item->category)
                                    <span class="food-category">
                                        <i class="fa-solid fa-tag"></i>
                                        {{ $item->category }}
                                    </span>
                                @else
                                    <span class="no-subcategory">
                                        Uncategorized
                                    </span>
                                @endif
                            </td>

                            {{-- SUBCATEGORY --}}
                            <td>
                                @if($item->subcategory)
                                    <span class="food-subcategory">
                                        <i class="fa-solid fa-layer-group"></i>
                                        {{ $item->subcategory }}
                                    </span>
                                @else
                                    <span class="no-subcategory">
                                        No subcategory
                                    </span>
                                @endif
                            </td>

                            {{-- PRICE --}}
                            <td class="price">
                                ₹{{ number_format((float) $item->price, 2) }}
                            </td>

                            {{-- STATUS --}}
                            <td>
                                @if($item->available)
                                    <span class="status available">
                                        Available
                                    </span>
                                @else
                                    <span class="status unavailable">
                                        Unavailable
                                    </span>
                                @endif
                            </td>

                            {{-- ACTIONS --}}
                            <td>
                                <div class="actions">

                                    <a
                                        href="{{ route('admin.menu.edit', $item->id) }}"
                                        class="action-button edit-button"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.menu.delete', $item->id) }}"
                                        method="POST"
                                        style="margin: 0;"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="action-button delete-button"
                                            onclick="return confirm('Are you sure you want to delete this food item?')"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>
        </div>

        {{-- NO FILTER RESULTS --}}
        <div
            id="noFilterResults"
            class="empty-state hidden"
        >
            <div class="empty-icon">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>

            <h3>No matching menu items</h3>

            <p>
                No menu items match your current search or filter settings.
                Try changing the filters.
            </p>

            <button
                type="button"
                id="clearFiltersEmpty"
                class="add-button"
            >
                <i class="fa-solid fa-rotate-left"></i>
                Clear Filters
            </button>
        </div>

    @else

        {{-- EMPTY MENU --}}
        <div class="empty-state">

            <div class="empty-icon">
                <i class="fa-solid fa-utensils"></i>
            </div>

            <h3>No menu items yet</h3>

            <p>
                Start building your restaurant menu by adding your first
                food item.
            </p>

            <a
                href="{{ route('admin.menu.create') }}"
                class="add-button"
            >
                <i class="fa-solid fa-plus"></i>
                Add First Food
            </a>

        </div>

    @endif

</div>

{{-- FOOTER --}}
@if($menuItems->count() > 0)

    <div class="page-footer">

        <div>
            <i class="fa-solid fa-circle-info"></i>
            Total menu items:
            <strong>{{ $menuItems->count() }}</strong>
        </div>

        <div class="legend">
            <span>
                <span class="available-dot">●</span>
                Available
            </span>

            <span>
                <span class="unavailable-dot">●</span>
                Unavailable
            </span>
        </div>

    </div>

@endif


</div>
@endsection

@section('scripts')
@if($menuItems->count() > 0)

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('menuSearch');
    const categoryFilter = document.getElementById('categoryFilter');
    const subcategoryFilter = document.getElementById('subcategoryFilter');
    const statusFilter = document.getElementById('statusFilter');

    const clearButton = document.getElementById('clearFilters');
    const clearEmptyButton = document.getElementById('clearFiltersEmpty');

    const rows = Array.from(document.querySelectorAll('.menu-item-row'));
    const visibleCount = document.getElementById('visibleCount');
    const tableWrapper = document.getElementById('tableWrapper');
    const noFilterResults = document.getElementById('noFilterResults');

    if (!rows.length) return;

    const normalize = value => (value || '').trim().toLowerCase();

    // Build category filters from the actual database results.
    const categories = [...new Set(
        rows.map(row => normalize(row.dataset.category)).filter(Boolean)
    )].sort();

    categories.forEach(category => {
        const option = document.createElement('option');
        option.value = category;
        option.textContent = category.charAt(0).toUpperCase() + category.slice(1);
        categoryFilter.appendChild(option);
    });

    // Build subcategories from real menu items.
    function updateSubcategoryOptions() {
        const selectedCategory = normalize(categoryFilter.value);

        const subcategories = [...new Set(
            rows
                .filter(row => {
                    return !selectedCategory ||
                        normalize(row.dataset.category) === selectedCategory;
                })
                .map(row => normalize(row.dataset.subcategory))
                .filter(Boolean)
        )].sort();

        subcategoryFilter.innerHTML =
            '<option value="">All Subcategories</option>';

        subcategories.forEach(subcategory => {
            const option = document.createElement('option');
            option.value = subcategory;
            option.textContent =
                subcategory.charAt(0).toUpperCase() + subcategory.slice(1);

            subcategoryFilter.appendChild(option);
        });
    }

    function applyFilters() {
        const search = normalize(searchInput.value);
        const category = normalize(categoryFilter.value);
        const subcategory = normalize(subcategoryFilter.value);
        const status = normalize(statusFilter.value);

        let count = 0;

        rows.forEach(row => {
            const name = normalize(row.dataset.name);
            const rowCategory = normalize(row.dataset.category);
            const rowSubcategory = normalize(row.dataset.subcategory);
            const rowStatus = normalize(row.dataset.status);

            const matches =
                (!search || name.includes(search)) &&
                (!category || rowCategory === category) &&
                (!subcategory || rowSubcategory === subcategory) &&
                (!status || rowStatus === status);

            row.style.display = matches ? '' : 'none';

            if (matches) count++;
        });

        visibleCount.textContent = count;

        tableWrapper.classList.toggle('hidden', count === 0);
        noFilterResults.classList.toggle('hidden', count !== 0);
    }

    function resetFilters() {
        searchInput.value = '';
        categoryFilter.value = '';
        statusFilter.value = '';

        updateSubcategoryOptions();
        subcategoryFilter.value = '';

        applyFilters();
    }

    searchInput.addEventListener('input', applyFilters);

    categoryFilter.addEventListener('change', function () {
        updateSubcategoryOptions();
        subcategoryFilter.value = '';
        applyFilters();
    });

    subcategoryFilter.addEventListener('change', applyFilters);
    statusFilter.addEventListener('change', applyFilters);

    clearButton?.addEventListener('click', resetFilters);
    clearEmptyButton?.addEventListener('click', resetFilters);

    updateSubcategoryOptions();
    applyFilters();
});
</script>



@endif
@endsection
