<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuItemController extends Controller
{
    /**
     * Display all menu items.
     */
    public function index()
    {
        $menuItems = MenuItem::latest()->get();

        return view(
            'admin.menu.index',
            compact('menuItems')
        );
    }

    /**
     * Show create menu item form.
     */
    public function create()
    {
        return view('admin.menu.create');
    }

    /**
     * Store a new menu item.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validate Request
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'category' => [
                'required',
                'string',
                'max:100',
            ],

            'custom_category' => [
                'nullable',
                'string',
                'max:100',
                'required_if:category,Others',
            ],

            'subcategory' => [
                'nullable',
                'string',
                'max:100',
            ],

            'custom_subcategory' => [
                'nullable',
                'string',
                'max:100',
                'required_if:subcategory,Others',
            ],

            'available' => [
                'required',
                'boolean',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Save Custom Category
        |--------------------------------------------------------------------------
        */

        if ($request->category === 'Others') {
            $validated['category'] = trim(
                $request->custom_category
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Save Custom Subcategory
        |--------------------------------------------------------------------------
        */

        if ($request->subcategory === 'Others') {
            $validated['subcategory'] = trim(
                $request->custom_subcategory
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Remove Temporary Custom Fields
        |--------------------------------------------------------------------------
        */

        unset(
            $validated['custom_category'],
            $validated['custom_subcategory']
        );

        /*
        |--------------------------------------------------------------------------
        | Upload Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('menu', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Create Menu Item
        |--------------------------------------------------------------------------
        */

        MenuItem::create($validated);

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.menu')
            ->with(
                'success',
                'Menu item added successfully!'
            );
    }

    /**
     * Show edit menu item form.
     */
    public function edit($id)
    {
        $menuItem = MenuItem::findOrFail($id);

        return view(
            'admin.menu.edit',
            compact('menuItem')
        );
    }

    /**
     * Update menu item.
     */
    public function update(Request $request, $id)
    {
        $menuItem = MenuItem::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Validate Request
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'category' => [
                'required',
                'string',
                'max:100',
            ],

            'custom_category' => [
                'nullable',
                'string',
                'max:100',
                'required_if:category,Others',
            ],

            'subcategory' => [
                'nullable',
                'string',
                'max:100',
            ],

            'custom_subcategory' => [
                'nullable',
                'string',
                'max:100',
                'required_if:subcategory,Others',
            ],

            'available' => [
                'required',
                'boolean',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Save Custom Category
        |--------------------------------------------------------------------------
        */

        if ($request->category === 'Others') {
            $validated['category'] = trim(
                $request->custom_category
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Save Custom Subcategory
        |--------------------------------------------------------------------------
        */

        if ($request->subcategory === 'Others') {
            $validated['subcategory'] = trim(
                $request->custom_subcategory
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Remove Temporary Custom Fields
        |--------------------------------------------------------------------------
        */

        unset(
            $validated['custom_category'],
            $validated['custom_subcategory']
        );

        /*
        |--------------------------------------------------------------------------
        | Replace Image Safely
        |--------------------------------------------------------------------------
        */

        $oldImage = $menuItem->image;

        if ($request->hasFile('image')) {
            // Store the new image first.
            $newImage = $request
                ->file('image')
                ->store('menu', 'public');

            // Update the database with the new image path.
            $validated['image'] = $newImage;
        }

        /*
        |--------------------------------------------------------------------------
        | Update Menu Item
        |--------------------------------------------------------------------------
        */

        $menuItem->update($validated);

        /*
        |--------------------------------------------------------------------------
        | Delete Old Image After Successful Update
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile('image') &&
            $oldImage
        ) {
            Storage::disk('public')->delete($oldImage);
        }

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.menu')
            ->with(
                'success',
                'Menu item updated successfully!'
            );
    }

    /**
     * Delete menu item.
     */
    public function destroy($id)
    {
        $menuItem = MenuItem::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Delete Image
        |--------------------------------------------------------------------------
        */

        if ($menuItem->image) {
            Storage::disk('public')
                ->delete($menuItem->image);
        }

        /*
        |--------------------------------------------------------------------------
        | Delete Menu Item
        |--------------------------------------------------------------------------
        */

        $menuItem->delete();

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.menu')
            ->with(
                'success',
                'Menu item deleted successfully!'
            );
    }
}
