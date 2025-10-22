<?php

namespace App\Http\Controllers;

use App\Models\CoinTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CoinController extends Controller
{

    public function index()
    {
        return view('account.deposit');
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000|max:50000000',
            'payment_method' => 'required|in:vnpay,momo,zalopay'
        ]);

        $amount = $request->amount;
        $coins = $amount; // 1 VNĐ = 1 xu

        DB::beginTransaction();
        try {
            $transaction = CoinTransaction::create([
                'user_id' => Auth::id(),
                'amount' => $amount,
                'coins' => $coins,
                'type' => 'deposit',
                'status' => 'completed',
                'payment_method' => $request->payment_method,
                'transaction_id' => 'TXN' . time() . Auth::id(),
                'note' => 'Nạp xu tự động qua ' . strtoupper($request->payment_method)
            ]);

            $user = User::find(Auth::id());
            $user->coins += $coins;
            $user->save();

            DB::commit();

            return redirect()->route('coin.index')
                ->with('success', "✅ Nạp thành công " . number_format($coins, 0, ',', '.') . " xu qua " . strtoupper($request->payment_method) . "!");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('coin.index')
                ->with('error', '❌ Có lỗi xảy ra khi nạp xu!');
        }
    }


    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'account_number' => 'required|string|max:50',
            'bank_name' => 'required|string|max:100'
        ]);

        $amount = $request->amount;
        $coins = $amount; // 1 xu = 1 VNĐ

        $user = User::find(Auth::id());


        if ($user->coins < $coins) {
            return redirect()->route('account.withdraw')
                ->with('error', '❌ Số dư không đủ! Bạn chỉ có ' . number_format($user->coins, 0, ',', '.') . ' xu.');
        }

        DB::beginTransaction();
        try {
            $transaction = CoinTransaction::create([
                'user_id' => Auth::id(),
                'amount' => $amount,
                'coins' => $coins,
                'type' => 'withdraw',
                'status' => 'completed',
                'payment_method' => 'bank',
                'transaction_id' => 'WDW' . time() . Auth::id(),
                'note' => 'Rút ' . number_format($coins, 0, ',', '.') . ' xu về ngân hàng ' . $request->bank_name . ' - STK: ' . $request->account_number
            ]);

            $user->coins -= $coins;
            $user->save();

            DB::commit();

            return redirect()->route('account.withdraw')
                ->with('success', "✅ Yêu cầu rút " . number_format($coins, 0, ',', '.') . " xu đã được gửi! Tiền sẽ chuyển về tài khoản " . $request->account_number . " (" . $request->bank_name . ") trong 1-2 ngày làm việc.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('account.withdraw')
                ->with('error', '❌ Có lỗi xảy ra khi rút xu!');
        }
    }

    public function history()
    {
        $transactions = CoinTransaction::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('account.coin-history', compact('transactions'));
    }
}
