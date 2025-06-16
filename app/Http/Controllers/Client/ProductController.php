<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(string $id)
    {
        // lấy sản phẩm theo id và kèm theo các quan hệ category, brand, variants
        $product = Product::with(['variants', 'reviews' => function ($query) {
            $query->where('status', 'approved')->with('user');
        }])->where('status', 'active')->find($id);

        // nếu không tìm thấy sản phẩm thì trả về lỗi
        if (!$product) {
            return back()->with('error', 'Sản phẩm không tồn tại hoặc đã ngừng kinh doanh.');
        }

        $selectedVariant = $product->variants->first();
        $reviews = $product->reviews; // Gán reviews từ quan hệ

        /* lấy data sản phẩm để truyền vào view,
        sau đó dùng JS để xử lý thêm vào localStorage để lưu wishlist cho user chưa đăng nhập */
        $productData = [
            'id' => $product->id,
            'status' => $product->status,
        ];

        return view(
            'client.pages.detail-product',
            compact('product', 'productData', 'selectedVariant', 'reviews')
        );
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
        //
    }

    // Get variants for a specific color via AJAX
    public function getVariants(Request $request, $id)
    {
        $color = $request->query('color');
        $product = Product::findOrFail($id);
        $variants = $product->variants()->where('color', $color)->get();

        return response()->json(['variants' => $variants]);
    }
}
