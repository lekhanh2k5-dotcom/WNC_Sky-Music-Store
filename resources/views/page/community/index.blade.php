@extends('layouts.app')

@section('title', 'Cộng đồng - Sky Music Store')

@section('content')
<div id="community" class="page-content">
        <section class="relative z-10 py-20 px-6">
            <div class="max-w-6xl mx-auto">
                <h2 class="orbitron text-5xl font-bold text-white text-center mb-16">🌟 Cộng Đồng Sky Music</h2>
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Discord -->
                    <div class="game-card rounded-xl p-8 text-center">
                        <div class="w-20 h-20 bg-indigo-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <span class="text-4xl">💬</span>
                        </div>
                        <h3 class="orbitron text-2xl font-bold text-white mb-4">Discord Server</h3>
                        <p class="inter text-blue-100 mb-6">Tham gia server Discord với hơn 5000 thành viên yêu nhạc Sky</p>
                        <button class="glow-button bg-indigo-600 text-white px-6 py-3 rounded-full font-semibold">Tham Gia Discord</button>
                    </div>

                    <!-- Facebook Group -->
                    <div class="game-card rounded-xl p-8 text-center">
                        <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <span class="text-4xl">👥</span>
                        </div>
                        <h3 class="orbitron text-2xl font-bold text-white mb-4">Facebook Group</h3>
                        <p class="inter text-blue-100 mb-6">Chia sẻ video cover, thảo luận về sheet nhạc mới</p>
                        <button class="glow-button bg-blue-600 text-white px-6 py-3 rounded-full font-semibold">Tham Gia Group</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
<!-- No JS needed: like/comment are static -->
@endsection