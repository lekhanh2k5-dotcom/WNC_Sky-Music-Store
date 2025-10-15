@extends('layouts.app')

@section('title', 'Quên mật khẩu')

@section('content')
<div id="forgot-password" class="page-content">
    <section class="relative z-10 py-20 px-6">
        <div class="max-w-md mx-auto">
            <div class="game-card rounded-xl p-8">
                <h2 class="orbitron text-3xl font-bold text-white text-center mb-8">🔑 Quên Mật Khẩu</h2>
                
                {{-- Hiển thị thông báo thành công --}}
                @if (session('status'))
                    <div class="bg-green-500 bg-opacity-20 border border-green-500 text-green-100 px-4 py-3 rounded-lg mb-6 animate-fade-in">
                        ✅ {{ session('status') }}
                    </div>
                @endif

                {{-- Hiển thị lỗi --}}
                @if ($errors->any())
                    <div class="bg-red-500 bg-opacity-20 border border-red-500 text-red-100 px-4 py-3 rounded-lg mb-6 animate-fade-in">
                        @foreach ($errors->all() as $error)
                            <div>❌ {{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                
                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="inter text-white block mb-2">Email</label>
                        <input 
                            type="email" 
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full p-3 rounded-lg bg-white bg-opacity-20 text-white placeholder-blue-200 border border-white border-opacity-30 focus:border-opacity-60 focus:outline-none transition @error('email') border-red-500 @enderror" 
                            placeholder="Nhập email của bạn"
                            required
                            autofocus>
                        @error('email')
                            <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button 
                        type="submit" 
                        class="glow-button w-full bg-gradient-to-r from-yellow-400 to-pink-500 text-white py-3 rounded-full font-semibold hover:scale-105 transition-transform">
                        📧 Gửi liên kết đặt lại mật khẩu
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