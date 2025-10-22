<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\CoinTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{

    public function sheets()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $purchases = Purchase::with('product')
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('account.sheets', compact('purchases'));
    }

    public function activity()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $purchases = Purchase::with('product')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                $item->activity_type = 'purchase';
                return $item;
            });

        $coinTransactions = CoinTransaction::where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                $item->activity_type = 'coin';
                return $item;
            });

        $allActivities = $purchases->merge($coinTransactions)
            ->sortByDesc('created_at');

        $perPage = 20;
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;

        $activities = new \Illuminate\Pagination\LengthAwarePaginator(
            $allActivities->slice($offset, $perPage)->values(),
            $allActivities->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('account.activity', compact('activities'));
    }


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


    private function findSheetFile($product)
    {
        $songName = $product->name;
        $countryRegion = strtolower($product->country_region);

        $searchDirs = [
            'vietnam' => public_path('songs/vietnam'),
            'china' => public_path('songs/china'),
            'japan' => public_path('songs/japan'),
        ];

        $searchDir = $searchDirs[$countryRegion] ?? public_path('songs/vietnam');

        if (!is_dir($searchDir)) {
            return null;
        }

        $files = glob($searchDir . '/*.txt');

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

        return !empty($files) ? $files[0] : null;
    }


    private function normalizeString($string)
    {
        // Chuyển về chữ thường và loại bỏ ký tự đặc biệt
        return strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $string));
    }

    public function settings()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('account.settings');
    }

    public function updateSettings(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed',
        ], [
            'name.required' => 'Vui lòng nhập tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email này đã được sử dụng',
            'avatar.image' => 'File phải là ảnh',
            'avatar.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif',
            'avatar.max' => 'Ảnh không được vượt quá 2MB',
            'current_password.required_with' => 'Vui lòng nhập mật khẩu hiện tại',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự',
            'new_password.confirmed' => 'Mật khẩu xác nhận không khớp',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->hasFile('avatar')) {
                if ($user->avatar && file_exists(public_path($user->avatar))) {
                    unlink(public_path($user->avatar));
                }

                $avatar = $request->file('avatar');
                $avatarName = time() . '_' . $user->id . '.' . $avatar->getClientOriginalExtension();
                $avatar->move(public_path('images/avatars'), $avatarName);
                $user->avatar = 'images/avatars/' . $avatarName;
            }

            if ($request->filled('new_password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    DB::rollBack();
                    return back()->with('error', '❌ Mật khẩu hiện tại không đúng!');
                }
                $user->password = Hash::make($request->new_password);
            }

            $user->save();

            DB::commit();

            return back()->with('success', '✅ Cập nhật thông tin tài khoản thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', '❌ Có lỗi xảy ra khi cập nhật thông tin!');
        }
    }
}
