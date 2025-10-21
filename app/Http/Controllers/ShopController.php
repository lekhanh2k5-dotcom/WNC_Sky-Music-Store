<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', 1);

        // Tìm kiếm theo tên hoặc tác giả
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('author', 'like', '%' . $search . '%')
                    ->orWhere('transcribed_by', 'like', '%' . $search . '%');
            });
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('page.shop.index', compact('products'));
    }
}
