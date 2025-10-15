<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Hiển thị trang quản lý đơn hàng
     */
    public function index()
    {
        // Lấy tất cả đơn hàng với pagination
        $orders = Purchase::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.orders.orders', compact('orders'));
    }

    /**
     * Xem chi tiết đơn hàng
     */
    public function show($id)
    {
        $order = Purchase::with(['user', 'product'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'order' => $order
        ]);
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
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
