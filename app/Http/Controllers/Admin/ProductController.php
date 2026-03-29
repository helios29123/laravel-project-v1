<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Image;
use App\Models\ProductVariant;
use Illuminate\Support\Str;
use App\Models\Attribute;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy danh sách sản phẩm kèm theo danh mục, hình ảnh và biến thể. Sắp xếp mới nhất lên đầu, phân trang 10 SP/trang
        $products = Product::with(['category', 'images', 'variants'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,category_id',
            'description' => 'required',
        ]);
//===========================================
        //Xu ly anh
        if($request->hasFile('image')){
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }
//===========================================
        //Luu vao database (bang products)
        $product = Product::create([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'status' => 'active', // Theo trang thai mac dinh, hoac ban co the tuy chinh
        ]);
//===========================================
        //Luu anh vao bang images
        if (isset($data['image'])) {
            Image::create([
                'product_id' => $product->product_id,
                'image_url' => $data['image'],
            ]);
        }
//===========================================
        //Luu gia va so luong vao bang product_variants
        if ($request->has('variants') && count($request->variants) > 0) {
            //Neu giao dien co tra mang variant ve -> San pham nay co phan loai
            foreach($request->variants as $variantData) {
                $variant = ProductVariant::create([
                    'product_id' => $product->product_id,
                    'sku' => $variantData['sku'],
                    'price' => $variantData['price'],
                    'stock_quantity' => $variantData['stock'],
                ]);

                //Cap nhat tiep vao bang trung gian VariantAttributeValue
                if(isset($variantData['attribute_value_id'])) {
                    $variant->attributeValues()->attach($variantData['attribute_value_ids']);
                }
            }
        }else {
            ProductVariant::create([
                'product_id' => $product->product_id,
                'sku' => 'PRD-' . strtoupper(Str::random(6)),
                'price' => $request->price,
                'stock_quantity' => $request->stock,
            ]);
//=====================================
        };
        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }
    
    public function getAttributes($categoryId) {
        // Lay tat ca attributes ma khong can loc theo category
        $attributes = Attribute::with('values')->get();

        //Tra ve dinh dang JSON cho JS
        return response()->json($attributes);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        // Laravel hỗ trợ Cascade nếu bạn đã cấu hình DB, nếu không Eloquent delete product là đủ (Tạm thời)
        $product->delete();
        
        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được xóa thành công về thùng rác!');
    }
}
