<!-- filepath: resources/views/admin/products.blade.php -->
@extends('layouts.admin')

@section('title', 'Quản Lý Giao Dịch')

@section('content')
<div id="transactions" class="admin-content active px-6 pb-6">
    <div class="admin-card rounded-xl p-6">
        <h3 class="orbitron text-2xl font-bold text-white mb-6">Quản Lý Giao Dịch</h3>
        <!-- Tabs -->
        <div class="flex border-b border-white border-opacity-20 mb-6">
            <button id="tab-orders-btn" onclick="showTabOrders('orders')"
                class="tab-btn px-6 py-2 -mb-px border-b-2 border-blue-500 text-white font-semibold focus:outline-none transition-colors duration-200 bg-transparent hover:bg-blue-900 hover:bg-opacity-30"
                style="border-radius: 8px 8px 0 0;">
                Đơn hàng
            </button>
            <button id="tab-deposit-btn" onclick="showTabOrders('deposit')"
                class="tab-btn px-6 py-2 -mb-px border-b-2 border-transparent text-white font-semibold focus:outline-none transition-colors duration-200 bg-transparent hover:bg-blue-900 hover:bg-opacity-30"
                style="border-radius: 8px 8px 0 0;">
                Nạp xu
            </button>
            <button id="tab-withdraw-btn" onclick="showTabOrders('withdraw')"
                class="tab-btn px-6 py-2 -mb-px border-b-2 border-transparent text-white font-semibold focus:outline-none transition-colors duration-200 bg-transparent hover:bg-blue-900 hover:bg-opacity-30"
                style="border-radius: 8px 8px 0 0;">
                Rút xu
            </button>
        </div>
        <!-- Đơn hàng -->
        <div id="tab-orders" class="tab-content">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white border-opacity-20">
                            <th class="text-left py-3 text-gray-300 inter">ID Đơn</th>
                            <th class="text-left py-3 text-gray-300 inter">Khách Hàng</th>
                            <th class="text-left py-3 text-gray-300 inter">Sản Phẩm</th>
                            <th class="text-left py-3 text-gray-300 inter">Số Xu</th>
                            <th class="text-left py-3 text-gray-300 inter">Ngày Mua</th>
                            <th class="text-left py-3 text-gray-300 inter">Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($orders->count() > 0)
                            @foreach($orders as $order)
                                <tr class="table-row">
                                    <td class="py-4 text-white inter font-mono">#{{ $order->id }}</td>
                                    <td class="py-4">
                                        <div>
                                            <p class="text-white inter">{{ $order->user->name ?? 'N/A' }}</p>
                                            <p class="text-gray-300 text-sm inter">{{ $order->user->email ?? 'N/A' }}</p>
                                        </div>
                                    </td>
                                    <td class="py-4 text-white inter">
                                        <span class="inline-block bg-blue-600 bg-opacity-20 text-blue-200 px-3 py-1 rounded-full text-sm">
                                            {{ $order->product->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="py-4 text-white inter font-semibold">{{ number_format($order->coins_spent, 0, ',', '.') }} 🪙</td>
                                    <td class="py-4 text-white inter">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="py-4">
                                        @if($order->status == 'completed')
                                            <span class="status-badge status-active">Hoàn thành</span>
                                        @elseif($order->status == 'pending')
                                            <span class="status-badge status-pending">Chờ xử lý</span>
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
                
                <!-- Pagination -->
                @if($orders->count() > 0)
                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
        <!-- Nạp xu -->
        <div id="tab-deposit" class="tab-content hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white border-opacity-20">
                            <th class="text-left py-3 text-gray-300 inter">ID Giao Dịch</th>
                            <th class="text-left py-3 text-gray-300 inter">Người Nạp</th>
                            <th class="text-left py-3 text-gray-300 inter">Số Xu</th>
                            <th class="text-left py-3 text-gray-300 inter">Thời Gian</th>
                            <th class="text-left py-3 text-gray-300 inter">Trạng Thái</th>
                            <th class="text-left py-3 text-gray-300 inter">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="table-row">
                            <td class="py-4 text-white inter font-mono">#DEP-1001</td>
                            <td class="py-4 text-white inter">user123</td>
                            <td class="py-4 text-white inter">500</td>
                            <td class="py-4 text-white inter">12/09/2025 10:30</td>
                            <td class="py-4"><span class="status-badge status-pending">Chờ duyệt</span></td>
                            <td class="py-4">
                                <button class="bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded text-white text-sm">Duyệt</button>
                                <button class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-white text-sm">Từ chối</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Rút xu -->
        <div id="tab-withdraw" class="tab-content hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white border-opacity-20">
                            <th class="text-left py-3 text-gray-300 inter">ID Giao Dịch</th>
                            <th class="text-left py-3 text-gray-300 inter">Người Rút</th>
                            <th class="text-left py-3 text-gray-300 inter">Số Xu</th>
                            <th class="text-left py-3 text-gray-300 inter">Thời Gian</th>
                            <th class="text-left py-3 text-gray-300 inter">Trạng Thái</th>
                            <th class="text-left py-3 text-gray-300 inter">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="table-row">
                            <td class="py-4 text-white inter font-mono">#WDR-2001</td>
                            <td class="py-4 text-white inter">user456</td>
                            <td class="py-4 text-white inter">300</td>
                            <td class="py-4 text-white inter">12/09/2025 11:00</td>
                            <td class="py-4"><span class="status-badge status-pending">Chờ duyệt</span></td>
                            <td class="py-4">
                                <button class="bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded text-white text-sm">Duyệt</button>
                                <button class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-white text-sm">Từ chối</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
function showTabOrders(tab) {
    const ordersTab = document.getElementById('tab-orders');
    const depositTab = document.getElementById('tab-deposit');
    const withdrawTab = document.getElementById('tab-withdraw');
    const btnOrders = document.getElementById('tab-orders-btn');
    const btnDeposit = document.getElementById('tab-deposit-btn');
    const btnWithdraw = document.getElementById('tab-withdraw-btn');
    if (tab === 'orders') {
        ordersTab.classList.remove('hidden');
        depositTab.classList.add('hidden');
        withdrawTab.classList.add('hidden');
        btnOrders.classList.add('border-blue-500');
        btnOrders.classList.remove('border-transparent');
        btnDeposit.classList.add('border-transparent');
        btnDeposit.classList.remove('border-blue-500');
        btnWithdraw.classList.add('border-transparent');
        btnWithdraw.classList.remove('border-blue-500');
    } else if (tab === 'deposit') {
        ordersTab.classList.add('hidden');
        depositTab.classList.remove('hidden');
        withdrawTab.classList.add('hidden');
        btnOrders.classList.add('border-transparent');
        btnOrders.classList.remove('border-blue-500');
        btnDeposit.classList.add('border-blue-500');
        btnDeposit.classList.remove('border-transparent');
        btnWithdraw.classList.add('border-transparent');
        btnWithdraw.classList.remove('border-blue-500');
    } else {
        ordersTab.classList.add('hidden');
        depositTab.classList.add('hidden');
        withdrawTab.classList.remove('hidden');
        btnOrders.classList.add('border-transparent');
        btnOrders.classList.remove('border-blue-500');
        btnDeposit.classList.add('border-transparent');
        btnDeposit.classList.remove('border-blue-500');
        btnWithdraw.classList.add('border-blue-500');
        btnWithdraw.classList.remove('border-transparent');
    }
}
</script>
@endsection