<!-- filepath: resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Dashboard Content -->
            <div id="dashboard" class="admin-content active px-6 pb-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="stat-card rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="inter text-gray-300 text-sm">Tổng Doanh Thu</p>
                                <p class="orbitron text-2xl font-bold text-white">{{ number_format($totalRevenue, 0, ',', '.') }} 🪙</p>
                            </div>
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                                <span class="text-xl">💰</span>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="inter text-gray-300 text-sm">Đơn Hàng</p>
                                <p class="orbitron text-2xl font-bold text-white">{{ number_format($totalOrders, 0, ',', '.') }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                                <span class="text-xl">🛒</span>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="inter text-gray-300 text-sm">Người Dùng</p>
                                <p class="orbitron text-2xl font-bold text-white">{{ number_format($totalUsers, 0, ',', '.') }}</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center">
                                <span class="text-xl">👥</span>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="inter text-gray-300 text-sm">Sheet Nhạc</p>
                                <p class="orbitron text-2xl font-bold text-white">{{ number_format($totalProducts, 0, ',', '.') }}</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                                <span class="text-xl">🎼</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <div class="admin-card rounded-xl p-6">
                        <h3 class="orbitron text-xl font-bold text-white mb-4">Doanh Thu Theo Ngày (30 ngày gần nhất)</h3>
                        <div class="h-64">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>

                    <div class="admin-card rounded-xl p-6">
                        <h3 class="orbitron text-xl font-bold text-white mb-4">Top Sheet Nhạc Bán Chạy</h3>
                        <div class="space-y-4">
                            @if($topProducts->count() > 0)
                                @foreach($topProducts as $index => $item)
                                    <div class="flex items-center justify-between p-3 bg-white bg-opacity-5 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <span class="text-2xl">
                                                @if($index == 0) 🥇
                                                @elseif($index == 1) 🥈
                                                @else 🥉
                                                @endif
                                            </span>
                                            <div>
                                                <p class="text-white font-semibold inter">{{ $item->product->name ?? 'N/A' }}</p>
                                                <p class="text-gray-300 text-sm inter">{{ $item->product->author ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <span class="text-green-400 font-bold inter">{{ $item->purchase_count }} lượt mua</span>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8">
                                    <p class="text-gray-300 inter">Chưa có dữ liệu bán hàng</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="admin-card rounded-xl p-6">
                    <h3 class="orbitron text-xl font-bold text-white mb-4">Đơn Hàng Gần Đây</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-white border-opacity-20">
                                    <th class="text-left py-3 text-gray-300 inter">ID</th>
                                    <th class="text-left py-3 text-gray-300 inter">Khách Hàng</th>
                                    <th class="text-left py-3 text-gray-300 inter">Sản Phẩm</th>
                                    <th class="text-left py-3 text-gray-300 inter">Giá</th>
                                    <th class="text-left py-3 text-gray-300 inter">Thời Gian</th>
                                    <th class="text-left py-3 text-gray-300 inter">Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($recentOrders->count() > 0)
                                    @foreach($recentOrders as $order)
                                        <tr class="table-row">
                                            <td class="py-3 text-white inter">#{{ $order->id }}</td>
                                            <td class="py-3 text-white inter">{{ $order->user->name ?? 'N/A' }}</td>
                                            <td class="py-3 text-white inter">{{ $order->product->name ?? 'N/A' }}</td>
                                            <td class="py-3 text-white inter">{{ number_format($order->coins_spent, 0, ',', '.') }} 🪙</td>
                                            <td class="py-3 text-white inter">{{ $order->created_at->diffForHumans() }}</td>
                                            <td class="py-3">
                                                @if($order->status == 'completed')
                                                    <span class="status-badge status-active">Hoàn thành</span>
                                                @elseif($order->status == 'pending')
                                                    <span class="status-badge status-pending">Đang xử lý</span>
                                                @else
                                                    <span class="status-badge status-inactive">{{ $order->status }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="py-8 text-center text-gray-300 inter">
                                            Chưa có đơn hàng nào
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Dữ liệu doanh thu từ Laravel
    const monthlyData = @json($monthlyRevenue);
    
    // Chuẩn bị dữ liệu cho biểu đồ
    const labels = monthlyData.map(item => {
        const date = new Date(item.date);
        const day = date.getDate();
        const month = date.getMonth() + 1;
        return `${day}/${month}`;
    });
    const data = monthlyData.map(item => item.total);
    
    // Tạo biểu đồ
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Doanh thu (Sky Coins)',
                data: data,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgb(59, 130, 246)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: '#fff',
                        font: {
                            family: 'Inter',
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: {
                        family: 'Inter',
                        size: 14
                    },
                    bodyFont: {
                        family: 'Inter',
                        size: 13
                    },
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return 'Doanh thu: ' + context.parsed.y.toLocaleString('vi-VN') + ' 🪙';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#9ca3af',
                        font: {
                            family: 'Inter',
                            size: 11
                        },
                        callback: function(value) {
                            return value.toLocaleString('vi-VN');
                        }
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                },
                x: {
                    ticks: {
                        color: '#9ca3af',
                        font: {
                            family: 'Inter',
                            size: 11
                        }
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                }
            }
        }
    });
</script>
@endpush