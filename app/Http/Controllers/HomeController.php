<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index() { 
        // Render tat ca danh muc
        $categories = Category::with(['products' => function($query) {
            $query->where('status', 'active');
        }])->where('status', 1)->get();
        //Render tat ca san pham
        $products = Product::where('status', 'active')->get();
        
        //6 San pham moi nhat
        $newProducts = Product::where('status', 'active')->orderBy('created_at', 'desc')->take(6)->get();

        //6 San pham ban chay nhat
        $bestSellingProducts = Product::where('status', 'active')->orderBy('created_at', 'asc')->take(6)->get();

        //6 San pham nhieu luot xem nhat
        $viewedProducts = Product::where('status', 'active')->orderBy('created_at', 'desc')->take(6)->get();
        
        return view('home', compact('categories', 'newProducts', 'bestSellingProducts', 'viewedProducts'));   
    }
    public function show($id) {
        $product = Product::with(['images', 'variants'])->where('status', 'active')->findOrFail($id);
        
        // Tăng lượt xem (Tùy chọn, nếu muốn cập nhật db thêm lượt xem)
        // $product->increment('view_count');
        
        // Lấy các sản phẩm cùng danh mục (loại trừ sản phẩm hiện tại)
        $relatedProducts = Product::where('category_id', $product->category_id)
                                 ->where('product_id', '!=', $id)
                                 ->where('status', 'active')
                                 ->take(5)
                                 ->get();
                                 
        return view('product-detail', compact('product', 'relatedProducts'));
    }
}
