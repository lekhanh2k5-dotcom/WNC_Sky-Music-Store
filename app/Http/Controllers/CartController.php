<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function index()
    {
        $cart = session('cart', []);
        $total = 0;
        $cartCount = count($cart);

        foreach ($cart as $item) {
            $total += $item['price'];
        }

        $user = Auth::user();
        $userCoins = $user ? $user->coins : 0;

        return view('page.shop.cart', compact('cart', 'total', 'cartCount', 'userCoins'));
    }


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

        if (Auth::check()) {
            $hasPurchased = Purchase::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->where('status', 'completed')
                ->exists();

            if ($hasPurchased) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã mua sản phẩm này rồi! Vui lòng kiểm tra trong trang "Tài Khoản" để tải về.'
                ]);
            }
        }

        $cart = session()->get('cart', []);

        $productKey = (string) $productId;

        if (isset($cart[$productKey])) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm đã có trong giỏ hàng'
            ]);
        } else {
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

        $cartCount = count($cart);

        Log::info('Cart updated:', ['cart' => $cart]);

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm sản phẩm vào giỏ hàng',
            'cartCount' => $cartCount
        ]);
    }


    public function remove(Request $request)
    {
        $productId = $request->input('product_id');
        $cart = session()->get('cart', []);

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


    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn cần đăng nhập để thanh toán'
            ]);
        }

        $cart = session('cart', []);

        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => 'Giỏ hàng trống'
            ]);
        }

        $user = Auth::user();
        $totalCoins = 0;

        foreach ($cart as $item) {
            $totalCoins += $item['price'];
        }

        if ($user->coins < $totalCoins) {
            return response()->json([
                'success' => false,
                'message' => 'Số xu không đủ. Bạn cần ' . number_format($totalCoins, 0, ',', '.') . ' xu nhưng chỉ có ' . number_format($user->coins, 0, ',', '.') . ' xu'
            ]);
        }

        try {
            DB::beginTransaction();

            User::where('id', $user->id)->decrement('coins', $totalCoins);

            foreach ($cart as $item) {
                $existingPurchase = Purchase::where('user_id', $user->id)
                    ->where('product_id', $item['id'])
                    ->where('status', 'completed')
                    ->first();

                if (!$existingPurchase) {
                    Purchase::create([
                        'user_id' => $user->id,
                        'product_id' => $item['id'],
                        'coins_spent' => $item['price'],
                        'status' => 'completed'
                    ]);
                }
            }

            session()->forget('cart');

            DB::commit();

            $updatedUser = User::find($user->id);

            return response()->json([
                'success' => true,
                'message' => 'Thanh toán thành công! Bạn đã mua ' . count($cart) . ' bản nhạc.',
                'remaining_coins' => $updatedUser->coins
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Checkout error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra trong quá trình thanh toán'
            ]);
        }
    }
}
