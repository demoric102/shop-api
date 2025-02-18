<?php

namespace App\Repositories;

use App\Models\Product;

/**
 * Product Repository Interface
 */
interface ProductRepositoryInterface
{
    public function getAll(): iterable;

    public function findById(int $id): ?Product;

    public function create(array $data): Product;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}