<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Hiển thị danh sách sheet nhạc đã mua
     */
    public function sheets()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Lấy tất cả sheet nhạc đã mua
        $purchases = Purchase::with('product')
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();

        // Debug
        \Log::info('User ID: ' . $user->id);
        \Log::info('Purchases count: ' . $purchases->count());

        return view('account.sheets', compact('purchases'));
    }

    /**
     * Hiển thị lịch sử hoạt động
     */
    public function activity()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Lấy lịch sử mua hàng
        $activities = Purchase::with('product')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('account.activity', compact('activities'));
    }

    /**
     * Download sheet nhạc đã mua
     */
    public function downloadSheet($purchaseId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $purchase = Purchase::with('product')
            ->where('id', $purchaseId)
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->first();

        if (!$purchase) {
            return redirect()->back()->with('error', 'Bạn không có quyền tải sheet nhạc này');
        }

        // Lấy đường dẫn file từ database
        $filePath = public_path($purchase->product->file_path);

        if (!file_exists($filePath)) {
            // Fallback: tìm file trong thư mục songs
            $filePath = $this->findSheetFile($purchase->product);
            if (!$filePath || !file_exists($filePath)) {
                return redirect()->back()->with('error', 'Không tìm thấy file sheet nhạc');
            }
        }

        $fileName = basename($filePath);

        return response()->download($filePath, $fileName, [
            'Content-Type' => 'text/plain',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }

    /**
     * Tìm file sheet nhạc thực trong thư mục public/songs
     */
    private function findSheetFile($product)
    {
        $songName = $product->name;
        $countryRegion = strtolower($product->country_region);

        // Thư mục tìm kiếm dựa theo quốc gia
        $searchDirs = [
            'vietnam' => public_path('songs/vietnam'),
            'china' => public_path('songs/china'),
            'japan' => public_path('songs/japan'),
        ];

        // Xác định thư mục tìm kiếm
        $searchDir = $searchDirs[$countryRegion] ?? public_path('songs/vietnam');

        if (!is_dir($searchDir)) {
            return null;
        }

        // Lấy tất cả file .txt trong thư mục
        $files = glob($searchDir . '/*.txt');

        // Tìm file có tên khớp với tên bài hát
        foreach ($files as $file) {
            $fileName = basename($file, '.txt');

            // Loại bỏ timestamp prefix (nếu có)
            $cleanFileName = preg_replace('/^\d+_/', '', $fileName);

            // So sánh tên (không phân biệt hoa thường và loại bỏ ký tự đặc biệt)
            $normalizedSongName = $this->normalizeString($songName);
            $normalizedFileName = $this->normalizeString($cleanFileName);

            if (
                strpos($normalizedFileName, $normalizedSongName) !== false ||
                strpos($normalizedSongName, $normalizedFileName) !== false
            ) {
                return $file;
            }
        }

        // Nếu không tìm thấy, trả về file đầu tiên (fallback)
        return !empty($files) ? $files[0] : null;
    }

    /**
     * Chuẩn hóa chuỗi để so sánh
     */
    private function normalizeString($string)
    {
        // Chuyển về chữ thường và loại bỏ ký tự đặc biệt
        return strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $string));
    }
}
