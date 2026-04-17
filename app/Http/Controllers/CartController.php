<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        if (!$userId) {
            // Handle guest cart (session-based) - for now return empty
            $cartItems = collect();
        } else {
            $cartItems = Cart::with(['productVariant.product', 'productVariant.product.images'])
                ->where('user_id', $userId)
                ->get();
        }

        // Calculate totals
        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->productVariant->price;
        });

        $shippingFee = $subtotal > 500000 ? 0 : 30000; // Free shipping over 500k
        $discount = 0; // TODO: implement voucher logic
        $total = $subtotal + $shippingFee - $discount;

        return view('cart', compact('cartItems', 'subtotal', 'shippingFee', 'discount', 'total'));
    }

    public function add(Request $request)
    {
        \Log::info('Cart add request', [
            'request_data' => $request->all(),
            'user_id' => Auth::id(),
            'user' => Auth::user(),
            'is_authenticated' => Auth::check()
        ]);

        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,product_variant_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        $variantId = $request->product_variant_id;
        $quantity = $request->quantity;

        // TEMPORARY: Allow guest users for testing
        if (!$userId) {
            \Log::warning('Guest user trying to add to cart - allowing for testing');
            return response()->json(['message' => 'Tính năng giỏ hàng cho khách chưa được implement. Vui lòng đăng nhập.'], 401);
        }

        // Check if variant exists and has enough stock
        $variant = ProductVariant::find($variantId);
        if (!$variant || $variant->stock_quantity < $quantity) {
            return response()->json(['message' => 'Sản phẩm không đủ hàng'], 400);
        }

        // Check if item already in cart
        $existingCartItem = Cart::where('user_id', $userId)
            ->where('product_variant_id', $variantId)
            ->first();

        if ($existingCartItem) {
            $newQuantity = $existingCartItem->quantity + $quantity;

            // Check stock for new total quantity
            if ($variant->stock_quantity < $newQuantity) {
                return response()->json(['message' => 'Không thể thêm số lượng này, vượt quá tồn kho'], 400);
            }

            $existingCartItem->update(['quantity' => $newQuantity]);
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_variant_id' => $variantId,
                'quantity' => $quantity,
            ]);
        }

        return response()->json(['message' => 'Đã thêm vào giỏ hàng thành công']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,product_variant_id',
            'quantity' => 'required|integer|min:0',
        ]);

        $userId = Auth::id();
        $variantId = $request->product_variant_id;
        $quantity = $request->quantity;

        if (!$userId) {
            return response()->json(['message' => 'Vui lòng đăng nhập'], 401);
        }

        $cartItem = Cart::where('user_id', $userId)
            ->where('product_variant_id', $variantId)
            ->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Sản phẩm không có trong giỏ hàng'], 404);
        }

        if ($quantity == 0) {
            // Remove item if quantity is 0
            $cartItem->delete();
            return response()->json(['message' => 'Đã xóa sản phẩm khỏi giỏ hàng']);
        }

        // Check stock
        $variant = ProductVariant::find($variantId);
        if ($variant->stock_quantity < $quantity) {
            return response()->json(['message' => 'Không đủ hàng trong kho'], 400);
        }

        $cartItem->update(['quantity' => $quantity]);

        return response()->json(['message' => 'Đã cập nhật số lượng']);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,product_variant_id',
        ]);

        $userId = Auth::id();
        $variantId = $request->product_variant_id;

        if (!$userId) {
            return response()->json(['message' => 'Vui lòng đăng nhập'], 401);
        }

        $cartItem = Cart::where('user_id', $userId)
            ->where('product_variant_id', $variantId)
            ->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Sản phẩm không có trong giỏ hàng'], 404);
        }

        $cartItem->delete();

        return response()->json(['message' => 'Đã xóa sản phẩm khỏi giỏ hàng']);
    }

    public function clear()
    {
        $userId = Auth::id();

        if (!$userId) {
            return response()->json(['message' => 'Vui lòng đăng nhập'], 401);
        }

        Cart::where('user_id', $userId)->delete();

        return response()->json(['message' => 'Đã xóa toàn bộ giỏ hàng']);
    }

    public function count()
    {
        $userId = Auth::id();

        if (!$userId) {
            return response()->json(['count' => 0]);
        }

        $count = Cart::where('user_id', $userId)->sum('quantity');

        return response()->json(['count' => $count]);
    }
}
