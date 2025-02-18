<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;

class CartItemFactory extends Factory
{
    protected $model = CartItem::class;

    public function definition()
    {
        return [
            'cart_id' => Cart::factory(), // Creates a cart
            'product_id' => Product::factory(), // Creates a product
            'quantity' => $this->faker->numberBetween(1, 5),
        ];
    }
}
