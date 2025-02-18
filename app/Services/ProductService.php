<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\ProductRepositoryInterface;
use App\Models\Product;

/**
 * Class ProductService
 *
 * Handles business logic related to products.
 */
class ProductService
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * ProductService constructor.
     * Dependency Injection enforces Inversion of Control (IoC)
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * List all products.
     *
     * @return iterable
     */
    public function listProducts()
    {
        return $this->productRepository->getAll();
    }

     /**
     * Get a specific product by ID.
     *
     * @param int $id
     * @return Product|null
     */
    public function getProduct(int $id)
    {
        return $this->productRepository->findById($id);
    }

    /**
     * Create a new product.
     *
     * @param array $data
     * @return Product
     */
    public function createProduct(array $data)
    {
        $validator = Validator::make($data, [
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $this->productRepository->create($data);
    }

    /**
     * Update an existing product.
     *
     * @param int   $id
     * @param array $data
     * @return bool
     */
    public function updateProduct(int $id, array $data): Product
    {
        $product = Product::find($id);

        if (!$product) {
            throw new ModelNotFoundException("Product not found");
        }
    
        $validator = Validator::make($data, [
            'name'           => 'sometimes|required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'sometimes|required|numeric|min:0',
            'stock_quantity' => 'sometimes|required|integer|min:0',
        ]);
    
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $this->productRepository->update($id, $data);
        return Product::findOrFail($id);
    }

    /**
     * Delete a product.
     *
     * @param int $id
     * @return bool
     */
    public function deleteProduct(int $id): bool
    {
        return $this->productRepository->delete($id);
    }
}