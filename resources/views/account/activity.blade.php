@extends('layouts.account')
@section('content')
            <div id="activity" class="tab-content active">
                <h3 class="orbitron text-xl font-bold text-white mb-6">Hoạt Động Gần Đây</h3>
                
                <div class="space-y-4">
                    @if($activities && $activities->count() > 0)
                        @foreach($activities as $activity)
                            <!-- Mua sheet nhạc -->
                            <div class="profile-card rounded-xl p-6 flex items-center space-x-4">
                                <div class="text-2xl">🎼</div>
                                <div class="flex-1">
                                    <h4 class="inter font-semibold text-white">Mua sheet nhạc</h4>
                                    <p class="inter text-gray-300 text-sm">
                                        Mua "{{ $activity->product->name }}" • 
                                        <span class="text-white font-semibold">{{ $activity->created_at->format('d/m/Y H:i') }}</span>
                                        <span class="text-blue-300">({{ $activity->created_at->diffForHumans() }})</span>
                                    </p>
                                </div>
                                <div class="text-red-400 font-bold">-{{ number_format($activity->product->price, 0, ',', '.') }} 🪙</div>
                            </div>
                        @endforeach
                        
                        <!-- Phân trang -->
                        <div class="mt-6">
                            {{ $activities->links() }}
                        </div>
                    @else
                        <!-- Không có hoạt động -->
                        <div class="profile-card rounded-xl p-6 text-center">
                            <div class="text-4xl mb-4">🎵</div>
                            <h4 class="inter font-semibold text-white mb-2">Chưa có hoạt động nào</h4>
                            <p class="inter text-gray-300 text-sm">Bạn chưa mua sheet nhạc nào. Hãy khám phá cửa hàng!</p>
                        </div>
                    @endif
                    
                    <!-- Demo activities (giữ lại một vài cái để trang trông đẹp hơn) -->
                    <div class="profile-card rounded-xl p-6 flex items-center space-x-4">
                        <div class="text-2xl">💰</div>
                        <div class="flex-1">
                            <h4 class="inter font-semibold text-white">Nạp Sky Coins</h4>
                            <p class="inter text-gray-300 text-sm">Nạp 50.000 Sky Coins qua Momo • 10 phút trước</p>
                        </div>
                        <div class="text-green-400 font-bold">+50.000 🪙</div>
                    </div>
                    <!-- Rút coin -->
                    <div class="profile-card rounded-xl p-6 flex items-center space-x-4">
                        <div class="text-2xl">🏧</div>
                        <div class="flex-1">
                            <h4 class="inter font-semibold text-white">Rút Sky Coins</h4>
                            <p class="inter text-gray-300 text-sm">Rút 20.000 Sky Coins về tài khoản ATM • 1 giờ trước</p>
                        </div>
                        <div class="text-red-400 font-bold">-20.000 🪙</div>
                    </div>
                    
                </div>
            </div>
@endsection