<div class="max-w-5xl mx-auto p-6 bg-white shadow-lg rounded-lg">
    <!-- Flash Messages -->
    @if (session('message'))
        <div class="bg-green-500 text-white p-4 rounded-md mb-4">
            {{ session('message') }}
        </div>
    @endif

    <h1 class="text-2xl font-bold mb-6">Product Manager</h1> <!-- Increased margin-bottom here -->

    <!-- Form for creating/updating a product -->
    <form wire:submit.prevent="{{ $isEditing ? 'updateProduct' : 'createProduct' }}" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Name:</label>
            <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Description:</label>
            <textarea wire:model="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Price:</label>
            <input type="text" wire:model="price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Stock Quantity:</label>
            <input type="text" wire:model="stock_quantity" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
            @error('stock_quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition">
                {{ $isEditing ? 'Update Product' : 'Add Product' }}
            </button>
        </div>
    </form>

    <!-- List of products -->
    <h2 class="text-xl font-semibold mt-6">Products</h2>
    <div class="overflow-x-auto mt-4">
        <table class="w-full border-collapse border border-gray-200 shadow-sm rounded-md">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">Name</th>
                    <th class="border p-2">Description</th>
                    <th class="border p-2">Price</th>
                    <th class="border p-2">Stock Quantity</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="border p-2">{{ $product->name }}</td>
                    <td class="border p-2">{{ $product->description }}</td>
                    <td class="border p-2">{{ $product->price }}</td>
                    <td class="border p-2">{{ $product->stock_quantity }}</td>
                    <td class="border p-2 space-x-2">
                        <button wire:click="editProduct({{ $product->id }})" class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">Edit</button>
                        <button wire:click="deleteProduct({{ $product->id }})" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>