@extends('layouts.app')

@section('title', 'Shop - Sky Music Store')

@section('content')
<div id="shop-page" class="page-content min-h-screen">
    <section class="relative z-10 py-10 px-6">
        <div class="max-w-7xl mx-auto">
            <!-- Page Title -->
            <h1 class="orbitron text-4xl md:text-5xl font-bold text-white text-center mb-8">
                🎵 Cửa Hàng Sheet Nhạc
            </h1>

            <!-- Search & Filter Form -->
            <form method="GET" action="{{ url('/shop') }}" class="mb-8">
                <!-- Search Box -->
                <div class="game-card rounded-xl p-6 mb-6 backdrop-blur-md">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        class="w-full p-4 rounded-lg bg-white bg-opacity-20 text-white placeholder-blue-200 border border-white border-opacity-30 focus:border-opacity-60 focus:outline-none transition text-lg" 
                        placeholder="🔍 Tìm kiếm bài hát, tác giả...">
                </div>

                <!-- Country Filter Buttons -->
                <div class="flex flex-wrap justify-center gap-4 mb-6">
                    <button 
                        type="submit" 
                        name="country" 
                        value="all"
                        class="px-6 py-3 rounded-full font-semibold transition-all {{ !request('country') || request('country') == 'all' ? 'bg-gradient-to-r from-yellow-400 to-pink-500 text-white shadow-lg' : 'bg-white bg-opacity-20 text-white hover:bg-opacity-30' }}">
                        Tất Cả
                    </button>

                    @foreach($countries as $country)
                        <button 
                            type="submit" 
                            name="country" 
                            value="{{ $country }}"
                            class="px-6 py-3 rounded-full font-semibold transition-all {{ request('country') == $country ? 'bg-gradient-to-r from-yellow-400 to-pink-500 text-white shadow-lg' : 'bg-white bg-opacity-20 text-white hover:bg-opacity-30' }}">
                            {{ $country }}
                        </button>
                    @endforeach
                </div>

                <!-- Price Range & Sort -->
                <div class="game-card rounded-xl p-6 mb-6 backdrop-blur-md">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Price Min -->
                        <input 
                            type="number" 
                            name="price_min" 
                            value="{{ request('price_min') }}"
                            step="0.01"
                            class="p-3 rounded-lg bg-white bg-opacity-20 text-white placeholder-blue-200 border border-white border-opacity-30 focus:border-opacity-60 focus:outline-none transition" 
                            placeholder="💰 Giá từ ($)">

                        <!-- Price Max -->
                        <input 
                            type="number" 
                            name="price_max" 
                            value="{{ request('price_max') }}"
                            step="0.01"
                            class="p-3 rounded-lg bg-white bg-opacity-20 text-white placeholder-blue-200 border border-white border-opacity-30 focus:border-opacity-60 focus:outline-none transition" 
                            placeholder="💰 Giá đến ($)">

                        <!-- Sort -->
                        <select 
                            name="sort" 
                            class="p-3 rounded-lg bg-white bg-opacity-20 text-white border border-white border-opacity-30 focus:border-opacity-60 focus:outline-none transition"
                            onchange="this.form.submit()">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>🆕 Mới nhất</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>🔥 Phổ biến</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>💲 Giá tăng</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>💰 Giá giảm</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>🔤 A-Z</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>🔡 Z-A</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4 mt-4">
                        <button 
                            type="submit" 
                            class="flex-1 bg-gradient-to-r from-yellow-400 to-pink-500 text-white py-3 rounded-full font-bold hover:scale-105 transition-transform shadow-lg">
                            🔍 Tìm kiếm
                        </button>
                        <a 
                            href="{{ url('/shop') }}" 
                            class="flex-1 bg-gray-500 bg-opacity-50 text-white py-3 rounded-full font-bold hover:scale-105 transition-transform text-center shadow-lg">
                            🔄 Reset
                        </a>
                    </div>
                </div>
            </form>

            <!-- Results Info -->
            @if(request('search') || request('country') || request('price_min') || request('price_max'))
                <div class="text-white mb-6 backdrop-blur-md bg-white bg-opacity-10 rounded-lg p-4">
                    <p class="inter text-lg">
                        Tìm thấy <strong class="text-yellow-400">{{ $products->total() }}</strong> bản nhạc
                        
                        @if(request('search'))
                            cho từ khóa "<strong class="text-pink-400">{{ request('search') }}</strong>"
                        @endif
                        
                        @if(request('country') && request('country') != 'all')
                            từ <strong class="text-blue-300">{{ request('country') }}</strong>
                        @endif

                        @if(request('price_min') || request('price_max'))
                            , giá từ 
                            <strong class="text-yellow-300">
                                ${{ request('price_min', '0') }} - ${{ request('price_max', '∞') }}
                            </strong>
                        @endif
                    </p>
                </div>
            @endif

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="game-card rounded-xl overflow-hidden hover:scale-105 transition-transform duration-300 shadow-xl">
                            <a href="{{ url('/shop/' . $product->id) }}">
                                <!-- Product Image -->
                                <div class="relative h-48 bg-gradient-to-br from-purple-900 to-blue-900">
                                    @if($product->image_path)
                                        <img 
                                            src="{{ asset($product->image_path) }}" 
                                            alt="{{ $product->name }}" 
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full text-white text-6xl">
                                            🎵
                                        </div>
                                    @endif

                                    @if($product->downloads_count > 0)
                                        <span class="absolute bottom-2 right-2 bg-black bg-opacity-70 text-white text-xs px-2 py-1 rounded-full">
                                            ⬇️ {{ $product->downloads_count }}
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="p-4">
                                    <h3 class="orbitron text-lg font-bold text-white mb-2 truncate" title="{{ $product->name }}">
                                        {{ $product->name }}
                                    </h3>
                                    
                                    <p class="inter text-sm text-blue-200 mb-1 truncate" title="{{ $product->author }}">
                                        🎤 {{ $product->author }}
                                    </p>
                                    
                                    <p class="inter text-xs text-blue-300 mb-3">
                                        🌍 {{ $product->country_region }}
                                    </p>
                                    
                                    <div class="flex justify-between items-center">
                                        <span class="orbitron text-xl font-bold text-yellow-400">
                                            ${{ number_format($product->price, 2) }}
                                        </span>
                                        
                                        <button class="bg-gradient-to-r from-yellow-400 to-pink-500 text-white px-4 py-2 rounded-full text-sm font-semibold hover:scale-105 transition-transform">
                                            Xem
                                        </button>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <!-- No Results -->
                <div class="game-card rounded-xl p-12 text-center backdrop-blur-md">
                    <div class="text-6xl mb-4">😢</div>
                    <h3 class="orbitron text-2xl font-bold text-white mb-2">
                        Không tìm thấy bản nhạc
                    </h3>
                    <p class="inter text-blue-200 mb-6">
                        Thử thay đổi bộ lọc hoặc từ khóa khác
                    </p>
                    <a 
                        href="{{ url('/shop') }}" 
                        class="inline-block bg-gradient-to-r from-yellow-400 to-pink-500 text-white px-8 py-3 rounded-full font-semibold hover:scale-105 transition-transform shadow-lg">
                        Xem tất cả
                    </a>
                </div>
            @endif
        </div>
    </section>
</div>

<style>
    select option {
        background-color: #1e1e2e;
        color: white;
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }
</style>
@endsection