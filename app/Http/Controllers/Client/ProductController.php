<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Display product details
    public function show($id)
    {
        $product = Product::with(['variants', 'reviews' => function ($query) {
            $query->where('status', 'approved')->with('user');
        }])->findOrFail($id);
        $selectedVariant = $product->variants->first();
        $reviews = $product->reviews; // Gán reviews từ quan hệ

        return view('client.pages.detail-product', compact('product', 'selectedVariant', 'reviews'));
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