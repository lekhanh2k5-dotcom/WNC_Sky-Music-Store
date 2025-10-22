<!-- filepath: resources/views/admin/products.blade.php -->
@extends('layouts.admin')

@section('title', 'Người Dùng')

@section('content')
<!-- Users Management -->
            <div id="users" class="admin-content active px-6 pb-6">
                <div class="admin-card rounded-xl p-6">
                    @if(session('success'))
                        <div class="mb-6 bg-green-500 text-white px-6 py-3 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="mb-6 bg-red-500 text-white px-6 py-3 rounded-lg">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <h3 class="orbitron text-2xl font-bold text-white mb-6">Quản Lý Người Dùng</h3>
                    <!-- Users Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-white border-opacity-20">
                                    <th class="text-left py-3 text-gray-300 inter">ID</th>
                                    <th class="text-left py-3 text-gray-300 inter">Người Dùng</th>
                                    <th class="text-left py-3 text-gray-300 inter">Email</th>
                                    <th class="text-left py-3 text-gray-300 inter">Số Xu</th>
                                    <th class="text-left py-3 text-gray-300 inter">Vai trò</th>
                                    <th class="text-left py-3 text-gray-300 inter">Trạng thái</th>
                                    <th class="text-left py-3 text-gray-300 inter">Ngày Đăng Ký</th>
                                    <th class="text-left py-3 text-gray-300 inter">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($users->count() > 0)
                                    @foreach($users as $user)
                                        <tr class="table-row">
                                            <td class="py-4 text-white inter font-mono">#{{ $user->id }}</td>
                                            <td class="py-4">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-10 h-10 {{ $user->is_admin ? 'bg-red-500' : 'bg-blue-500' }} rounded-full flex items-center justify-center">
                                                        <span class="text-white font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                                    </div>
                                                    <div>
                                                        <p class="text-white font-semibold inter">{{ $user->name }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 text-white inter">{{ $user->email }}</td>
                                            <td class="py-4 text-white inter font-semibold">{{ number_format($user->coins ?? 0, 0, ',', '.') }} 🪙</td>
                                            <td class="py-4">
                                                @if($user->is_admin)
                                                    <span class="inline-block bg-red-600 bg-opacity-20 text-red-300 px-3 py-1 rounded-full text-sm font-semibold">Admin</span>
                                                @else
                                                    <span class="inline-block bg-blue-600 bg-opacity-20 text-blue-300 px-3 py-1 rounded-full text-sm font-semibold">User</span>
                                                @endif
                                            </td>
                                            <td class="py-4">
                                                @if($user->is_active)
                                                    <span class="status-badge status-active">Hoạt động</span>
                                                @else
                                                    <span class="status-badge status-inactive">Bị khóa</span>
                                                @endif
                                            </td>
                                            <td class="py-4 text-white inter">{{ $user->created_at->format('d/m/Y') }}</td>
                                            <td class="py-4">
                                                <div class="flex gap-2">
                                                    @if(!$user->is_admin)
                                                        <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @if($user->is_active)
                                                                <button type="submit" class="bg-orange-500 hover:bg-orange-600 px-3 py-1 rounded text-white text-sm transition">
                                                                    🔒 Khóa
                                                                </button>
                                                            @else
                                                                <button type="submit" class="bg-green-500 hover:bg-green-600 px-3 py-1 rounded text-white text-sm transition">
                                                                    🔓 Mở
                                                                </button>
                                                            @endif
                                                        </form>
                                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-white text-sm transition">
                                                                🗑️ Xóa
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-gray-400 text-sm">Không thể thao tác</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="py-8 text-center text-gray-300 inter">
                                            Chưa có người dùng nào
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        
                        <!-- Pagination -->
                        @if($users->count() > 0)
                            <div class="mt-6">
                                {{ $users->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

<!-- No JS needed for static role and action buttons -->
@endsection