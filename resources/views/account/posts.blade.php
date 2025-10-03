@extends('layouts.account')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h3 class="orbitron text-xl font-bold text-white">Bài Viết Của Tôi</h3>
        <button class="glow-button bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inter font-semibold">
            + Viết Bài Mới
        </button>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="profile-card rounded-xl p-4 text-center">
            <div class="text-2xl mb-2">📝</div>
            <div class="orbitron text-xl font-bold text-white">0</div>
            <div class="inter text-gray-300 text-sm">Tổng bài viết</div>
        </div>
        <div class="profile-card rounded-xl p-4 text-center">
            <div class="text-2xl mb-2">👀</div>
            <div class="orbitron text-xl font-bold text-white">0</div>
            <div class="inter text-gray-300 text-sm">Lượt xem</div>
        </div>
        <div class="profile-card rounded-xl p-4 text-center">
            <div class="text-2xl mb-2">❤️</div>
            <div class="orbitron text-xl font-bold text-white">0</div>
            <div class="inter text-gray-300 text-sm">Lượt thích</div>
        </div>
    </div>

    <!-- Posts List -->
    <div class="profile-card rounded-xl p-6">
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📝</div>
            <h3 class="orbitron text-xl font-bold text-white mb-2">Chưa có bài viết nào</h3>
            <p class="inter text-gray-300 mb-6">Hãy bắt đầu chia sẻ suy nghĩ và kinh nghiệm âm nhạc của bạn!</p>
            <button class="glow-button bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-3 rounded-lg inter font-semibold">
                Viết Bài Đầu Tiên
            </button>
        </div>
    </div>
</div>
@endsection