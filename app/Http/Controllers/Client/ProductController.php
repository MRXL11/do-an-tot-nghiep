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
        $product = Product::with('category', 'brand', 'variants')->findOrFail($id);

        /* lấy data sản phẩm để truyền vào view,
        sau đó dùng JS để xử lý thêm vào localStorage để lưu wishlist cho user chưa đăng nhập */
        $productData = [
            'id' => $product->id,
        ];

        return view('client.pages.detail-product', compact('product', 'productData'));
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
}
