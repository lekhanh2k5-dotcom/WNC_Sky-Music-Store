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
        
        <!-- Kiểm tra trạng thái đăng nhập với Firebase -->
        <div id="auth-section">
            <!-- Hiển thị khi đã đăng nhập (ẩn mặc định) -->
            <div id="logged-in-section" class="hidden flex items-center space-x-4">
                <!-- Hiển thị ảnh đại diện -->
                <a href="/account" class="flex items-center space-x-2">
                    <img id="user-avatar" src="/img/default-avatar.svg" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-white">
                    <span id="user-name" class="text-white">User</span>
                </a>

                <!-- Hiển thị số xu và giỏ hàng trên trang Shop -->
                @if(request()->is('shop*'))
                    <span id="user-coins" class="text-yellow-300 font-bold">Xu: 0</span>
                    <a href="/shop/cart" class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-lg hover:bg-opacity-30 transition-all">
                        🛒 Giỏ Hàng
                    </a>
                @endif

                <!-- Nút Đăng Xuất -->
                <button id="logout-btn" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-all">
                    Đăng Xuất
                </button>
            </div>

            <!-- Hiển thị khi chưa đăng nhập (hiển thị mặc định) -->
            <div id="logged-out-section">
                <a href="{{ route('login') }}" class="bg-white bg-opacity-20 text-white px-6 py-2 rounded-full backdrop-blur-sm hover:bg-opacity-30 transition-all inter">
                    Đăng Nhập
                </a>
            </div>
        </div>
    </div>
</nav>

<script type="module">
    try {
        // Import Firebase auth từ config file
        const { auth } = await import('/js/firebase-config.js');
        const { onAuthStateChanged, signOut } = await import('https://www.gstatic.com/firebasejs/10.1.0/firebase-auth.js');

        console.log('Firebase modules loaded successfully');

        // Kiểm tra trạng thái đăng nhập
        onAuthStateChanged(auth, (user) => {
            console.log('Auth state changed:', user ? 'logged in' : 'logged out');
            
            const loggedInSection = document.getElementById('logged-in-section');
            const loggedOutSection = document.getElementById('logged-out-section');
            
            if (!loggedInSection || !loggedOutSection) {
                console.error('Auth sections not found in DOM');
                return;
            }
            
            if (user) {
                // Người dùng đã đăng nhập
                console.log('User logged in:', user.email);
                
                // Ẩn nút đăng nhập
                loggedOutSection.style.display = 'none';
                loggedOutSection.classList.add('hidden');
                
                // Hiển thị section đã đăng nhập
                loggedInSection.style.display = 'flex';
                loggedInSection.classList.remove('hidden');
                loggedInSection.classList.add('flex');
                
                // Cập nhật thông tin user
                const userNameEl = document.getElementById('user-name');
                const userAvatarEl = document.getElementById('user-avatar');
                
                if (userNameEl) {
                    userNameEl.textContent = user.displayName || user.email.split('@')[0];
                }
                if (userAvatarEl) {
                    userAvatarEl.src = user.photoURL || '/img/default-avatar.png';
                }
                
                // Lấy thông tin coins từ Firestore nếu cần
                // fetchUserCoins(user.uid);
                
            } else {
                // Người dùng chưa đăng nhập
                console.log('User logged out');
                
                // Ẩn section đã đăng nhập
                loggedInSection.style.display = 'none';
                loggedInSection.classList.add('hidden');
                loggedInSection.classList.remove('flex');
                
                // Hiển thị nút đăng nhập
                loggedOutSection.style.display = 'block';
                loggedOutSection.classList.remove('hidden');
            }
        });

        // Xử lý đăng xuất - đợi DOM load xong
        document.addEventListener('DOMContentLoaded', () => {
            const logoutBtn = document.getElementById('logout-btn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', async (e) => {
                    e.preventDefault();
                    try {
                        console.log('Logging out...');
                        await signOut(auth);
                        console.log('Logged out successfully');
                        // Không cần redirect vì onAuthStateChanged sẽ tự động update UI
                    } catch (error) {
                        console.error('Lỗi đăng xuất:', error);
                        alert('Có lỗi khi đăng xuất. Vui lòng thử lại.');
                    }
                });
            }
        });

        // Nếu DOM đã load rồi thì gán event ngay
        if (document.readyState === 'loading') {
            // DOM chưa load xong
        } else {
            // DOM đã load xong
            const logoutBtn = document.getElementById('logout-btn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', async (e) => {
                    e.preventDefault();
                    try {
                        console.log('Logging out...');
                        await signOut(auth);
                        console.log('Logged out successfully');
                    } catch (error) {
                        console.error('Lỗi đăng xuất:', error);
                        alert('Có lỗi khi đăng xuất. Vui lòng thử lại.');
                    }
                });
            }
        }

    } catch (error) {
        console.error('Firebase initialization error:', error);
        
        // Fallback: hiển thị nút đăng nhập nếu Firebase lỗi
        const loggedOutSection = document.getElementById('logged-out-section');
        const loggedInSection = document.getElementById('logged-in-section');
        
        if (loggedOutSection) {
            loggedOutSection.style.display = 'block';
            loggedOutSection.classList.remove('hidden');
        }
        if (loggedInSection) {
            loggedInSection.style.display = 'none';
            loggedInSection.classList.add('hidden');
        }
        
        // Hiển thị thông báo lỗi cho dev
        console.error('Vui lòng kiểm tra cấu hình Firebase trong /js/firebase-config.js');
    }
</script>