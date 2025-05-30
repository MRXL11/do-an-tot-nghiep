<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index(Request $request)
{
    $query = Brand::query();

    if ($request->has('search') && $request->search != '') {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    $brands = $query->orderBy('created_at', 'desc')->paginate(10);

    // Truy vấn TOP 10 brands bán chạy như trước
  $topBrands = DB::table('order_details')
    ->join('products', 'order_details.product_variant_id', '=', 'products.id')
    ->join('brands', 'products.brand_id', '=', 'brands.id')
    ->select(
        'brands.id',
        'brands.name',
        'brands.image',
        DB::raw('SUM(order_details.quantity) as total_sold')
    )
    ->groupBy('brands.id', 'brands.name', 'brands.image')
    ->orderByDesc('total_sold')
    ->limit(10)
    ->get();

    return view('admin.brands.list-brands', compact('brands', 'topBrands'));
}
public function show($id)
{
    $brand = Brand::findOrFail($id);
    return view('admin.brands.detail-brand', compact('brand'));
}

// Hiển thị form tạo mới thương hiệu
    public function create()
    {
        return view('admin.brands.create-brand');
    }

    // Lưu thương hiệu mới vào database
    public function store(Request $request)
    {
       
        $request->validate([
            'name'   => 'required|string|max:100',
            'slug'   => 'required|string|max:100|unique:brands,slug',
            'status' => 'in:active,inactive',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Lấy dữ liệu cần thiết từ request
        $data = $request->only(['name', 'slug', 'status']);

        // Nếu có file ảnh, xử lý upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                // Lưu file, trả về đường dẫn lưu trong disk 'public'
                $data['image'] = $image->store('brands', 'public');
            }
        } else {
            $data['image'] = null;
        }

        // Tạo mới bản ghi thương hiệu
        Brand::create($data);
       return redirect()->route('brands')->with('success', 'Thương hiệu được tạo thành công');
    }
 
    // Hiển thị form chỉnh sửa thương hiệu
    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit-brand', compact('brand'));
    }

    // Cập nhật thương hiệu
    public function update(Request $request, $id)
    {
       $request->validate([
        'name' => 'required|string|max:100',
        'slug' => 'required|string|max:100|unique:brands,slug,' . $id,
        'status' => 'in:active,inactive',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $brand = Brand::findOrFail($id);

    if ($request->hasFile('image')) {
        // Xóa ảnh cũ nếu có
        if ($brand->image) {
            Storage::disk('public')->delete($brand->image);
        }
        $imagePath = $request->file('image')->store('brands', 'public');
    } else {
        $imagePath = $brand->image;
    }

    $brand->update([
        'name' => $request->name,
        'slug' => $request->slug,
        'status' => $request->status,
        'image' => $imagePath,
    ]);

        return redirect()->route('brands', $id)->with('success', 'Thương hiệu được cập nhật thành công');
    }

    // Xóa thương hiệu
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return redirect()->route('brands')->with('success', 'Thương hiệu được xóa thành công');
    }
}