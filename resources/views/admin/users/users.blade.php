<!-- filepath: resources/views/admin/products.blade.php -->
@extends('layouts.admin')

@section('title', 'Người Dùng')

@section('content')
<!-- Users Management -->
            <div id="users" class="admin-content active px-6 pb-6">
                <div class="admin-card rounded-xl p-6">
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
                                    <th class="text-left py-3 text-gray-300 inter">Ngày Đăng Ký</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($users->count() > 0)
                                    @foreach($users as $user)
                                        <tr class="table-row">
                                            <td class="py-4 text-white inter font-mono">#{{ $user->id }}</td>
                                            <td class="py-4">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-10 h-10 {{ $user->role == 'admin' ? 'bg-red-500' : 'bg-blue-500' }} rounded-full flex items-center justify-center">
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
                                                @if($user->role == 'admin')
                                                    <span class="inline-block bg-red-600 bg-opacity-20 text-red-300 px-3 py-1 rounded-full text-sm font-semibold">Admin</span>
                                                @else
                                                    <span class="inline-block bg-blue-600 bg-opacity-20 text-blue-300 px-3 py-1 rounded-full text-sm font-semibold">User</span>
                                                @endif
                                            </td>
                                            <td class="py-4 text-white inter">{{ $user->created_at->format('d/m/Y') }}</td>
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