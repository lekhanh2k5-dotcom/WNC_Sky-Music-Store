@extends('layouts.app')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush

@section('content')
<div class="max-w-6xl mx-auto px-2 py-10" x-data="{
    async removeFromCart(productId) {
        if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
            return;
        }
        
        try {
            const response = await fetch('{{ route('cart.remove') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                location.reload();
            } else {
                alert('❌ ' + data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('❌ Có lỗi xảy ra');
        }
    },
    async checkout() {
        if (!confirm('Bạn có chắc chắn muốn thanh toán bằng xu?')) {
            return;
        }
        
        try {
            const response = await fetch('{{ route('cart.checkout') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                alert('✅ ' + data.message);
                location.reload();
            } else {
                alert('❌ ' + data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('❌ Có lỗi xảy ra trong quá trình thanh toán');
        }
    }
}">
    <div class="game-card rounded-2xl p-8">
        <h2 class="text-center text-3xl md:text-4xl font-bold mb-2 text-white">GIỎ HÀNG CỦA BẠN</h2>
        <div class="text-center text-white/80 mb-8">
            @if($cartCount > 0)
                Có {{ $cartCount }} bản nhạc trong giỏ hàng
            @else
                Giỏ hàng trống
            @endif
        </div>
        
        @if(count($cart) > 0)
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Cart Table -->
            <div class="flex-1 bg-white/10 backdrop-blur-2xl rounded-2xl shadow-2xl p-6 overflow-x-auto border border-white/30 text-white">
            <table class="w-full text-base">
                <thead>
                    <tr class="border-b border-white/30 text-white/80 text-sm">
                        <th class="py-3 px-2 font-semibold text-left">Hình ảnh</th>
                        <th class="py-3 px-2 font-semibold text-left">Thông tin</th>
                        <th class="py-3 px-2 font-semibold text-right">Giá tiền</th>
                        <th class="py-3 px-2 font-semibold text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                    <tr class="border-b border-gray-100 hover:bg-white/30 transition">
                        <td class="py-4 px-2 align-top w-44">
                            <div class="aspect-w-16 aspect-h-9 w-full rounded-lg overflow-hidden border border-gray-200">
                                @if($item['image_path'])
                                    <img src="{{ asset($item['image_path']) }}" alt="{{ $item['name'] }}" class="object-cover w-full h-full">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
                                        <span class="text-3xl">🎵</span>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-2 align-top">
                            <div class="font-semibold text-white text-lg">{{ $item['name'] }}</div>
                            <div class="text-white/80 text-sm">Tác giả: {{ $item['author'] }}</div>
                            <div class="text-white/60 text-sm mb-1">Người soạn: {{ $item['transcribed_by'] }}</div>
                            @if($item['youtube_demo_url'])
                                <a href="{{ $item['youtube_demo_url'] }}" target="_blank" class="text-cyan-300 text-sm underline hover:text-cyan-100">Xem demo</a>
                            @endif
                        </td>
                        <td class="py-4 px-2 align-top text-right">
                            <span class="font-bold text-lg text-yellow-300">{{ number_format($item['price'], 0, ',', '.') }}đ</span>
                        </td>
                        <td class="py-4 px-2 align-top text-right">
                            <button @click="removeFromCart({{ $item['id'] }})" 
                                    class="text-red-400 hover:text-red-600 text-2xl transition align-top" 
                                    title="Xóa sản phẩm">&times;</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
            <!-- Order Summary -->
            <div class="w-full md:w-80 bg-white/10 backdrop-blur-2xl rounded-2xl shadow-2xl p-6 flex flex-col gap-4 border border-white/30 text-white">
                <div class="font-semibold text-lg text-white mb-2">Tóm tắt đơn hàng</div>
                
                @auth
                <div class="flex justify-between text-white/80 text-base mb-2">
                    <span>Số xu hiện có:</span>
                    <span class="text-yellow-300 font-bold">🪙 {{ number_format(auth()->user()->coins ?? 0, 0, ',', '.') }}</span>
                </div>
                @endauth
                
                <div class="flex justify-between text-white/80 text-base">
                    <span>Tổng xu cần:</span>
                    <span class="text-red-300">🪙 {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                
                @auth
                @if((auth()->user()->coins ?? 0) >= $total)
                    <div class="text-center text-green-300 text-sm">
                        ✅ Đủ xu để thanh toán
                    </div>
                @else
                    <div class="text-center text-red-300 text-sm">
                        ❌ Không đủ xu (thiếu {{ number_format($total - (auth()->user()->coins ?? 0), 0, ',', '.') }} xu)
                    </div>
                @endif
                @endauth
                
                <div class="flex justify-between items-center text-xl font-bold text-yellow-300 mt-2 pt-2 border-t border-white/30">
                    <span>Tổng cộng:</span>
                    <span>🪙 {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                
                @auth
                    @if((auth()->user()->coins ?? 0) >= $total)
                        <button @click="checkout()" 
                                class="w-full mt-4 py-3 rounded-lg bg-gradient-to-r from-green-500 to-emerald-400 text-white font-bold text-lg shadow hover:from-green-600 hover:to-emerald-500 transition">
                            🪙 MUA
                        </button>
                    @else
                        <button disabled 
                                class="w-full mt-4 py-3 rounded-lg bg-gray-500 text-white font-bold text-lg shadow cursor-not-allowed opacity-50">
                            Không đủ xu
                        </button>
                        <a href="{{ route('account.deposit') }}" 
                           class="w-full py-3 rounded-lg bg-gradient-to-r from-yellow-500 to-orange-400 text-white font-bold text-lg text-center shadow hover:from-yellow-600 hover:to-orange-500 transition">
                            💰 NẠP THÊM XU
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" 
                       class="w-full mt-4 py-3 rounded-lg bg-gradient-to-r from-blue-500 to-cyan-400 text-white font-bold text-lg text-center shadow hover:from-blue-600 hover:to-cyan-500 transition">
                        ĐĂNG NHẬP ĐỂ THANH TOÁN
                    </a>
                @endauth
                
                <a href="{{ route('shop.index') }}" class="w-full py-3 rounded-lg border border-white/20 text-white font-semibold text-lg text-center hover:bg-white/10 transition">MUA THÊM SẢN PHẨM</a>
            </div>
        </div>
        @else
        <!-- Empty Cart -->
        <div class="text-center py-16">
            <div class="text-6xl mb-4">🛒</div>
            <h3 class="text-2xl font-bold text-white mb-4">Giỏ hàng của bạn đang trống</h3>
            <p class="text-white/80 mb-8">Hãy thêm một số sheet nhạc vào giỏ hàng để tiếp tục!</p>
            <a href="{{ route('shop.index') }}" 
               class="inline-block px-8 py-3 bg-gradient-to-r from-blue-500 to-cyan-400 text-white font-bold text-lg rounded-lg shadow hover:from-blue-600 hover:to-cyan-500 transition">
                KHÁM PHÁ SẢN PHẨM
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
