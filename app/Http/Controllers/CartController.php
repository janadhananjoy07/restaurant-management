<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with('menuItem')
            ->where('user_id', auth()->id())
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view('user.cart', compact('cartItems', 'total'));
    }

    public function add($id)
    {
        $menuItem = MenuItem::findOrFail($id);

        $cartItem = CartItem::where('user_id', auth()->id())
            ->where('menu_item_id', $id)
            ->first();

        if ($cartItem) {

            $cartItem->increment('quantity');

        } else {

            CartItem::create([
                'user_id' => auth()->id(),
                'menu_item_id' => $menuItem->id,
                'quantity' => 1,
                'price' => $menuItem->price,
            ]);
        }

        return redirect()
            ->route('user.menu')
            ->with('success', $menuItem->name . ' added to cart!');
    }

    public function remove($id)
    {
        CartItem::where('user_id', auth()->id())
            ->where('id', $id)
            ->delete();

        return redirect()->route('user.cart');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        CartItem::where('user_id', auth()->id())
            ->where('id', $id)
            ->update([
                'quantity' => $request->quantity,
            ]);

        return redirect()->route('user.cart');
    }
}