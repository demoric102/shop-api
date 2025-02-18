<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;

class ProductManager extends Component
{
    public $products, $name, $description, $price, $stock_quantity, $productId;
    public $isEditing = false;

    public function mount()
    {
        $this->loadProducts();
    }

    public function loadProducts()
    {
        $this->products = Product::all();
    }

    public function createProduct()
    {
        $this->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        Product::create([
            'name'           => $this->name,
            'description'    => $this->description,
            'price'          => $this->price,
            'stock_quantity' => $this->stock_quantity,
        ]);
        session()->flash('message', 'Product added successfully.');
        $this->resetInput();
        $this->loadProducts();
    }

    public function editProduct($id)
    {
        $product = Product::find($id);
        $this->productId = $id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock_quantity = $product->stock_quantity;
        $this->isEditing = true;
    }

    public function updateProduct()
    {
        $this->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $product = Product::find($this->productId);
        $product->update([
            'name'           => $this->name,
            'description'    => $this->description,
            'price'          => $this->price,
            'stock_quantity' => $this->stock_quantity,
        ]);
        session()->flash('message', 'Product updated successfully.');
        $this->resetInput();
        $this->isEditing = false;
        $this->loadProducts();
    }

    public function deleteProduct($id)
    {
        Product::find($id)->delete();
        session()->flash('message', 'Product deleted successfully.');
        $this->loadProducts();
    }


    private function resetInput()
    {
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->stock_quantity = '';
        $this->productId = null;
    }

    public function render()
    {
        return view('livewire.admin.product-manager')->layout('layouts.app');
    }
}
