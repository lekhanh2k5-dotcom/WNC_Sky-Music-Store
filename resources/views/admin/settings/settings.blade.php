<!-- filepath: resources/views/admin/products.blade.php -->
@extends('layouts.admin')

@section('title', 'Cài Đặt')

@section('content')
 <!-- About Project -->
            <div id="settings" class="admin-content active px-6 pb-6">
                <div class="admin-card rounded-xl p-6">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <div class="inline-block bg-gradient-to-r from-blue-500 to-purple-500 rounded-full p-4 mb-4">
                            <span class="text-5xl">🎼</span>
                        </div>
                        <h3 class="orbitron text-3xl font-bold text-white mb-2">Sky Music Store</h3>
                        <p class="inter text-gray-300">Nền tảng mua bán sheet nhạc trực tuyến</p>
                    </div>

                    <!-- Project Info -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <!-- About -->
                        <div class="admin-card rounded-xl p-6">
                            <h4 class="orbitron text-xl font-bold text-white mb-4 flex items-center">
                                <span class="text-2xl mr-3">📖</span>
                                Về Dự Án
                            </h4>
                            <div class="space-y-3 inter text-gray-300">
                                <p><strong class="text-white">Tên dự án:</strong> Sky Music Store</p>
                                <p><strong class="text-white">Mô tả:</strong> Website thương mại điện tử chuyên về mua bán sheet nhạc</p>
                                <p><strong class="text-white">Năm thực hiện:</strong> 2025</p>
                                <p><strong class="text-white">Môn học:</strong> Lập trình Web nâng cao</p>
                            </div>
                        </div>

                        <!-- Tech Stack -->
                        <div class="admin-card rounded-xl p-6">
                            <h4 class="orbitron text-xl font-bold text-white mb-4 flex items-center">
                                <span class="text-2xl mr-3">⚙️</span>
                                Công Nghệ Sử Dụng
                            </h4>
                            <div class="space-y-2">
                                <div class="flex items-center space-x-3 inter text-gray-300">
                                    <span class="text-xl">🐘</span>
                                    <span><strong class="text-white">Backend:</strong> Laravel 11</span>
                                </div>
                                <div class="flex items-center space-x-3 inter text-gray-300">
                                    <span class="text-xl">🎨</span>
                                    <span><strong class="text-white">Frontend:</strong> Blade, Tailwind CSS, Alpine.js</span>
                                </div>
                                <div class="flex items-center space-x-3 inter text-gray-300">
                                    <span class="text-xl">🗄️</span>
                                    <span><strong class="text-white">Database:</strong> MySQL</span>
                                </div>
                                <div class="flex items-center space-x-3 inter text-gray-300">
                                    <span class="text-xl">📊</span>
                                    <span><strong class="text-white">Charts:</strong> Chart.js</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="admin-card rounded-xl p-6 mb-8">
                        <h4 class="orbitron text-xl font-bold text-white mb-4 flex items-center">
                            <span class="text-2xl mr-3">✨</span>
                            Tính Năng Chính
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-start space-x-3">
                                <span class="text-xl">🎵</span>
                                <div>
                                    <p class="text-white font-semibold inter">Quản lý Sheet Nhạc</p>
                                    <p class="text-gray-300 text-sm inter">Thêm, sửa, xóa sheet nhạc với preview file</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <span class="text-xl">🛒</span>
                                <div>
                                    <p class="text-white font-semibold inter">Giỏ Hàng & Thanh Toán</p>
                                    <p class="text-gray-300 text-sm inter">Mua hàng với hệ thống Sky Coins</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <span class="text-xl">👥</span>
                                <div>
                                    <p class="text-white font-semibold inter">Quản lý Người Dùng</p>
                                    <p class="text-gray-300 text-sm inter">Xem danh sách user và quản lý tài khoản</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <span class="text-xl">📊</span>
                                <div>
                                    <p class="text-white font-semibold inter">Dashboard Analytics</p>
                                    <p class="text-gray-300 text-sm inter">Thống kê doanh thu, đơn hàng với biểu đồ</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <span class="text-xl"></span>
                                <div>
                                    <p class="text-white font-semibold inter">Xác Thực & Phân Quyền</p>
                                    <p class="text-gray-300 text-sm inter">Login/Register với middleware admin</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Team -->
                    <div class="admin-card rounded-xl p-6 mb-8">
                        <h4 class="orbitron text-xl font-bold text-white mb-4 flex items-center">
                            <span class="text-2xl mr-3">👥</span>
                            Nhóm Phát Triển
                        </h4>
                
                        <!-- Team Members -->
                        <div class="space-y-4 mb-6">
                            <div class="flex items-center space-x-4 p-4 bg-white/5 rounded-lg border border-white/10">
                                <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                                    K
                                </div>
                                <div>
                                    <p class="text-lg font-semibold text-white inter">Lê Ngọc Khánh</p>
                                    <p class="text-gray-300 inter">MSV: 23010546</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-4 p-4 bg-white/5 rounded-lg border border-white/10">
                                <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                                    T
                                </div>
                                <div>
                                    <p class="text-lg font-semibold text-white inter">Nguyễn Anh Tài</p>
                                    <p class="text-gray-300 inter">MSV: 23010584</p>
                                </div>
                            </div>
                        </div>
                
                        <!-- Course Info -->
                        <div class="border-t border-white/10 pt-6">
                            <div class="space-y-3 inter">
                                <p class="flex items-start text-gray-300">
                                    <span class="text-white font-semibold mr-2">📚 Lớp học:</span>
                                    <span>Thiết kế web nâng cao-1-1-25 (COUR01.TH3)</span>
                                </p>
                                <p class="flex items-start text-gray-300">
                                    <span class="text-white font-semibold mr-2">🏫 Trường:</span>
                                    <span>Công nghệ thông tin - Đại học Phenikaa</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="text-center mt-8 inter text-gray-400">
                        <p>© 2025 Sky Music Store. All rights reserved.</p>
                        <p class="text-sm mt-2">Version 1.0.0</p>
                    </div>
                </div>
            </div>
@endsection