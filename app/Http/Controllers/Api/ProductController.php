<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json(
            [
                "status" => "success",
                "data" => $products,
            ],
            200,
        );
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(
                ["message" => "Khong tim thay san pham"],
                400,
            );
        }
        return response()->json($product, 200);
    }
}
