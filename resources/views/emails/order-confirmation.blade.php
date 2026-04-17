@php
$order = $order ?? null;
@endphp

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng</title>
</head>
<body>
    <h1>Xin chào {{ $order->shippingAddress->recipient_name ?? 'Khách hàng' }},</h1>
    <p>Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi. Dưới đây là thông tin đơn hàng của bạn:</p>

    <h2>Đơn hàng #{{ $order->order_id }}</h2>
    <p>Trạng thái: {{ ucfirst($order->order_status) }}</p>
    <p>Tổng tiền: {{ number_format($order->total_amount, 0, ',', '.') }} đ</p>
    <p>Phí vận chuyển: {{ number_format($order->shipping_fee, 0, ',', '.') }} đ</p>

    <h3>Địa chỉ giao hàng</h3>
    <p>{{ $order->shippingAddress->address_line }}</p>
    <p>Điện thoại: {{ $order->shippingAddress->phone_number }}</p>

    <h3>Chi tiết sản phẩm</h3>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá đơn vị</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->productVariant->product->name ?? 'Sản phẩm' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 0, ',', '.') }} đ</td>
                    <td>{{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }} đ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi.</p>
    <p>Chúc bạn một ngày tốt lành!</p>
</body>
</html>
