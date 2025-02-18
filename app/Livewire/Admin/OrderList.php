<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;

class OrderList extends Component
{
    public $orders;

    public function mount()
    {
        $this->orders = Order::orderBy('created_at', 'desc')->get();
    }

    public function updateStatus($orderId, $newStatus)
    {
        $order = Order::find($orderId); // Retrieve the order directly from the database

        if ($order) {
            $order->order_status = $newStatus; 
            $order->save();

            session()->flash('message', 'Order status updated successfully.');
        }
    }


    public function render()
    {
        return view('livewire.admin.order-list')->layout('layouts.app');
    }
}

