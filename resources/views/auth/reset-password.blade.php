@extends('layouts.app')

@section('title', 'Đặt lại mật khẩu - Sky Music Store')

@section('content')
<div id="reset-password" class="page-content">
    <section class="relative z-10 py-20 px-6">
        <div class="max-w-md mx-auto">
            <div class="game-card rounded-xl p-8">
                <h2 class="orbitron text-3xl font-bold text-white text-center mb-8">🔒 Đặt Lại Mật Khẩu</h2>
                
                {{-- Hiển thị lỗi --}}
                @if ($errors->any())
                    <div class="bg-red-500 bg-opacity-20 border border-red-500 text-red-100 px-4 py-3 rounded-lg mb-6 animate-fade-in">
                        @foreach ($errors->all() as $error)
                            <div>❌ {{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                
                <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token ?? '' }}">
                    
                    <div>
                        <label class="inter text-white block mb-2" for="email">Email</label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ $email ?? old('email') }}" 
                            readonly
                            required 
                            class="w-full p-3 rounded-lg bg-white bg-opacity-10 text-white placeholder-blue-200 border border-white border-opacity-30 cursor-not-allowed @error('email') border-red-500 @enderror" 
                            placeholder="Nhập email của bạn">
                        @error('email')
                            <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="inter text-white block mb-2" for="password">Mật khẩu mới</label>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            class="w-full p-3 rounded-lg bg-white bg-opacity-20 text-white placeholder-blue-200 border border-white border-opacity-30 focus:border-opacity-60 focus:outline-none transition @error('password') border-red-500 @enderror" 
                            placeholder="Nhập mật khẩu mới (tối thiểu 8 ký tự)">
                        @error('password')
                            <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-blue-200 text-xs mt-1">💡 Tối thiểu 8 ký tự</p>
                    </div>
                    
                    <div>
                        <label class="inter text-white block mb-2" for="password_confirmation">Xác nhận mật khẩu</label>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            class="w-full p-3 rounded-lg bg-white bg-opacity-20 text-white placeholder-blue-200 border border-white border-opacity-30 focus:border-opacity-60 focus:outline-none transition" 
                            placeholder="Nhập lại mật khẩu mới">
                    </div>
                    
                    <button 
                        type="submit" 
                        class="glow-button w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 rounded-full font-semibold hover:scale-105 transition-transform">
                        ✅ Đặt Lại Mật Khẩu
                    </button>
                </form>
                
                <div class="text-center mt-6">
                    <a href="{{ route('login') }}" class="inter text-blue-200 hover:text-white transition">
                        ← Quay lại đăng nhập
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }
</style>
@endsection