<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Http\Requests\BrandRequest;
class BrandController extends Controller
{
    public function index(Request $request)
{
    $query = Brand::query();
    // tìm kiếm
    if ($request->has('search') && $request->search != '') {
        $query->where('name', 'like', '%' . $request->search . '%');
    }
    // lọc theo trạng thái
        // Lọc theo trạng thái nếu có tham số status
    if ($request->status === 'active') {
        $query->where('status', 'active');
    } elseif ($request->status === 'inactive') {
        $query->where('status', 'inactive');
    }
    
    // phân trang theo tham số created_at
    $brands = $query->orderBy('created_at', 'desc')->paginate(10);

    // Truy vấn TOP 10 brands bán chạy như trước
  $topBrands = DB::table('order_details')
    ->join('products', 'order_details.product_variant_id', '=', 'products.id')
    ->join('brands', 'products.brand_id', '=', 'brands.id')
    ->select(
        'brands.id',
        'brands.name',
        DB::raw('SUM(order_details.quantity) as total_sold')
    )
    ->groupBy('brands.id', 'brands.name')
    ->orderByDesc('total_sold')
    ->limit(10)
    ->get();

    return view('admin.brands.list', compact('brands', 'topBrands'));
}

// Hiển thị form tạo mới thương hiệu
    public function create()
    {
        return view('admin.brands.create');
    }

    // Lưu thương hiệu mới vào database
 public function store(BrandRequest $request)
    {
        Brand::create($request->only(['name', 'slug', 'status']));

        return redirect()->route('admin.brands.index')->with('success', 'Thương hiệu được tạo thành công');
    }

 
    // Hiển thị form chỉnh sửa thương hiệu
    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    // Cập nhật thương hiệu
    public function update(BrandRequest $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $brand->update($request->only(['name', 'slug', 'status']));

        return redirect()->route('admin.brands.index')->with('success', 'Thương hiệu được cập nhật thành công');
    }

     // thay đổi trạng thái
     public function toggleStatus($id)
{
    $brand = Brand::findOrFail($id);
    $brand->status = $brand->status == 'active' ? 'inactive' : 'active';
    $brand->save();
    return redirect()->route('admin.brands.index')->with('success', 'Trạng thái thương hiệu đã đổi');
}
    // Xóa thương hiệu
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Thương hiệu đã được xóa');
    }

}