{{-- filepath: resources/views/shop/detail.blade.php --}}
@extends('layouts.app')

@section('title', $product->name . ' - Sky Music Store')

@section('content')
<div id="product-detail-page" class="page-content min-h-screen">
    <section class="relative z-10 py-10 px-6">
        <div class="max-w-7xl mx-auto">
            <!-- Back Button -->
            <a href="{{ url('/shop') }}" class="inline-flex items-center text-white mb-6 hover:text-yellow-400 transition">
                ← Quay lại cửa hàng
            </a>

            <!-- Product Detail Card -->
            <div class="game-card rounded-xl overflow-hidden backdrop-blur-md">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                    <!-- Left: Image -->
                    <div class="relative">
                        @if($product->image_path)
                            <img 
                                src="{{ asset($product->image_path) }}" 
                                alt="{{ $product->name }}" 
                                class="w-full rounded-lg shadow-2xl">
                        @else
                            <div class="w-full h-96 bg-gradient-to-br from-purple-900 to-blue-900 rounded-lg flex items-center justify-center text-white text-9xl">
                                🎵
                            </div>
                        @endif
                    </div>

                    <!-- Right: Info -->
                    <div class="text-white">
                        <h1 class="orbitron text-4xl font-bold mb-4">
                            {{ $product->name }}
                        </h1>

                        <p class="inter text-xl text-blue-200 mb-2">
                            🎤 Tác giả: <strong>{{ $product->author }}</strong>
                        </p>

                        @if($product->transcribed_by)
                            <p class="inter text-sm text-gray-300 mb-4">
                                ✍️ Chuyển soạn: {{ $product->transcribed_by }}
                            </p>
                        @endif

                        <div class="mb-4">
                            <span class="bg-blue-500 bg-opacity-30 px-4 py-2 rounded-full">
                                🌍 {{ $product->country_region }}
                            </span>
                        </div>

                        <p class="inter text-gray-300 mb-6">
                            ⬇️ Đã tải: <strong class="text-yellow-400">{{ $product->downloads_count }}</strong> lượt
                        </p>

                        <div class="mb-6">
                            <p class="inter text-sm text-gray-300 mb-2">Giá:</p>
                            <p class="orbitron text-5xl font-bold text-yellow-400">
                                ${{ number_format($product->price, 2) }}
                            </p>
                        </div>

                        @if($product->youtube_demo_url)
                            <a 
                                href="{{ $product->youtube_demo_url }}" 
                                target="_blank"
                                class="inline-block bg-red-600 text-white px-6 py-3 rounded-full font-semibold hover:scale-105 transition-transform mb-6">
                                ▶️ Xem Demo trên YouTube
                            </a>
                        @endif

                        <div class="flex gap-4">
                            <button class="flex-1 bg-gradient-to-r from-yellow-400 to-pink-500 text-white py-4 rounded-full font-bold text-lg hover:scale-105 transition-transform shadow-xl">
                                🛒 Thêm vào giỏ hàng
                            </button>
                            <button class="bg-white bg-opacity-20 text-white px-6 py-4 rounded-full hover:scale-105 transition-transform">
                                ❤️
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="mt-12">
                    <h2 class="orbitron text-3xl font-bold text-white mb-6">
                        🎵 Bản nhạc liên quan
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $related)
                            <div class="game-card rounded-xl overflow-hidden hover:scale-105 transition-transform duration-300 shadow-xl">
                                <a href="{{ url('/shop/' . $related->id) }}">
                                    <div class="relative h-40 bg-gradient-to-br from-purple-900 to-blue-900">
                                        @if($related->image_path)
                                            <img 
                                                src="{{ asset($related->image_path) }}" 
                                                alt="{{ $related->name }}" 
                                                class="w-full h-full object-cover">
                                        @else
                                            <div class="flex items-center justify-center h-full text-white text-5xl">
                                                🎵
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="p-4">
                                        <h3 class="orbitron text-sm font-bold text-white mb-2 truncate">
                                            {{ $related->name }}
                                        </h3>
                                        
                                        <p class="inter text-xs text-blue-200 mb-2 truncate">
                                            {{ $related->author }}
                                        </p>
                                        
                                        <p class="orbitron text-lg font-bold text-yellow-400">
                                            ${{ number_format($related->price, 2) }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>
@endsection