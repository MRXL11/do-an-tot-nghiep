<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddVariantsRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * (Giữ nguyên logic gốc của bạn)
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $statuses = [
            'active' => 'Kích hoạt',
            'inactive' => 'Không kích hoạt',
            'out_of_stock' => 'Hết hàng',
        ];
        $query = Product::with(['category', 'brand']);
        $hasSearch = false;

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
            $hasSearch = true;
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
            $hasSearch = true;
        }
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
            $hasSearch = true;
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
            $hasSearch = true;
        }

        $products = $query->orderByDesc('id')->paginate(9);
        $noResults = $hasSearch && $products->isEmpty();
        $latestProducts = Product::with('variants')->orderByDesc('id')->take(5)->get();

        return view(
            'admin.products.products',
            compact('products', 'categories', 'brands', 'statuses', 'noResults', 'latestProducts')
        );
    }

    /**
     * Show the form for creating a new resource.
     * [CẬP NHẬT]
     */
    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();
        // Lấy dữ liệu thuộc tính để hiển thị ra form create
        $attributes = Attribute::with('values')->get();

        return view('admin.products.create', compact('categories', 'brands', 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     * [CẬP NHẬT]
     */
    public function store(StoreProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $filePath = null;
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/products', $fileName, 'public');
            }

            $product = Product::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'sku' => strtoupper(Str::random(8)),
                'slug' => Str::slug($request->name . '-' . Str::random(4)),
                'description' => $request->description,
                'short_description' => $request->short_description,
                'status' => $request->status,
                'thumbnail' => $filePath ?? null,
            ]);

            $variantsData = $request->variants; // Đã được chuyển thành mảng trong StoreProductRequest

            if (empty($variantsData)) {
                return redirect()->back()->with('error', 'Vui lòng tạo ít nhất một biến thể sản phẩm.')->withInput();
            }

            foreach ($variantsData as $variantData) {
                // 1. Tạo biến thể
                $variant = $product->variants()->create([
                    'price' => $variantData['price'],
                    'import_price' => $variantData['import_price'],
                    'stock_quantity' => $variantData['quantity'],
                    'sku' => $variantData['sku'],
                    'status' => 'active'
                ]);

                // 2. Gắn các ID thuộc tính (màu, size) vào bảng trung gian
                if (!empty($variantData['attribute_ids'])) {
                    $variant->attributes()->attach($variantData['attribute_ids']);
                }
            }

            DB::commit();
            return redirect()->route('admin.products.show', $product->id)->with('success', 'Sản phẩm đã được tạo thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     * [CẬP NHẬT]
     */
    public function show($id)
    {
        $brands = Brand::all();
        $categories = Category::all();
        $product = Product::with('variants.attributes')->findOrFail($id);
        $attributes = Attribute::with('values')->get();

        return view('admin.products.show', compact('product', 'categories', 'brands', 'attributes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Giữ nguyên
    }

    /**
     * Update the specified resource in storage.
     * [CẬP NHẬT]
     */
    public function update(UpdateProductRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            $filePath = $product->thumbnail;

            if ($request->hasFile('thumbnail')) {
                if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
                    Storage::disk('public')->delete($product->thumbnail);
                }
                $file = $request->file('thumbnail');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/products', $fileName, 'public');
            }

            $product->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'brand_id' => $request->input('brand_id'),
                'category_id' => $request->input('category_id'),
                'status' => $request->input('status'),
                'thumbnail' => $filePath,
                'short_description' => $request->input('short_description'),
            ]);

            if ($request->has('variants')) {
                foreach ($request->input('variants') as $index => $variantData) {
                    $variant = ProductVariant::find($variantData['id']);
                    if (!$variant) continue;

                    $variantImagePath = $variant->image;
                    if ($request->hasFile("variants.$index.image")) {
                        if ($variant->image && Storage::disk('public')->exists(str_replace('storage/', '', $variant->image))) {
                            Storage::disk('public')->delete(str_replace('storage/', '', $variant->image));
                        }
                        $file = $request->file("variants.$index.image");
                        $fileName = time() . '_' . Str::slug($product->name) . '-' . $index . '.' . $file->getClientOriginalExtension();
                        $path = $file->storeAs('uploads/variants', $fileName, 'public');
                        $variantImagePath = 'storage/' . $path;
                    }

                    $variant->update([
                        'price' => $variantData['price'],
                        'import_price' => $variantData['import_price'],
                        'stock_quantity' => $variantData['stock_quantity'],
                        'status' => $variantData['status'],
                        'image' => $variantImagePath,
                    ]);

                    if (isset($variantData['attributes'])) {
                        $variant->attributes()->sync($variantData['attributes']);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.products.show', $product->id)->with('success', 'Cập nhật sản phẩm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Đã xảy ra lỗi khi cập nhật sản phẩm: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * (Giữ nguyên logic gốc của bạn)
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            $product->status = 'inactive';
            $product->save();
            ProductVariant::where('product_id', $id)->update(['status' => 'inactive']);
            DB::commit();
            return redirect()->back()->with('success', 'Sản phẩm ' . $product->name . ' và các biến thể tương ứng đã được ngừng bán (inactive).');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Khôi phục sản phẩm.
     * (Giữ nguyên logic gốc của bạn)
     */
    public function restore($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->status = 'active';
            $product->save();
            ProductVariant::where('product_id', $id)->update(['status' => 'active']);
            return redirect()->back()->with('success', 'Sản phẩm và các biến thể đã được khôi phục.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi khi khôi phục: ' . $e->getMessage());
        }
    }

    /**
     * Thêm biến thể mới.
     * [CẬP NHẬT]
     */
    public function addVariants(AddVariantsRequest $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $variantsData = json_decode($request->variants, true);
            $added = 0;
            $skipped = [];

            if ($variantsData) {
                foreach ($variantsData as $variantData) {
                    $exists = $product->variants()->whereHas('attributes', function ($query) use ($variantData) {
                        $query->whereIn('attribute_value_id', $variantData['attribute_ids']);
                    }, '=', count($variantData['attribute_ids']))->exists();

                    if ($exists) {
                        $skipped[] = $variantData['name'];
                        continue;
                    }

                    $variant = $product->variants()->create([
                        'import_price' => $variantData['import_price'],
                        'price' => $variantData['price'],
                        'stock_quantity' => $variantData['quantity'],
                        'sku' => $variantData['sku'],
                        'status' => 'active',
                    ]);
                    $variant->attributes()->attach($variantData['attribute_ids']);
                    $added++;
                }
            }

            $message = '';
            if ($added > 0) $message .= "Đã thêm $added biến thể mới. ";
            if (!empty($skipped)) $message .= "Bỏ qua " . count($skipped) . " biến thể đã tồn tại: " . implode(', ', $skipped) . ".";
            
            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi khi thêm biến thể: ' . $e->getMessage());
        }
    }
}