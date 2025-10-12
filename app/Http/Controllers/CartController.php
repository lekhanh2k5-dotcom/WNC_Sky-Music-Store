<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Hiển thị trang giỏ hàng
     */
    public function index()
    {
        $cart = session('cart', []);
        $total = 0;
        $cartCount = count($cart);

        foreach ($cart as $item) {
            $total += $item['price'];
        }

        return view('page.shop.cart', compact('cart', 'total', 'cartCount'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::find($productId);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại'
            ]);
        }

        $cart = session()->get('cart', []);

        // Đảm bảo productId là string để so sánh key trong session
        $productKey = (string) $productId;

        // Nếu sản phẩm đã có trong giỏ hàng, không thêm nữa
        if (isset($cart[$productKey])) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm đã có trong giỏ hàng'
            ]);
        } else {
            // Thêm sản phẩm mới vào giỏ hàng
            $cart[$productKey] = [
                'id' => $product->id,
                'name' => $product->name,
                'author' => $product->author,
                'transcribed_by' => $product->transcribed_by,
                'price' => $product->price,
                'image_path' => $product->image_path,
                'youtube_demo_url' => $product->youtube_demo_url,
                'country_region' => $product->country_region
            ];
            Log::info('New product added to cart:', [
                'product_id' => $productId,
                'product_name' => $product->name
            ]);
        }

        session(['cart' => $cart]);

        // Tính tổng số sản phẩm trong giỏ hàng (chỉ đếm số sản phẩm khác nhau)
        $cartCount = count($cart);

        Log::info('Cart updated:', ['cart' => $cart]);

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm sản phẩm vào giỏ hàng',
            'cartCount' => $cartCount
        ]);
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function remove(Request $request)
    {
        $productId = $request->input('product_id');
        $cart = session()->get('cart', []);

        // Đảm bảo productId là string để so sánh key trong session
        $productKey = (string) $productId;

        if (isset($cart[$productKey])) {
            unset($cart[$productKey]);
            session(['cart' => $cart]);

            $cartCount = count($cart);

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng',
                'cartCount' => $cartCount
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Sản phẩm không tồn tại trong giỏ hàng'
        ]);
    }
}
