@extends('layouts.account')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="orbitron text-3xl font-bold text-white mb-8 text-center drop-shadow">⚙️ Cài Đặt Tài Khoản</h1>
    
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
    
    @if ($errors->any())
        <div class="mb-6 bg-red-500 text-white px-6 py-3 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('account.settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white/30 backdrop-blur-lg rounded-2xl shadow-xl p-8 space-y-6 border border-white/20">
        @csrf
        
        <!-- Ảnh đại diện -->
        <div class="border-b border-white/20 pb-4">
            <h2 class="text-xl font-bold text-white mb-4">📸 Ảnh đại diện</h2>
            
            <div class="flex items-center gap-6">
                <div class="relative">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                    @else
                        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center border-4 border-white shadow-lg">
                            <span class="text-white text-3xl font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                    @endif
                </div>
                
                <div class="flex-1">
                    <label class="block text-white font-semibold mb-2" for="avatar">Chọn ảnh mới</label>
                    <input 
                        type="file" 
                        id="avatar" 
                        name="avatar" 
                        accept="image/*"
                        class="w-full text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-500 file:text-white hover:file:bg-blue-600 file:cursor-pointer cursor-pointer"
                    />
                    <p class="text-xs text-gray-200 mt-1">* Chấp nhận: JPG, PNG, GIF (Tối đa 2MB)</p>
                </div>
            </div>
        </div>
        
        <!-- Thông tin cơ bản -->
        <div class="border-b border-white/20 pb-4">
            <h2 class="text-xl font-bold text-white mb-4">📋 Thông tin cơ bản</h2>
            
            <div class="mb-4">
                <label class="block text-white font-semibold mb-2" for="name">Tên hiển thị</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', Auth::user()->name) }}" 
                    required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 outline-none" 
                    placeholder="Nhập tên của bạn"
                />
            </div>
            
            <div>
                <label class="block text-white font-semibold mb-2" for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email', Auth::user()->email) }}" 
                    required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 outline-none" 
                    placeholder="email@example.com"
                />
            </div>
        </div>
        
        <!-- Đổi mật khẩu -->
        <div class="border-b border-white/20 pb-4">
            <h2 class="text-xl font-bold text-white mb-4">🔒 Đổi mật khẩu</h2>
            <p class="text-gray-200 text-sm mb-4">* Để trống nếu không muốn đổi mật khẩu</p>
            
            <div class="mb-4">
                <label class="block text-white font-semibold mb-2" for="current_password">Mật khẩu hiện tại</label>
                <input 
                    type="password" 
                    id="current_password" 
                    name="current_password" 
                    placeholder="••••••••" 
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 outline-none" 
                />
            </div>
            
            <div class="mb-4">
                <label class="block text-white font-semibold mb-2" for="new_password">Mật khẩu mới</label>
                <input 
                    type="password" 
                    id="new_password" 
                    name="new_password" 
                    placeholder="••••••••" 
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 outline-none" 
                />
                <p class="text-xs text-gray-200 mt-1">* Tối thiểu 6 ký tự</p>
            </div>
            
            <div>
                <label class="block text-white font-semibold mb-2" for="new_password_confirmation">Xác nhận mật khẩu mới</label>
                <input 
                    type="password" 
                    id="new_password_confirmation" 
                    name="new_password_confirmation" 
                    placeholder="••••••••" 
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-400 outline-none" 
                />
            </div>
        </div>
        
        <!-- Thông tin tài khoản -->
        <div class="bg-white/20 rounded-lg p-4">
            <h3 class="text-lg font-bold text-white mb-2">💰 Thông tin tài khoản</h3>
            <div class="grid grid-cols-2 gap-4 text-white">
                <div>
                    <p class="text-sm text-gray-200">Số dư xu:</p>
                    <p class="text-2xl font-bold text-yellow-300">{{ number_format(Auth::user()->coins ?? 0, 0, ',', '.') }} 🪙</p>
                </div>
                <div>
                    <p class="text-sm text-gray-200">Ngày tham gia:</p>
                    <p class="text-lg font-semibold">{{ Auth::user()->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
        
        <!-- Nút hành động -->
        <div class="flex justify-end gap-4 pt-4">
            <a href="{{ route('account.sheets') }}" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition">
                Hủy
            </a>
            <button type="submit" class="px-5 py-2 rounded-lg bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold hover:from-blue-600 hover:to-purple-600 transition shadow-lg">
                💾 Lưu thay đổi
            </button>
        </div>
    </form>
</div>

<script>
// Preview ảnh trước khi upload
document.getElementById('avatar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const imgContainer = document.querySelector('.relative');
            imgContainer.innerHTML = `<img src="${event.target.result}" alt="Preview" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">`;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
