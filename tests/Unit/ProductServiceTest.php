<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

/**
 * Class ProductServiceTest
 *
 * This test suite verifies the functionality of ProductService,
 * ensuring that all CRUD operations work correctly.
 */
class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var ProductService The service instance under test.
     */
    protected $productService;

    /**
     * Set up the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->productService = $this->app->make(ProductService::class);
    }

    /**
     * Test if the listProducts method returns the correct number of products.
     *
     * @return void
     */
    public function testListProductsReturnsData()
    {
        Product::factory()->count(5)->create();

        $products = $this->productService->listProducts();

        $this->assertCount(5, $products);
        $this->assertInstanceOf(Product::class, $products->first());
    }

    /**
     * Test creating a new product successfully.
     *
     * @return void
     */
    public function testCreateProduct()
    {
        $data = [
            'name'           => 'New Product',
            'description'    => 'Product description',
            'price'          => 199.99,
            'stock_quantity' => 50,
        ];

        $product = $this->productService->createProduct($data);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertDatabaseHas('products', ['name' => 'New Product']);
    }

    /**
     * Test creating a product with invalid data throws validation exception.
     *
     * @return void
     */
    public function testCreateProductFailsWithInvalidData()
    {
        $this->expectException(ValidationException::class);

        $invalidData = [
            'name'  => '', // Required field
            'price' => -10, // Invalid price
        ];

        $this->productService->createProduct($invalidData);
    }

    /**
     * Test retrieving a product by ID.
     *
     * @return void
     */
    public function testGetProductById()
    {
        $product = Product::factory()->create();

        $retrievedProduct = $this->productService->getProduct($product->id);

        $this->assertEquals($product->id, $retrievedProduct->id);
        $this->assertEquals($product->name, $retrievedProduct->name);
    }

    /**
     * Test updating a product successfully.
     *
     * @return void
     */
    public function testUpdateProduct()
    {
        $product = Product::factory()->create();

        $updateData = [
            'name'           => 'Updated Product',
            'description'    => 'Updated description',
            'price'          => 250.00,
            'stock_quantity' => 30,
        ];

        $updatedProduct = $this->productService->updateProduct($product->id, $updateData);

        $this->assertEquals('Updated Product', $updatedProduct->name);
        $this->assertDatabaseHas('products', ['name' => 'Updated Product']);
    }

    /**
     * Test updating a product with invalid data.
     *
     * @return void
     */
    public function testUpdateProductFailsWithInvalidData()
    {
        $product = Product::factory()->create();

        $this->expectException(ValidationException::class);

        $this->productService->updateProduct($product->id, [
            'price' => 'invalid_price', // Invalid price format
        ]);
    }

    /**
     * Test deleting a product successfully.
     *
     * @return void
     */
    public function testDeleteProduct()
    {
        $product = Product::factory()->create();

        $this->productService->deleteProduct($product->id);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /**
     * Test deleting a non-existent product.
     *
     * @return void
     */
    public function testDeleteNonExistentProduct()
    {
        $nonExistentId = 999;

        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->productService->deleteProduct($nonExistentId);
    }
}
