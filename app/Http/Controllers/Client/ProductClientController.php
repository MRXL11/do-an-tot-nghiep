<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductVariant;
use App\Models\Wishlist;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductClientController extends Controller
{
    public function index(Request $request, $slug = null)
    {
        // lấy fetch categories, brands, sizes, and colors
        $categories = Category::where('status', 'active')->get();
        $brands = Brand::where('status', 'active')->get();
        $sizes = ProductVariant::select('size')->distinct()->pluck('size');
        $colors = ProductVariant::select('color')->distinct()->pluck('color');
        

        // Hứng sản phẩm truy vấn 
        $productsQuery = Product::with(['variants', 'reviews']);
        // Apply filters/ lọc theo
        if ($slug) {
            $selectedCategory = Category::where('slug', $slug)->firstOrFail();
            $productsQuery->where('category_id', $selectedCategory->id);
        }
        if ($request->has('brand') && $request->brand) {
            $brand = Brand::where('slug', $request->brand)->first();
            if ($brand) {
                $productsQuery->where('brand_id', $brand->id);
            }
        }
        if ($request->has('size') && $request->size) {
            $productsQuery->whereHas('variants', function ($query) use ($request) {
                $query->where('size', $request->size);
            });
        }
        if ($request->has('color') && $request->color) {
            $productsQuery->whereHas('variants', function ($query) use ($request) {
                $query->where('color', $request->color);
            });
        }
        if ($request->has('price_min') && $request->price_min !== null) {
            $productsQuery->whereHas('variants', function ($query) use ($request) {
                $max = $request->price_max ?? 999999999; // Handle open-ended max price
                $query->whereBetween('price', [$request->price_min, $max]);
            });
        }

        // search
        $searchTerm = trim($request->search);
        if ($searchTerm) {
            $productsQuery->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // Sắp xếp sản phẩm
        $validSorts = ['newest', 'sales', 'likes', 'rating']; // Removed 'discount'
        $sort = $request->input('sort', 'newest'); // Default to newest
        $sortWarning = null; // To display warning for unsupported sort

        if (!in_array($sort, $validSorts)) {
            if ($sort === 'discount') {
                $sortWarning = 'Sắp xếp theo giảm giá hiện không khả dụng.';
            }
            $sort = 'newest'; // Fallback to newest
        }

        switch ($sort) {
            case 'newest':
                // sản phẩm mới
                $productsQuery->orderBy('created_at', 'desc');
                break;
            case 'sales':
                // Sắp xếp theo số lượng bán
                $productsQuery->addSelect(['*', DB::raw('
                    (SELECT COUNT(order_details.id) 
                     FROM order_details 
                     JOIN product_variants ON order_details.product_variant_id = product_variants.id 
                     WHERE product_variants.product_id = products.id) as sales_count
                ')])->orderBy('sales_count', 'desc');
                break;
            case 'likes':
                // Sắp xếp theo lượt thích
                $productsQuery->addSelect(['*', DB::raw('
                    (SELECT COUNT(wishlists.id) 
                     FROM wishlists 
                     WHERE wishlists.product_id = products.id) as likes_count
                ')])->orderBy('likes_count', 'desc');
                break;
            case 'rating':
                // Sắp xếp theo đánh giá 
                $productsQuery->addSelect(['*', DB::raw('
                    (SELECT AVG(reviews.rating) 
                     FROM reviews 
                     WHERE reviews.product_id = products.id 
                     AND reviews.status = "approved") as avg_rating
                ')])
                    ->whereHas('reviews', function ($query) {
                        $query->where('status', 'approved');
                    })
                    ->orderByRaw('avg_rating DESC NULLS LAST');
                break;
        }

        // Paginate
        $products = $productsQuery->where('products.status', 'active')->paginate(9)->appends($request->query());

        // nếu không có sản phẩm nào và có bộ lọc hoặc tìm kiếm trả lại 
        $noResults = $products->isEmpty() && $request->hasAny(['category', 'brand', 'size', 'color', 'price_min', 'price_max', 'search', 'sort']);

        // trả lại về trang sản phẩm
        return view('client.pages.products-client', compact('products', 'categories', 'brands', 'sizes', 'colors', 'noResults', 'searchTerm', 'sort', 'sortWarning'));
    }
}
