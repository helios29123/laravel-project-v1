<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Image;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\VariantAttributeValue;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        // Ensure Attributes are created
        $attrs = [
            'Kiểu chân (Package)', 'Phiên bản board', 'Loại chip nạp', 
            'Điện áp hoạt động', 'Chuẩn giao tiếp', 'Dải đo / Độ phân giải',
            'Trị số (Value)', 'Kích thước / Kiểu chân', 'Công suất', 'Sai số',
            'Kích thước / Trọng lượng', 'Màu sắc / Mẫu mã'
        ];

        $dbAttrs = [];
        foreach ($attrs as $attrName) {
            $dbAttrs[$attrName] = Attribute::firstOrCreate(['name' => $attrName]);
        }

        // Helper to get or create attribute value
        $getAttrVal = function ($attrName, $value) use ($dbAttrs) {
            return AttributeValue::firstOrCreate([
                'attribute_id' => $dbAttrs[$attrName]->attribute_id,
                'value' => $value
            ]);
        };

        // Templates for Categories
        $templates = [
            'Vi điều khiển & Nhúng' => [
                'names' => ['Mạch Arduino Uno', 'Mạch Arduino Mega', 'Vi điều khiển STM32F103C8T6', 'ESP32 Development Board', 'NodeMCU ESP8266'],
                'variants' => [
                    [
                        'price' => [80000, 150000],
                        'attributes' => [
                            'Loại chip nạp' => ['CH340', '16U2', 'CP2102', 'FT232'],
                            'Kiểu chân (Package)' => ['SMD', 'DIP (chân cắm)', 'LQFP48', 'SOP-8'],
                            'Phiên bản board' => ['R3', 'V2', 'Mini', 'Pro']
                        ]
                    ]
                ]
            ],
            'Cảm biến & Module' => [
                'names' => ['Module Rơ le (Relay)', 'Cảm biến khoảng cách', 'Cảm biến nhiệt độ DHT11', 'Module RFID RC522', 'Cảm biến khí gas MQ-2'],
                'variants' => [
                    [
                        'price' => [15000, 50000],
                        'attributes' => [
                            'Điện áp hoạt động' => ['3.3V', '5V', '12V', '24V'],
                            'Chuẩn giao tiếp' => ['I2C', 'SPI', 'UART', 'Analog', 'Digital'],
                            'Dải đo / Độ phân giải' => ['Mức thấp (Low level trigger)', 'Mức cao (High level trigger)', 'Đo gần vài cm (TCRT5000)', 'Đo xa vài mét (HC-SR04)', '8-bit', '12-bit']
                        ]
                    ]
                ]
            ],
            'Linh kiện Phụ động' => [
                'names' => ['Điện trở vạch màu', 'Tụ gốm nhiều lớp', 'Tụ hóa', 'Cuộn cảm', 'Diode chỉnh lưu', 'Transistor NPN'],
                'variants' => [
                    [
                        'price' => [1000, 5000],
                        'attributes' => [
                            'Trị số (Value)' => ['330 Ohm', '1k Ohm', '10k Ohm', '104 (0.1uF) - 50V', '103 (0.01uF) - 50V', '1000uF - 16V'],
                            'Kích thước / Kiểu chân' => ['Xuyên lỗ (DIP)', 'SMD 0603', 'SMD 0805', 'SMD 1206'],
                            'Công suất' => ['1/4W', '1/2W', '1W', '5W'],
                            'Sai số' => ['1%', '5%', '10%']
                        ]
                    ]
                ]
            ],
            'IC Chức năng & Logic' => [
                'names' => ['IC NE555', 'IC Op-amp LM358', 'IC Logic 74HC595', 'IC nguồn LM317', 'IC đếm 4017'],
                'variants' => [
                    [
                        'price' => [3000, 15000],
                        'attributes' => [
                            'Kiểu chân (Package)' => ['DIP-8', 'SOP-8', 'DIP-14', 'DIP-16', 'TO-220'],
                            'Điện áp hoạt động' => ['5V', '12V', 'Phân cực rộng']
                        ]
                    ]
                ]
            ],
            'Thiết bị Thực hành' => [
                'names' => ['Cuộn thiếc hàn Sunchi', 'Mỏ hàn nhiệt tay cầm gỗ', 'Đồng hồ vạn năng', 'Kìm cắt linh kiện', 'Nhựa thông hàn'],
                'variants' => [
                    [
                        'price' => [25000, 150000],
                        'attributes' => [
                            'Công suất' => ['40W', '60W', '90W'],
                            'Kích thước / Trọng lượng' => ['Sợi 0.8mm - Cuộn 50g', 'Sợi 1.0mm - Cuộn 100g', 'Gói nhỏ 10g'],
                            'Màu sắc / Mẫu mã' => ['Đỏ', 'Xanh', 'Đen', 'Vàng']
                        ]
                    ]
                ]
            ]
        ];

        // Seed products
        $totalSeeded = 0;
        $categories = Category::all();
        
        // Loop randomly through templates to reach 100 products
        while($totalSeeded < 100) {
            foreach ($categories as $category) {
                if ($totalSeeded >= 100) break;
                
                // Match category to template
                $catNamePrefix = explode(' ', $category->name)[0]; // e.g. "Vi", "Cảm", "Linh", "Thiết"
                $templateName = null;
                foreach ($templates as $key => $temp) {
                    if (strpos($key, $catNamePrefix) !== false) {
                        $templateName = $key;
                        break;
                    }
                }
                
                if (!$templateName) continue;
                
                $template = $templates[$templateName];
                $baseName = $faker->randomElement($template['names']);
                $name = $baseName . ' ' . $faker->regexify('[A-Z0-9]{2,4}');
                
                $product = Product::create([
                    'category_id' => $category->category_id,
                    'name' => $name,
                    'description' => "Được cung cấp chính hãng, độ tin cậy và hiệu suất tuyệt cao.\nPhù hợp cho các dự án IoT và hệ thống nhúng.",
                    'status' => 'active',
                ]);

                // Create image fallback
                Image::create([
                    'product_id' => $product->product_id,
                    'image_url' => 'https://dummyimage.com/600x600/1f2937/ff2d20&text=' . urlencode(substr($baseName, 0, 15)),
                ]);

                // Generate 1-3 variants for this product
                $numVariants = rand(1, 3);
                $variantTemplate = $template['variants'][0];
                
                for ($v = 0; $v < $numVariants; $v++) {
                    $variant = ProductVariant::create([
                        'product_id' => $product->product_id,
                        'sku' => 'SKU-' . strtoupper(Str::random(6)),
                        'price' => rand($variantTemplate['price'][0] / 1000, $variantTemplate['price'][1] / 1000) * 1000,
                        'stock_quantity' => rand(10, 500),
                    ]);

                    // Pick random attributes from the template's available attributes and link them
                    // E.g. pick 1 to 2 random attributes per variant
                    $attrsToPick = array_rand($variantTemplate['attributes'], rand(1, 2));
                    if (!is_array($attrsToPick)) {
                        $attrsToPick = [$attrsToPick];
                    }

                    foreach ($attrsToPick as $attrName) {
                        $attrValString = $faker->randomElement($variantTemplate['attributes'][$attrName]);
                        $attrValue = $getAttrVal($attrName, $attrValString);
                        
                        // Pivot insert
                        VariantAttributeValue::firstOrCreate([
                            'product_variant_id' => $variant->product_variant_id,
                            'attribute_value_id' => $attrValue->attribute_value_id,
                        ]);
                    }
                }
                
                $totalSeeded++;
            }
        }
    }
}
