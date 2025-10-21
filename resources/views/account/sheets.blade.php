@extends('layouts.account')
@section('content')
<div class="profile-card rounded-2xl p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="orbitron text-xl font-bold text-white">Sheet Nhạc Đã Mua ({{ $purchases->count() }})</h3>
        <a href="{{ route('shop.index') }}" class="glow-button bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inter font-semibold">
            🛒 Mua Thêm Sheet Nhạc
        </a>
    </div>
    
    @if($purchases->count() > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left">
            <thead>
                <tr class="text-white/80 border-b border-white/20">
                    <th class="py-3 px-4 font-semibold">Hình Ảnh</th>
                    <th class="py-3 px-4 font-semibold">Tên Bài Nhạc</th>
                    <th class="py-3 px-4 font-semibold">Tác Giả</th>
                    <th class="py-3 px-4 font-semibold">Người Soạn</th>
                    <th class="py-3 px-4 font-semibold">Xu Đã Trả</th>
                    <th class="py-3 px-4 font-semibold">Ngày Mua</th>
                    <th class="py-3 px-4 font-semibold">Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchases as $purchase)
                <tr class="bg-white/10 hover:bg-white/20 transition rounded-xl">
                    <td class="py-4 px-4">
                        <div class="w-16 h-16 rounded-lg overflow-hidden">
                            @if($purchase->product->image_path)
                                <img src="{{ asset($purchase->product->image_path) }}" 
                                     alt="{{ $purchase->product->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                                    <span class="text-white text-lg">🎵</span>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="py-4 px-4">
                        <div class="orbitron font-bold text-white leading-tight">{{ $purchase->product->name }}</div>
                        <div class="inter text-xs text-blue-100">{{ $purchase->product->country_region }}</div>
                    </td>
                    <td class="py-4 px-4 text-white">{{ $purchase->product->author }}</td>
                    <td class="py-4 px-4 text-white">{{ $purchase->product->transcribed_by }}</td>
                    <td class="py-4 px-4 text-yellow-300 font-bold">🪙 {{ number_format($purchase->coins_spent, 0, ',', '.') }}</td>
                    <td class="py-4 px-4">
                        <div class="text-white font-semibold">{{ $purchase->created_at->format('d/m/Y H:i') }}</div>
                        <div class="text-blue-200 text-xs">🕒 {{ $purchase->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="py-4 px-4 flex gap-2">
                        <a href="{{ route('account.download', $purchase->id) }}" 
                           class="px-4 py-1 rounded bg-green-500 hover:bg-green-600 text-white font-semibold shadow text-center">
                            📥 Tải
                        </a>
                        @if($purchase->product->youtube_demo_url)
                        <a href="{{ $purchase->product->youtube_demo_url }}" target="_blank"
                           class="px-4 py-1 rounded bg-red-500 hover:bg-red-600 text-white font-semibold shadow text-center">
                            ▶️ Demo
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <!-- Empty State -->
    <div class="text-center py-16">
        <div class="text-6xl mb-4">🎼</div>
        <h3 class="text-2xl font-bold text-white mb-4">Chưa có sheet nhạc nào</h3>
        <p class="text-white/80 mb-8">Hãy mua một số sheet nhạc từ cửa hàng để bắt đầu!</p>
        <a href="{{ route('shop.index') }}" 
           class="inline-block px-8 py-3 bg-gradient-to-r from-blue-500 to-cyan-400 text-white font-bold text-lg rounded-lg shadow hover:from-blue-600 hover:to-cyan-500 transition">
            🛒 ĐI SHOPPING NGAY
        </a>
    </div>
    @endif
</div>
@endsection

