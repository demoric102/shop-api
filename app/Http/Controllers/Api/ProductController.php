<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    /**
     * Inject the ProductService.
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * List all products.
     */
    public function index()
    {
        $products = $this->productService->listProducts();
        return response()->json($products);
    }

    /**
     * Get details for a specific product.
     */
    public function show($id)
    {
        $product = $this->productService->getProduct($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product);
    }

    /**
     * Create a new product.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric',
            'stock_quantity' => 'required|integer',
        ]);

        $product = $this->productService->createProduct($validatedData);
        return response()->json($product, 201);
    }

    /**
     * Update an existing product.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name'           => 'sometimes|required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'sometimes|required|numeric',
            'stock_quantity' => 'sometimes|required|integer',
        ]);

        $updated = $this->productService->updateProduct($id, $validatedData);
        if (!$updated) {
            return response()->json(['message' => 'Update failed'], 400);
        }
        return response()->json(['message' => 'Product updated successfully']);
    }

    /**
     * Delete a product.
     */
    public function destroy($id)
    {
        $deleted = $this->productService->deleteProduct($id);
        if (!$deleted) {
            return response()->json(['message' => 'Delete failed'], 400);
        }
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
