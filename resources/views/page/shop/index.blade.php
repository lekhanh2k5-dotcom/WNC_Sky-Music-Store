
@extends('layouts.app')
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<style>[x-cloak] { display: none !important; }</style>
@endpush

@section('title', 'Cửa hàng - Sky Music Store')

@section('content')
 <div id="shop" class="page-content" x-data="{ showDetail: false, product: {} }">
        <section class="relative z-10 py-20 px-6">
            <div class="max-w-6xl mx-auto">
                <h2 class="orbitron text-5xl font-bold text-white text-center mb-16">🎼 Cửa Hàng Sheet Nhạc</h2>
                
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
                    @foreach($products as $product)
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
                                        name: '{{ $product->name }}',
                                        author: '{{ $product->author }}',
                                        composer: '{{ $product->transcribed_by }}',
                                        price: '{{ number_format($product->price, 0, ',', '.') }}đ',
                                        img: '{{ $product->image_path ? asset($product->image_path) : '' }}',
                                        video: '{{ $product->youtube_demo_url ? (Str::contains($product->youtube_demo_url, 'youtu.be') ? Str::replace('youtu.be/', 'www.youtube.com/embed/', $product->youtube_demo_url) : Str::replace('watch?v=', 'embed/', $product->youtube_demo_url)) : '' }}'
                                    }; showDetail = true;">
                                    Xem
                                </button>
                            </div>
                        </div>
                    @endforeach
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
                        <button class="bg-blue-500 text-white px-5 py-2 rounded-lg font-semibold shadow hover:bg-blue-600 transition w-fit mt-2">Thêm vào giỏ hàng</button>
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