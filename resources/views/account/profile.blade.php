@extends('layouts.account')

@section('content')
<div class="space-y-6">
    <h3 class="orbitron text-xl font-bold text-white">Chỉnh Sửa Hồ Sơ</h3>
    
    <form class="profile-card rounded-xl p-6 space-y-6">
        @csrf
        
        <!-- Avatar Upload -->
        <div class="text-center">
            <div class="relative inline-block">
                <img src="{{ asset('img/default-avatar.svg') }}" 
                     alt="Avatar" 
                     class="w-24 h-24 rounded-full border-4 border-white border-opacity-30 shadow-lg mx-auto"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center border-4 border-white border-opacity-30 shadow-lg mx-auto" style="display: none;">
                    <span class="text-white text-2xl font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                <label for="avatar" class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-2 cursor-pointer transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </label>
                <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*">
            </div>
        </div>

        <!-- Basic Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-white font-semibold mb-2 inter" for="name">Tên hiển thị</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ Auth::user()->name }}" 
                       class="w-full px-4 py-3 rounded-lg bg-white/20 text-white placeholder-blue-200 border border-white/30 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm" />
            </div>
            
            <div>
                <label class="block text-white font-semibold mb-2 inter" for="email">Email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ Auth::user()->email }}" 
                       class="w-full px-4 py-3 rounded-lg bg-white/20 text-white placeholder-blue-200 border border-white/30 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm" />
            </div>
        </div>

        <!-- Password Change -->
        <div class="border-t border-white/20 pt-6">
            <h4 class="orbitron text-lg font-bold text-white mb-4">Thay Đổi Mật Khẩu</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-white font-semibold mb-2 inter" for="current_password">Mật khẩu hiện tại</label>
                    <input type="password" 
                           id="current_password" 
                           name="current_password" 
                           class="w-full px-4 py-3 rounded-lg bg-white/20 text-white placeholder-blue-200 border border-white/30 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm" 
                           placeholder="••••••••" />
                </div>
                
                <div>
                    <label class="block text-white font-semibold mb-2 inter" for="new_password">Mật khẩu mới</label>
                    <input type="password" 
                           id="new_password" 
                           name="new_password" 
                           class="w-full px-4 py-3 rounded-lg bg-white/20 text-white placeholder-blue-200 border border-white/30 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm" 
                           placeholder="••••••••" />
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-white font-semibold mb-2 inter" for="confirm_password">Xác nhận mật khẩu mới</label>
                    <input type="password" 
                           id="confirm_password" 
                           name="password_confirmation" 
                           class="w-full px-4 py-3 rounded-lg bg-white/20 text-white placeholder-blue-200 border border-white/30 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent backdrop-blur-sm" 
                           placeholder="••••••••" />
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end space-x-4">
            <button type="button" class="px-6 py-3 bg-gray-500/20 text-white rounded-lg inter font-semibold hover:bg-gray-500/30 transition-all">
                Hủy
            </button>
            <button type="submit" class="glow-button px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-lg inter font-semibold hover:from-blue-600 hover:to-purple-700 transition-all">
                Lưu Thay Đổi
            </button>
        </div>
    </form>
</div>
@endsection