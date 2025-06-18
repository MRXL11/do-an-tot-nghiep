<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(12);
        return view('client.pages.products-client', compact('products'));
    }

    public function show($slug)
    {
        $product = Product::with('category', 'brand')->where('slug', $slug)->firstOrFail();
        return view('client.pages.detail-product', compact('product'));
    }
    public function homepage()
{
    // Lấy 8 sản phẩm mới nhất
    $products = Product::latest()->take(8)->get();
    return view('client.layouts.index', compact('products'));
}
}
