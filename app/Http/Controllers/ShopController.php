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

        // Lọc theo quốc gia
        if ($request->filled('country')) {
            $query->where('country_region', $request->country);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(12);

        // Lấy danh sách các quốc gia có sản phẩm
        $countries = Product::where('is_active', 1)
            ->select('country_region')
            ->distinct()
            ->orderBy('country_region')
            ->pluck('country_region');

        return view('page.shop.index', compact('products', 'countries'));
    }
}
