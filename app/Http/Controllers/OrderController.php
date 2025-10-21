<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Purchase::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.orders.orders', compact('orders'));
    }


    public function show($id)
    {
        $order = Purchase::with(['user', 'product'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'order' => $order
        ]);
    }


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $order = Purchase::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thành công'
        ]);
    }
}
