<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;

class CartController extends Controller
{
    /**
     * Add a product to the cart.
     */
    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $user = $request->user(); // Assuming authentication is enabled

        // Retrieve or create a cart for the authenticated user
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        // Check if the product already exists in the cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($cartItem) {
            // Increase the quantity if the item is already in the cart
            $cartItem->quantity += $validated['quantity'];
            $cartItem->save();
        } else {
            // Otherwise, create a new cart item
            $cartItem = CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $validated['product_id'],
                'quantity'   => $validated['quantity']
            ]);
        }

        return response()->json([
            'message'   => 'Product added to cart',
            'cart_item' => $cartItem
        ], 201);
    }

    /**
     * List all items in the current user's cart.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $cart = Cart::where('user_id', $user->id)
                    ->with('cartItems.product')
                    ->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart is empty'], 200);
        }
        return response()->json($cart, 200);
    }
}
