@extends('layouts.account')
@section('content')
<div class="max-w-4xl mx-auto" x-data="{ amount: 10000 }">
    @if(session('success'))
        <div class="mb-6 bg-green-500 text-white px-6 py-3 rounded-lg">
            ✅ {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-6 bg-red-500 text-white px-6 py-3 rounded-lg">
            ❌ {{ session('error') }}
        </div>
    @endif
    
    <div class="flex flex-col items-center mb-8">
        <span class="text-5xl coin-spin mb-2">🏧</span>
        <h2 class="orbitron text-3xl font-bold text-white mb-1">Rút Sky Coins</h2>
        <div class="text-yellow-200 text-lg mb-2">Số dư hiện tại: <span class="font-bold">{{ Auth::user()->coins ?? 0 }}</span> coins</div>
    </div>
    
    <div class="profile-card rounded-3xl p-8 shadow-2xl bg-white/30 border border-white/20 backdrop-blur-lg">
        <form action="{{ route('coin.withdraw') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-white font-semibold mb-2">Chọn gói rút nhanh</label>
                <div class="grid grid-cols-3 gap-3">
                    <button type="button" @click="amount = 10000" :class="amount === 10000 ? 'bg-yellow-300 border-yellow-500' : 'bg-white/60 border-yellow-200'" class="hover:bg-yellow-100 rounded-xl p-4 flex flex-col items-center border-2 transition">
                        <span class="text-2xl">🪙</span>
                        <span class="font-bold text-yellow-600">10,000 xu</span>
                        <span class="text-xs text-gray-700">10.000đ</span>
                    </button>
                    <button type="button" @click="amount = 20000" :class="amount === 20000 ? 'bg-yellow-300 border-yellow-500' : 'bg-white/60 border-yellow-200'" class="hover:bg-yellow-100 rounded-xl p-4 flex flex-col items-center border-2 transition">
                        <span class="text-2xl">🪙</span>
                        <span class="font-bold text-yellow-600">20,000 xu</span>
                        <span class="text-xs text-gray-700">20.000đ</span>
                    </button>
                    <button type="button" @click="amount = 50000" :class="amount === 50000 ? 'bg-yellow-300 border-yellow-500' : 'bg-white/60 border-yellow-200'" class="hover:bg-yellow-100 rounded-xl p-4 flex flex-col items-center border-2 transition">
                        <span class="text-2xl">🪙</span>
                        <span class="font-bold text-yellow-600">50,000 xu</span>
                        <span class="text-xs text-gray-700">50.000đ</span>
                    </button>
                    <button type="button" @click="amount = 100000" :class="amount === 100000 ? 'bg-yellow-300 border-yellow-500' : 'bg-white/60 border-yellow-200'" class="hover:bg-yellow-100 rounded-xl p-4 flex flex-col items-center border-2 transition">
                        <span class="text-2xl">🪙</span>
                        <span class="font-bold text-yellow-600">100,000 xu</span>
                        <span class="text-xs text-gray-700">100.000đ</span>
                    </button>
                    <button type="button" @click="amount = 200000" :class="amount === 200000 ? 'bg-yellow-300 border-yellow-500' : 'bg-white/60 border-yellow-200'" class="hover:bg-yellow-100 rounded-xl p-4 flex flex-col items-center border-2 transition">
                        <span class="text-2xl">🪙</span>
                        <span class="font-bold text-yellow-600">200,000 xu</span>
                        <span class="text-xs text-gray-700">200.000đ</span>
                    </button>
                    <button type="button" @click="amount = 500000" :class="amount === 500000 ? 'bg-yellow-300 border-yellow-500' : 'bg-white/60 border-yellow-200'" class="hover:bg-yellow-100 rounded-xl p-4 flex flex-col items-center border-2 transition">
                        <span class="text-2xl">🪙</span>
                        <span class="font-bold text-yellow-600">500,000 xu</span>
                        <span class="text-xs text-gray-700">500.000đ</span>
                    </button>
                </div>
            </div>
            
            <div>
                <label class="block text-white font-semibold mb-2">Hoặc nhập số xu muốn rút</label>
                <input type="number" name="amount" x-model="amount" min="10000" step="1000" max="{{ Auth::user()->coins }}" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-400 outline-none" placeholder="Nhập số xu (tối thiểu 10.000 xu)..." />
                <p class="text-sm text-yellow-200 mt-1">Bạn sẽ nhận được <span class="font-bold" x-text="amount.toLocaleString()"></span> VNĐ (tỉ lệ 1:1)</p>
            </div>
            
            <div>
                <label class="block text-white font-semibold mb-2">Phương thức nhận tiền</label>
                <div class="flex gap-4 flex-wrap">
                    <label class="flex items-center gap-2 cursor-pointer bg-white/50 px-4 py-2 rounded-lg hover:bg-white/70 transition">
                        <input type="radio" name="payment_method" value="vnpay" class="accent-blue-500" checked>
                        <span class="text-blue-600 font-semibold">VNPay</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer bg-white/50 px-4 py-2 rounded-lg hover:bg-white/70 transition">
                        <input type="radio" name="payment_method" value="momo" class="accent-pink-500">
                        <span class="text-pink-600 font-semibold">Momo</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer bg-white/50 px-4 py-2 rounded-lg hover:bg-white/70 transition">
                        <input type="radio" name="payment_method" value="zalopay" class="accent-blue-500">
                        <span class="text-blue-700 font-semibold">ZaloPay</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer bg-white/50 px-4 py-2 rounded-lg hover:bg-white/70 transition">
                        <input type="radio" name="payment_method" value="bank" class="accent-green-500">
                        <span class="text-green-700 font-semibold">Ngân hàng</span>
                    </label>
                </div>
            </div>
            
            <div>
                <label class="block text-white font-semibold mb-2">Thông tin tài khoản nhận</label>
                <input type="text" name="account_info" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-400 outline-none" placeholder="Nhập số điện thoại/số tài khoản..." />
                <p class="text-xs text-gray-200 mt-1">* VD: 0123456789 (Momo/ZaloPay) hoặc 1234567890 (Ngân hàng)</p>
            </div>
            
            <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-red-400 to-orange-400 text-white font-bold text-lg shadow-lg hover:from-red-500 hover:to-orange-500 transition">
                🏧 Rút tiền ngay
            </button>
            <div class="text-xs text-gray-200 mt-2 text-center">* Tỷ lệ: 1 xu = 1 VNĐ | Xu sẽ bị trừ ngay lập tức</div>
        </form>
    </div>
</div>
@endsection
