<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;

class CartCheckoutTest extends TestCase
{
    /**
     * Test adding an item to the cart.
     *
     * @return void
     */
    public function testAddItemToCart()
    {
        // Create a user
        $user = User::factory()->create();

        // Act: Authenticate user and generate Sanctum token
        $token = $user->createToken('TestToken')->plainTextToken;

        // Sample data to be added to cart
        $data = [
            'product_id' => 1,
            'quantity' => 2,
        ];

        // Send authenticated POST request to the cart route using token
        $response = $this->postJson(route('cart.add'), $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        // Assert: Check that the cart has been updated
        $response->assertStatus(201); // Assuming successful cart addition returns 200
    }

    /**
     * Test viewing the cart.
     *
     * @return void
     */
    public function testViewCart()
    {
        // Create a user
        $user = User::factory()->create();
        
        // Create a cart for the user
        $cart = Cart::factory()->create(['user_id' => $user->id]);

        // Create a cart item associated with this cart
        CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => Product::factory()->create()->id, // Create product
            'quantity' => 2
        ]);

        // Simulate authentication
        $token = $user->createToken('TestToken')->plainTextToken;

        // Send authenticated GET request to the cart route
        $response = $this->getJson(route('cart.index'), [
            'Authorization' => 'Bearer ' . $token,
        ]);

        // Assert: Check that the response is valid and contains cart items
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'cart_items' => [
                '*' => [
                    'id',
                    'cart_id',
                    'product_id',
                    'quantity',
                ],
            ],
        ]);
    }

    /**
     * Test successful checkout.
     *
     * @return void
     */
    public function testCheckout()
    {
        // Create user, product, and cart items
        $user = User::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        $product = Product::factory()->create();
        CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        // Authenticate user
        $this->actingAs($user);

        // Checkout process
        $response = $this->postJson(route('checkout.process'));

        // Assert the checkout was successful and order was created
        $response->assertStatus(201);
        $response->assertJson(['message' => 'Order placed successfully']);

        // Verify order in the database
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total_price' => $product->price * 2,
        ]);
    }

    /**
     * Test checkout with an empty cart.
     *
     * @return void
     */
    public function testCheckoutWithEmptyCart()
    {
        // Create user
        $user = User::factory()->create();

        // Authenticate user
        $this->actingAs($user);

        // Attempt checkout with an empty cart
        $response = $this->postJson(route('checkout.process'));

        // Assert that an error is returned due to empty cart
        $response->assertStatus(400);
        $response->assertJson(['message' => 'Cart is empty']);
    }


}
