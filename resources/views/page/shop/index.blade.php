
@extends('layouts.app')
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<style>
    [x-cloak] { display: none !important; }
    /* Ẩn dòng "Showing x to y of z results" trong pagination */
    nav[role="navigation"] p {
        display: none !important;
    }
    .pagination-wrapper p {
        display: none !important;
    }
</style>
@endpush

@section('title', 'Cửa hàng - Sky Music Store')

@section('content')
 <div id="shop" class="page-content" x-data="{
        showDetail: false, 
        product: {},
        async addToCart(productId) {
            try {
                const response = await fetch('{{ route('cart.add') }}', {
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
                    alert('✅ ' + data.message);
                    this.showDetail = false;
                } else {
                    alert('❌ ' + data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng');
            }
        }
    }">
        <section class="relative z-10 py-20 px-6">
            <div class="max-w-6xl mx-auto">
                <h2 class="orbitron text-5xl font-bold text-white text-center mb-16">🎼 Cửa Hàng Sheet Nhạc</h2>
                
                <!-- Search Bar -->
                <div class="mb-8 max-w-2xl mx-auto">
                    <form method="GET" action="{{ route('shop.index') }}" class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="🔍 Tìm kiếm theo tên bài hát, tác giả, người soạn..." 
                            class="w-full px-6 py-4 rounded-full bg-white bg-opacity-20 backdrop-blur-sm text-white placeholder-blue-200 inter focus:outline-none focus:ring-2 focus:ring-blue-400"
                        />
                        <button 
                            type="submit" 
                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-500 text-white px-6 py-2 rounded-full hover:bg-blue-600 transition-colors font-semibold"
                        >
                            Tìm kiếm
                        </button>
                    </form>
                    @if(request('search'))
                        <div class="mt-3 text-center">
                            <span class="text-blue-200 inter">Kết quả tìm kiếm cho: "<span class="text-white font-semibold">{{ request('search') }}</span>"</span>
                            <a href="{{ route('shop.index') }}" class="ml-3 text-yellow-300 hover:text-yellow-400 underline">Xóa bộ lọc</a>
                        </div>
                    @endif
                </div>
                
                <!-- Categories -->
                <div class="flex flex-wrap justify-center gap-4 mb-12">
                    <button class="bg-white bg-opacity-20 text-white px-6 py-3 rounded-full backdrop-blur-sm hover:bg-opacity-30 transition-all inter">Tất Cả</button>
                    <button class="bg-white bg-opacity-20 text-white px-6 py-3 rounded-full backdrop-blur-sm hover:bg-opacity-30 transition-all inter">Việt Nam</button>
                    <button class="bg-white bg-opacity-20 text-white px-6 py-3 rounded-full backdrop-blur-sm hover:bg-opacity-30 transition-all inter">Nhật Bản</button>
                    <button class="bg-white bg-opacity-20 text-white px-6 py-3 rounded-full backdrop-blur-sm hover:bg-opacity-30 transition-all inter">Hàn Quốc</button>
                    <button class="bg-white bg-opacity-20 text-white px-6 py-3 rounded-full backdrop-blur-sm hover:bg-opacity-30 transition-all inter">Trung Quốc</button>
                    <button class="bg-white bg-opacity-20 text-white px-6 py-3 rounded-full backdrop-blur-sm hover:bg-opacity-30 transition-all inter">US-UK</button>
                </div>

                <!-- Products Grid -->
                <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse($products as $product)
                        <div class="game-card rounded-xl p-4">
                            <div class="bg-gradient-to-br from-blue-400 to-purple-500 rounded-lg mb-4 flex items-center justify-center" style="aspect-ratio: 16/9; width: 100%;">
                                @if($product->image_path)
                                    <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="object-cover w-full h-full rounded-lg" />
                                @else
                                    <span class="text-3xl">🎵</span>
                                @endif
                            </div>
                            <h4 class="orbitron font-bold text-white mb-2">{{ $product->name }}</h4>
                            <p class="inter text-blue-200 text-sm mb-1">Tác giả: {{ $product->author }}</p>
                            <p class="inter text-blue-200 text-sm mb-1">Người soạn: {{ $product->transcribed_by }}</p>
                            <div class="flex justify-between items-center mt-2">
                                <span class="orbitron text-yellow-300 font-bold">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 transition-colors"
                                    @click="product = {
                                        id: {{ $product->id }},
                                        name: '{{ $product->name }}',
                                        author: '{{ $product->author }}',
                                        composer: '{{ $product->transcribed_by }}',
                                        price: '{{ number_format($product->price, 0, ',', '.') }}đ',
                                        rawPrice: {{ $product->price }},
                                        img: '{{ $product->image_path ? asset($product->image_path) : '' }}',
                                        video: '{{ $product->youtube_demo_url ? (Str::contains($product->youtube_demo_url, 'youtu.be') ? Str::replace('youtu.be/', 'www.youtube.com/embed/', $product->youtube_demo_url) : Str::replace('watch?v=', 'embed/', $product->youtube_demo_url)) : '' }}'
                                    }; showDetail = true;">
                                    Xem
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-20">
                            <div class="text-6xl mb-4">🔍</div>
                            <h3 class="orbitron text-2xl font-bold text-white mb-2">Không tìm thấy sản phẩm</h3>
                            <p class="inter text-blue-200">Thử tìm kiếm với từ khóa khác hoặc <a href="{{ route('shop.index') }}" class="text-yellow-300 hover:text-yellow-400 underline">xem tất cả sản phẩm</a></p>
                        </div>
                    @endforelse
                </div>
                
                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    <div class="pagination-wrapper">
                        {{ $products->links() }}
                    </div>
                </div>
                
            </div>
        </section>
    <!-- Popup chi tiết sản phẩm -->
    <div x-show="showDetail" x-transition x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-6 relative flex flex-col gap-4">
                <button @click="showDetail=false" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-xl font-bold">&times;</button>
                <div class="flex flex-col md:flex-row gap-6 items-center">
                    <div class="w-full md:w-1/3">
                        <div class="rounded-lg overflow-hidden" style="aspect-ratio: 16/9;">
                            <img :src="product.img" alt="Ảnh đại diện" class="object-cover w-full h-full" />
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col gap-2">
                        <h3 class="orbitron text-2xl font-bold text-gray-900" x-text="product.name"></h3>
                        <p class="inter text-gray-700 text-base">Tác giả: <span class="font-semibold" x-text="product.author"></span></p>
                        <p class="inter text-gray-700 text-base">Người soạn: <span class="font-semibold" x-text="product.composer"></span></p>
                        <p class="orbitron text-blue-600 text-xl font-bold">Giá: <span x-text="product.price"></span></p>
                        <button @click="addToCart(product.id)" 
                                class="bg-blue-500 text-white px-5 py-2 rounded-lg font-semibold shadow hover:bg-blue-600 transition w-fit mt-2">
                            Thêm vào giỏ hàng
                        </button>
                    </div>
                </div>
                <div class="mt-4">
                    <div style="position:relative;width:100%;aspect-ratio:16/9;">
                        <iframe :src="product.video" style="position:absolute;top:0;left:0;width:100%;height:100%;" class="rounded-lg shadow" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection