@extends('layouts.account')
@section('content')
            <div id="activity" class="tab-content active">
                <h3 class="orbitron text-xl font-bold text-white mb-6">Hoạt Động Gần Đây</h3>
                
                <div class="space-y-4">
                    @if($activities && $activities->count() > 0)
                        @foreach($activities as $activity)
                            @if($activity->activity_type === 'purchase')
                                <!-- Mua sheet nhạc -->
                                <div class="profile-card rounded-xl p-6 flex items-center space-x-4">
                                    <div class="text-2xl">🎼</div>
                                    <div class="flex-1">
                                        <h4 class="inter font-semibold text-white">Mua sheet nhạc</h4>
                                        <p class="inter text-gray-300 text-sm">
                                            Mua "{{ $activity->product->name ?? 'Sheet nhạc' }}" • 
                                            <span class="text-white font-semibold">{{ $activity->created_at->format('d/m/Y H:i') }}</span>
                                            <span class="text-blue-300">({{ $activity->created_at->diffForHumans() }})</span>
                                        </p>
                                    </div>
                                    <div class="text-red-400 font-bold">-{{ number_format($activity->coins_spent ?? 0, 0, ',', '.') }} 🪙</div>
                                </div>
                            @elseif($activity->activity_type === 'coin' && $activity->type === 'deposit')
                                <!-- Nạp xu -->
                                <div class="profile-card rounded-xl p-6 flex items-center space-x-4">
                                    <div class="text-2xl">💰</div>
                                    <div class="flex-1">
                                        <h4 class="inter font-semibold text-white">Nạp Sky Coins</h4>
                                        <p class="inter text-gray-300 text-sm">
                                            Nạp {{ number_format($activity->coins, 0, ',', '.') }} Sky Coins qua {{ ucfirst($activity->payment_method ?? 'N/A') }} • 
                                            <span class="text-white font-semibold">{{ $activity->created_at->format('d/m/Y H:i') }}</span>
                                            <span class="text-blue-300">({{ $activity->created_at->diffForHumans() }})</span>
                                        </p>
                                    </div>
                                    <div class="text-green-400 font-bold">+{{ number_format($activity->coins, 0, ',', '.') }} 🪙</div>
                                </div>
                            @elseif($activity->activity_type === 'coin' && $activity->type === 'withdraw')
                                <!-- Rút xu -->
                                <div class="profile-card rounded-xl p-6 flex items-center space-x-4">
                                    <div class="text-2xl">🏧</div>
                                    <div class="flex-1">
                                        <h4 class="inter font-semibold text-white">Rút Sky Coins</h4>
                                        <p class="inter text-gray-300 text-sm">
                                            Rút {{ number_format($activity->coins, 0, ',', '.') }} Sky Coins về tài khoản {{ ucfirst($activity->payment_method ?? 'ATM') }} • 
                                            <span class="text-white font-semibold">{{ $activity->created_at->format('d/m/Y H:i') }}</span>
                                            <span class="text-blue-300">({{ $activity->created_at->diffForHumans() }})</span>
                                        </p>
                                    </div>
                                    <div class="text-red-400 font-bold">-{{ number_format($activity->coins, 0, ',', '.') }} 🪙</div>
                                </div>
                            @endif
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
                            <p class="inter text-gray-300 text-sm">Bạn chưa có giao dịch nào. Hãy khám phá cửa hàng!</p>
                        </div>
                    @endif
                </div>
            </div>
@endsection