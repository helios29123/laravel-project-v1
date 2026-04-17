<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    protected $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        // Server settings
        $this->mailer->isSMTP();
        $this->mailer->Host       = env('MAIL_HOST', 'smtp.gmail.com');
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = env('MAIL_USERNAME');
        $this->mailer->Password   = env('MAIL_PASSWORD');
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port       = env('MAIL_PORT', 587);

        // Recipients
        $this->mailer->setFrom(env('MAIL_FROM_ADDRESS', 'noreply@example.com'), env('MAIL_FROM_NAME', 'ElectroGear'));
    }

    public function sendOrderConfirmation($toEmail, $order)
    {
        try {
            $this->mailer->addAddress($toEmail);

            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Xác nhận đơn hàng #' . $order->order_id;

            $body = $this->buildOrderConfirmationBody($order);
            $this->mailer->Body    = $body;
            $this->mailer->AltBody = strip_tags($body);

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            logger()->error('PHPMailer Error: ' . $this->mailer->ErrorInfo);
            return false;
        }
    }

    private function buildOrderConfirmationBody($order)
    {
        $itemsHtml = '';
        foreach ($order->orderItems as $item) {
            $productName = $item->productVariant->product->name ?? 'Sản phẩm';
            $quantity = $item->quantity;
            $price = number_format($item->unit_price, 0, ',', '.');
            $total = number_format($item->unit_price * $quantity, 0, ',', '.');

            $itemsHtml .= "
                <tr>
                    <td>{$productName}</td>
                    <td>{$quantity}</td>
                    <td>{$price} đ</td>
                    <td>{$total} đ</td>
                </tr>
            ";
        }

        $subtotal = number_format($order->total_amount - $order->shipping_fee, 0, ',', '.');
        $shipping = number_format($order->shipping_fee, 0, ',', '.');
        $total = number_format($order->total_amount, 0, ',', '.');

        $address = $order->shippingAddress->address_line ?? 'Không xác định';

        return "
            <!DOCTYPE html>
            <html lang='vi'>
            <head>
                <meta charset='UTF-8'>
                <title>Xác nhận đơn hàng</title>
            </head>
            <body>
                <h1>Xin chào {$order->shippingAddress->recipient_name ?? 'Khách hàng'},</h1>
                <p>Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi. Dưới đây là thông tin đơn hàng của bạn:</p>

                <h2>Đơn hàng #{$order->order_id}</h2>
                <p>Trạng thái: " . ucfirst($order->order_status) . "</p>
                <p>Tổng tiền: {$total} đ</p>
                <p>Phí vận chuyển: {$shipping} đ</p>

                <h3>Địa chỉ giao hàng</h3>
                <p>{$address}</p>
                <p>Điện thoại: {$order->shippingAddress->phone_number ?? ''}</p>

                <h3>Chi tiết sản phẩm</h3>
                <table border='1' cellpadding='8' cellspacing='0'>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá đơn vị</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        {$itemsHtml}
                    </tbody>
                </table>

                <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi.</p>
                <p>Chúc bạn một ngày tốt lành!</p>
            </body>
            </html>
        ";
    }
}