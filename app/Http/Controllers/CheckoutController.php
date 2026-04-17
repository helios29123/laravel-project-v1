<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\ShippingAddress;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thanh toán.');
        }

        $cartItems = Cart::with(['productVariant.product'])
            ->where('user_id', $userId)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->productVariant->price;
        });

        $shippingFee = $subtotal > 500000 ? 0 : 30000;
        $total = $subtotal + $shippingFee;

        $shippingAddress = ShippingAddress::where('user_id', $userId)->latest()->first();

        $paymentMethods = collect([
            ['code' => 'cod', 'name' => 'Thanh toán khi nhận hàng (COD)'],
            ['code' => 'vnpay', 'name' => 'Thanh toán qua VNPAY'],
            ['code' => 'momo', 'name' => 'Thanh toán qua MoMo'],
        ]);

        return view('checkout', compact('cartItems', 'subtotal', 'shippingFee', 'total', 'shippingAddress', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thanh toán.');
        }

        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'ward' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|in:cod,vnpay,momo',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cartItems = Cart::with('productVariant')
            ->where('user_id', $userId)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->productVariant->price;
        });
        $shippingFee = $subtotal > 500000 ? 0 : 30000;
        $totalAmount = $subtotal + $shippingFee;

        $paymentMethodName = $this->mapPaymentMethodName($request->payment_method);
        $paymentMethod = PaymentMethod::firstOrCreate([
            'name' => $paymentMethodName,
        ], [
            'is_active' => true,
        ]);

        $shippingAddress = ShippingAddress::create([
            'user_id' => $userId,
            'recipient_name' => $request->fullname,
            'phone_number' => $request->phone,
            'address_line' => trim($request->address) . ', ' . $request->ward . ', ' . $request->district . ', ' . $request->city,
            'city' => $request->city,
            'is_default' => true,
        ]);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $userId,
                'shipping_address_id' => $shippingAddress->shipping_address_id,
                'payment_method_id' => $paymentMethod->payment_method_id,
                'voucher_id' => null,
                'total_amount' => $totalAmount,
                'shipping_fee' => $shippingFee,
                'order_status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                $variant = $item->productVariant;

                OrderItem::create([
                    'order_id' => $order->order_id,
                    'product_variant_id' => $variant->product_variant_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $variant->price,
                ]);

                if ($variant->stock_quantity !== null) {
                    $variant->decrement('stock_quantity', $item->quantity);
                }
            }

            Cart::where('user_id', $userId)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['checkout' => 'Đã xảy ra lỗi khi xử lý đơn hàng: ' . $e->getMessage()]);
        }

        try {
            $emailService = app(EmailService::class);
            if (!empty($request->email)) {
                $emailService->sendOrderConfirmation($request->email, $order);
            } elseif ($order->user && !empty($order->user->email)) {
                $emailService->sendOrderConfirmation($order->user->email, $order);
            }
        } catch (\Exception $e) {
            logger()->error('Email sending failed: ' . $e->getMessage(), ['order_id' => $order->order_id]);
        }

        if ($request->payment_method === 'momo') {
            $momoResponse = $this->createMomoPayment($order, $request);
            if (!empty($momoResponse['payUrl'])) {
                return redirect($momoResponse['payUrl']);
            }

            return redirect()->route('checkout.success', $order->order_id)
                ->with('warning', 'Thanh toán MoMo chưa cấu hình hoặc không khả dụng. Vui lòng liên hệ quản trị.');
        }

        return redirect()->route('checkout.success', $order->order_id);
    }

    public function momoCallback(Request $request)
    {
        $resultCode = $request->input('resultCode');
        $orderId = $request->input('orderId');

        if (!$orderId) {
            return redirect()->route('checkout.index')->withErrors(['checkout' => 'Thiếu thông tin đơn hàng từ MoMo.']);
        }

        $order = Order::find($orderId);
        if (!$order) {
            return redirect()->route('checkout.index')->withErrors(['checkout' => 'Không tìm thấy đơn hàng MoMo.']);
        }

        if (!$this->verifyMomoSignature($request)) {
            $order->order_status = 'failed';
            $order->save();
            return redirect()->route('checkout.success', $order->order_id)
                ->with('error', 'Xác thực MoMo thất bại.');
        }

        if ((int) $resultCode === 0) {
            $order->order_status = 'paid';
            $order->save();
            return redirect()->route('checkout.success', $order->order_id)
                ->with('success', 'Thanh toán MoMo thành công.');
        }

        $order->order_status = 'failed';
        $order->save();

        return redirect()->route('checkout.success', $order->order_id)
            ->with('error', 'Thanh toán MoMo không thành công: ' . $request->input('message', 'Lỗi không rõ'));
    }

    private function createMomoPayment(Order $order, Request $request): array
    {
        $endpoint = env('MOMO_ENDPOINT', 'https://test-payment.momo.vn/v2/gateway/api/create');
        $partnerCode = env('MOMO_PARTNER_CODE');
        $accessKey = env('MOMO_ACCESS_KEY');
        $secretKey = env('MOMO_SECRET_KEY');
        $redirectUrl = route('payment.momo.callback');
        $ipnUrl = route('payment.momo.callback');

        if (!$partnerCode || !$accessKey || !$secretKey) {
            return ['message' => 'MoMo sandbox chưa cấu hình.'];
        }

        $requestId = 'momo_' . uniqid();
        $orderId = (string) $order->order_id;
        $amount = (string) round($order->total_amount);
        $orderInfo = 'Thanh toán đơn hàng #' . $orderId;
        $extraData = base64_encode('user_id=' . $order->user_id);

        $rawSignature = implode('&', [
            'accessKey=' . $accessKey,
            'amount=' . $amount,
            'extraData=' . $extraData,
            'ipnUrl=' . $ipnUrl,
            'orderId=' . $orderId,
            'orderInfo=' . $orderInfo,
            'partnerCode=' . $partnerCode,
            'redirectUrl=' . $redirectUrl,
            'requestId=' . $requestId,
            'requestType=captureWallet',
        ]);

        $signature = hash_hmac('sha256', $rawSignature, $secretKey);

        $payload = [
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'extraData' => $extraData,
            'requestType' => 'captureWallet',
            'signature' => $signature,
        ];

        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post($endpoint, $payload);

        if ($response->successful()) {
            return $response->json();
        }

        return ['message' => $response->body() ?: 'Không nhận được phản hồi từ MoMo'];
    }

    private function verifyMomoSignature(Request $request): bool
    {
        $secretKey = env('MOMO_SECRET_KEY');
        $signature = $request->input('signature');

        if (!$secretKey || !$signature) {
            return false;
        }

        $params = [
            'partnerCode' => $request->input('partnerCode', ''),
            'accessKey' => $request->input('accessKey', ''),
            'requestId' => $request->input('requestId', ''),
            'orderId' => $request->input('orderId', ''),
            'errorCode' => $request->input('errorCode', ''),
            'message' => $request->input('message', ''),
            'localMessage' => $request->input('localMessage', ''),
            'amount' => $request->input('amount', ''),
            'responseTime' => $request->input('responseTime', ''),
            'orderInfo' => $request->input('orderInfo', ''),
            'orderType' => $request->input('orderType', ''),
            'transId' => $request->input('transId', ''),
            'payType' => $request->input('payType', ''),
            'extraData' => $request->input('extraData', ''),
        ];

        $rawSignature = implode('&', array_map(fn($key, $value) => $key . '=' . $value, array_keys($params), $params));

        return hash_hmac('sha256', $rawSignature, $secretKey) === $signature;
    }

    public function success($id)
    {
        $order = Order::with(['orderItems.productVariant.product', 'paymentMethod', 'shippingAddress'])
            ->findOrFail($id);

        return view('checkout-success', compact('order'));
    }

    private function mapPaymentMethodName(string $code): string
    {
        return match ($code) {
            'vnpay' => 'VNPAY',
            'momo' => 'MoMo',
            default => 'COD',
        };
    }
}
