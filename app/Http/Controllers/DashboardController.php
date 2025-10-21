<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        $totalRevenue = Purchase::where('status', 'completed')
            ->sum('coins_spent');

        $totalOrders = Purchase::where('status', 'completed')->count();

        $totalUsers = User::count();

        $totalProducts = Product::where('is_active', 1)->count();

        $dailyRevenue = Purchase::where('status', 'completed')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(coins_spent) as total')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $monthlyRevenue = collect();
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $existing = $dailyRevenue->firstWhere('date', $date);

            $monthlyRevenue->push([
                'date' => $date,
                'total' => $existing ? $existing->total : 0
            ]);
        }

        $topProducts = Purchase::select('product_id', DB::raw('COUNT(*) as purchase_count'))
            ->where('status', 'completed')
            ->groupBy('product_id')
            ->orderBy('purchase_count', 'desc')
            ->limit(3)
            ->with('product')
            ->get();

        $recentOrders = Purchase::with(['user', 'product'])
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'totalUsers',
            'totalProducts',
            'monthlyRevenue',
            'topProducts',
            'recentOrders'
        ));
    }
}
