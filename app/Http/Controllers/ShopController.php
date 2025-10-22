<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', 1);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('author', 'like', '%' . $search . '%')
                    ->orWhere('transcribed_by', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('country')) {
            $query->where('country_region', $request->country);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(12);

        $countries = Product::where('is_active', 1)
            ->select('country_region')
            ->distinct()
            ->orderBy('country_region')
            ->pluck('country_region');

        return view('page.shop.index', compact('products', 'countries'));
    }
}
