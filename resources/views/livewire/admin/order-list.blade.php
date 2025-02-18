<div class="max-w-5xl mx-auto p-6 bg-white shadow-lg rounded-lg">
    <!-- Flash Messages -->
    @if (session('message'))
        <div class="bg-green-500 text-white p-4 rounded-md mb-4">
            {{ session('message') }}
        </div>
    @endif
    <h1 class="text-2xl font-bold mb-4">Orders</h1>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-200 shadow-sm rounded-md">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="border p-3">ID</th>
                    <th class="border p-3">User ID</th>
                    <th class="border p-3">Total Price</th>
                    <th class="border p-3">Status</th>
                    <th class="border p-3">Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr class="hover:bg-gray-50 even:bg-gray-100">
                    <td class="border p-3">{{ $order->id }}</td>
                    <td class="border p-3">{{ $order->user_id }}</td>
                    <td class="border p-3">${{ number_format($order->total_price, 2) }}</td>
                    <td class="border p-3">
                        <select wire:change="updateStatus({{ $order->id }}, $event.target.value)"
                                class="px-2 py-1 rounded-md bg-gray-500 text-white">
                            <option value="pending" class="bg-yellow-500" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" class="bg-green-500" {{ $order->order_status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="canceled" class="bg-red-500" {{ $order->order_status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                    </td>
                    <td class="border p-3">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
