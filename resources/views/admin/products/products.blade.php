<!-- filepath: resources/views/admin/products.blade.php -->
@extends('layouts.admin')

@section('title', 'Quản Lý Sheet Nhạc')

@section('content')

<!-- Products Management -->
            <div id="products" class="admin-content active px-6 pb-6">
                <div class="admin-card rounded-xl p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="orbitron text-2xl font-bold text-white">Bản Nhạc</h3>
                        <a href="{{ route('admin.products.create') }}" class="bg-blue-500 hover:bg-blue-600 px-6 py-3 rounded-lg text-white inter font-semibold">
                            + Thêm Sheet Mới
                        </a>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="bg-green-500 bg-opacity-20 border border-green-500 rounded-lg p-4 mb-6">
                            <p class="text-green-300 font-semibold">✅ {{ session('success') }}</p>
                        </div>
                    @endif

                    <!-- Filters -->
                    <div class="flex flex-wrap gap-4 mb-6">
                        <!-- Custom Dropdown Danh Mục -->
                        <div class="relative" x-data="{ open: false, selected: 'Tất Cả', options: ['Tất Cả', 'Việt Nam', 'Nhật Bản', 'Hàn Quốc', 'Trung Quốc', 'US-UK'] }">
                            <button type="button" @click="open = !open" class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-lg border border-white border-opacity-30 flex items-center min-w-[180px] justify-between">
                                <span x-text="selected"></span>
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-full bg-slate-800 text-white rounded-lg shadow-lg z-20">
                                <template x-for="option in options" :key="option">
                                    <div @click="selected = option; open = false" class="px-4 py-2 hover:bg-blue-600 cursor-pointer" x-text="option"></div>
                                </template>
                            </div>
                        </div>
                        <input type="text" placeholder="Tìm kiếm sheet nhạc..." class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-lg border border-white border-opacity-30 placeholder-gray-300">
                    </div>

                    <!-- Products Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-white border-opacity-20">
                                    <th class="text-left py-3 text-gray-300 inter">Tên</th>
                                    <th class="text-left py-3 text-gray-300 inter">Người Soạn</th>
                                    <th class="text-left py-3 text-gray-300 inter">Danh Mục</th>
                                    <th class="text-left py-3 text-gray-300 inter">Giá</th>
                                    <th class="text-left py-3 text-gray-300 inter">Lượt Mua</th>
                                    <th class="text-left py-3 text-gray-300 inter">Trạng Thái</th>
                                    <th class="text-left py-3 text-gray-300 inter">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                <tr class="table-row">
                                    <td class="py-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                                <span class="text-xl">🎵</span>
                                            </div>
                                            <div>
                                                <p class="text-white font-semibold inter">{{ $product->name }}</p>
                                                <p class="text-blue-200 text-sm inter">{{ $product->author }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-white inter">{{ $product->transcribed_by }}</td>
                                    <td class="py-4 text-white inter">{{ $product->country_region }}</td>
                                    <td class="py-4 text-white inter">{{ number_format($product->price) }}đ</td>
                                    <td class="py-4 text-white inter">{{ $product->downloads_count }}</td>
                                    <td class="py-4">
                                        <span class="status-badge {{ $product->is_active ? 'status-active' : 'status-inactive' }}">
                                            {{ $product->is_active ? 'Đang bán' : 'Ngừng bán' }}
                                        </span>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded text-white text-sm">Sửa</a>
                                            <button class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-white text-sm">Xóa</button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-gray-400">
                                        Chưa có bản nhạc nào
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

@endsection

<!-- Thêm Alpine.js nếu chưa có -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>