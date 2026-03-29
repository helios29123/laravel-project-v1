<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Dữ liệu động
        $usersCount = class_exists(User::class) ? User::count() : 0;
        $productsCount = class_exists(Product::class) ? Product::count() : 0;
        $categoriesCount = class_exists(Category::class) ? Category::count() : 0;
        
        // 2. Dữ liệu tĩnh (Fake Data chờ ngày mai code)
        $ordersCount = 120; // 120 đơn hàng
        $totalRevenue = 45000000; // 45M VND

        $revenueChartData = [
            'labels' => ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
            'data' => [12000000, 19000000, 15000000, 25000000, 22000000, 45000000],
        ];

        $orderStatusChartData = [
            'labels' => ['Hoàn thành', 'Đang giao', 'Đã hủy'],
            'data' => [75, 20, 5],
        ];

        return view('admin.dashboard', compact(
            'usersCount', 'productsCount', 'categoriesCount', 
            'ordersCount', 'totalRevenue', 
            'revenueChartData', 'orderStatusChartData'
        ));
    }
}
