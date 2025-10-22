<nav class="relative z-10 p-6">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center backdrop-blur-sm">
                <span class="text-2xl music-note">🎵</span>
            </div>
            <h1 class="orbitron text-2xl font-bold text-white">Sky Music Store</h1>
        </div>
        
        <div class="hidden md:flex space-x-8 inter">
            <a href="{{ url('/') }}" class="nav-link text-white hover:text-yellow-300 transition-colors {{ request()->is('/') ? 'active' : '' }}">Trang Chủ</a>
            <a href="{{ url('/shop') }}" class="nav-link text-white hover:text-yellow-300 transition-colors {{ request()->is('shop') ? 'active' : '' }}">Shop</a>
            <a href="{{ url('/community') }}" class="nav-link text-white hover:text-yellow-300 transition-colors {{ request()->is('community') ? 'active' : '' }}">Cộng Đồng</a>
            <a href="{{ url('/support') }}" class="nav-link text-white hover:text-yellow-300 transition-colors {{ request()->is('support') ? 'active' : '' }}">Hỗ Trợ</a>
        </div>
        
        <div id="auth-section">
            @auth
                <div class="flex items-center space-x-4">
                    <a href="{{ route('account.sheets') }}" class="flex items-center space-x-2 hover:bg-white hover:bg-opacity-10 px-3 py-2 rounded-lg transition-all">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset(Auth::user()->avatar) }}" 
                                 alt="Avatar {{ Auth::user()->name }}" 
                                 class="w-10 h-10 rounded-full border-2 border-white border-opacity-50 object-cover shadow-lg">
                        @else
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center border-2 border-white border-opacity-50 shadow-lg">
                                <span class="text-white text-sm font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                        @endif
                        <div class="flex flex-col">
                            <span class="text-white inter text-sm font-medium">{{ Auth::user()->name }}</span>
                            <span class="text-blue-200 inter text-xs">Xem tài khoản</span>
                        </div>
                    </a>

                    @if(Auth::user()->is_admin)
                        <a href="{{ url('/admin') }}" class="bg-purple-500 bg-opacity-80 text-white px-4 py-2 rounded-lg hover:bg-opacity-100 transition-all inter">
                            👑 Admin
                        </a>
                    @endif

                        @if(request()->is('shop*'))
                            <span class="text-yellow-300 font-bold inter">💰 Xu: {{ Auth::user()->coins ?? 0 }}</span>
                            <a href="/shop/cart" class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-lg hover:bg-opacity-30 transition-all inter">
                                🛒 
                            </a>
                        @endif

                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-all inter">
                            Đăng Xuất
                        </button>
                    </form>
                </div>
            @else
                <div class="flex items-center space-x-4">
                 
                    <a href="{{ route('login') }}" class="bg-white bg-opacity-20 text-white px-6 py-2 rounded-full backdrop-blur-sm hover:bg-opacity-30 transition-all inter">
                        Đăng Nhập
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>