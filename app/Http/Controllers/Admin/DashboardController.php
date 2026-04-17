<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $productsCount = Product::count();
        $categoriesCount = Category::count();
        $ordersCount = Order::count();
        $totalRevenue = Order::whereIn('order_status', ['paid', 'completed'])->sum('total_amount');

        $revenueData = Order::where('created_at', '>=', now()->subMonths(5)->startOfMonth())
            ->selectRaw("substr(strftime('%B', created_at), 1, 3) as month, SUM(total_amount) as total")
            ->groupBy('month')
            ->orderByRaw('MIN(created_at)')
            ->pluck('total', 'month')
            ->toArray();

        $revenueChartData = [
            'labels' => array_keys($revenueData),
            'data' => array_values($revenueData),
        ];

        $statusData = Order::select('order_status', DB::raw('count(*) as total'))
            ->groupBy('order_status')
            ->pluck('total', 'order_status')
            ->toArray();

        $orderStatusChartData = [
            'labels' => ['completed', 'processing', 'shipped', 'paid', 'pending', 'cancelled', 'failed'],
            'data' => [
                $statusData['completed'] ?? 0,
                $statusData['processing'] ?? 0,
                $statusData['shipped'] ?? 0,
                $statusData['paid'] ?? 0,
                $statusData['pending'] ?? 0,
                $statusData['cancelled'] ?? 0,
                $statusData['failed'] ?? 0,
            ],
        ];

        return view('admin.dashboard', compact(
            'usersCount', 'productsCount', 'categoriesCount',
            'ordersCount', 'totalRevenue',
            'revenueChartData', 'orderStatusChartData'
        ));
    }
}
