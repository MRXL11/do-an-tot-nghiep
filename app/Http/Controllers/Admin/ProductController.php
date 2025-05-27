<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Lấy danh sách danh mục từ cơ sở dữ liệu
        $categories = Category::all();
        $brands = Brand::all();

        // Định nghĩa mảng trạng thái với nhãn thân thiện
        $statuses = [
            'active' => 'Kích hoạt',
            'inactive' => 'Không kích hoạt',
            'out_of_stock' => 'Hết hàng',
        ];

        // Khởi tạo query với eager loading
        $query = Product::with(['category', 'brand']);

        // Biến kiểm tra xem có tìm kiếm hay không
        $hasSearch = false;

        // Lọc theo tên sản phẩm
        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
            $hasSearch = true;
        }

        // Lọc theo danh mục
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
            $hasSearch = true;
        }

        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
            $hasSearch = true;
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
            $hasSearch = true;
        }

        // Lấy danh sách sản phẩm với phân trang
        $products = $query->orderByDesc('id')->paginate(10);

        // Kiểm tra nếu có tìm kiếm nhưng không có kết quả
        $noResults = $hasSearch && $products->isEmpty();

        return view(
            'admin.products.products',
            compact('products', 'categories', 'brands', 'statuses', 'noResults')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
