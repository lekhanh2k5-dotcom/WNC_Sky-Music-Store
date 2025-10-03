@extends('layouts.app')

@section('title', 'Đăng ký - Sky Music Store')

@section('content')
<div id="register" class="page-content">
    <section class="relative z-10 py-20 px-6">
        <div class="max-w-md mx-auto">
            <div class="game-card rounded-xl p-8">
                <h2 class="orbitron text-3xl font-bold text-white text-center mb-8">🎵 Đăng Ký</h2>
                
                @if ($errors->any())
                    <div class="bg-red-500 bg-opacity-20 border border-red-500 text-red-100 p-4 rounded-lg mb-6">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('register.submit') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="inter text-white block mb-2">Họ và tên</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full p-3 rounded-lg bg-white bg-opacity-20 text-white placeholder-blue-200 border border-white border-opacity-30 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Nhập họ và tên của bạn" required>
                    </div>
                    <div>
                        <label class="inter text-white block mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full p-3 rounded-lg bg-white bg-opacity-20 text-white placeholder-blue-200 border border-white border-opacity-30 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Nhập email của bạn" required>
                    </div>
                    <div>
                        <label class="inter text-white block mb-2">Mật khẩu</label>
                        <input type="password" name="password" class="w-full p-3 rounded-lg bg-white bg-opacity-20 text-white placeholder-blue-200 border border-white border-opacity-30 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Nhập mật khẩu (tối thiểu 8 ký tự)" required>
                    </div>
                    <div>
                        <label class="inter text-white block mb-2">Xác nhận mật khẩu</label>
                        <input type="password" name="password_confirmation" class="w-full p-3 rounded-lg bg-white bg-opacity-20 text-white placeholder-blue-200 border border-white border-opacity-30 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Nhập lại mật khẩu" required>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="terms" id="terms" class="mr-2 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" required>
                        <label for="terms" class="inter text-sm text-blue-200">
                            Tôi đồng ý với <a href="#" class="text-yellow-300 hover:text-yellow-200">điều khoản sử dụng</a> và <a href="#" class="text-yellow-300 hover:text-yellow-200">chính sách bảo mật</a>
                        </label>
                    </div>
                    <button type="submit" class="glow-button w-full bg-gradient-to-r from-purple-500 to-pink-600 text-white py-3 rounded-full font-semibold hover:from-purple-600 hover:to-pink-700 transition-all">Đăng Ký</button>
                </form>
                
                <div class="text-center mt-6">
                    <p class="inter text-blue-200">Đã có tài khoản? <a href="{{ route('login') }}" class="text-yellow-300 hover:text-yellow-200">Đăng nhập ngay</a></p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection