<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;

class OrderController extends Controller
{
    /**
     * Checkout the current cart and create an order.
     */
    public function checkout(Request $request)
    {
        $user = $request->user();
        $cart = Cart::where('user_id', $user->id)
                    ->with('cartItems.product')
                    ->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        DB::beginTransaction();
        try {
            $order = new Order();
            $order->user_id = $user->id;
            $order->order_status = 'pending';
            $order->total_price = 0;
            $order->save();

            foreach ($cart->cartItems as $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item->product_id;
                $orderItem->quantity = $item->quantity;
                $orderItem->price = $item->product->price;
                $orderItem->save();

                $order->total_price += $item->quantity * $item->product->price;
            }
            $order->save();

            // Clear the cart items after a successful checkout
            CartItem::where('cart_id', $cart->id)->delete();

            DB::commit();
            return response()->json([
                'message' => 'Order placed successfully',
                'order'   => $order
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Checkout failed',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * List all orders for the current user.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $orders = Order::where('user_id', $user->id)
                       ->with('orderItems.product')
                       ->get();
        return response()->json($orders, 200);
    }
}
