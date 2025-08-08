<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttributeController extends Controller
{
    /**
     * Hiển thị trang quản lý Màu sắc và Kích thước.
     */
    public function index()
    {
        // Lấy thuộc tính Color và các giá trị của nó, hoặc tạo mới nếu chưa có
        $colorAttribute = Attribute::firstOrCreate(['name' => 'Color']);
        $colors = $colorAttribute->values()->latest()->paginate(10, ['*'], 'colors_page');

        // Lấy thuộc tính Size và các giá trị của nó, hoặc tạo mới nếu chưa có
        $sizeAttribute = Attribute::firstOrCreate(['name' => 'Size']);
        $sizes = $sizeAttribute->values()->latest()->paginate(10, ['*'], 'sizes_page');

        return view('admin.attributes.index', compact('colorAttribute', 'colors', 'sizeAttribute', 'sizes'));
    }

    /**
     * Lưu một giá trị thuộc tính mới (Màu sắc hoặc Kích thước).
     */
    public function storeValue(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => [
                'required',
                'string',
                'max:100',
                Rule::unique('attribute_values')->where(function ($query) use ($request) {
                    return $query->where('attribute_id', $request->attribute_id);
                }),
            ],
        ], [
            'value.required' => 'Tên giá trị không được để trống.',
            'value.unique' => 'Giá trị này đã tồn tại.',
        ]);

        AttributeValue::create($request->only(['attribute_id', 'value']));

        return back()->with('success', 'Đã thêm giá trị mới thành công.');
    }

    /**
     * Cập nhật một giá trị thuộc tính.
     */
    public function updateValue(Request $request, $id)
    {
        $attributeValue = AttributeValue::findOrFail($id);

        $request->validate([
            'value' => [
                'required',
                'string',
                'max:100',
                Rule::unique('attribute_values')->where(function ($query) use ($attributeValue) {
                    return $query->where('attribute_id', $attributeValue->attribute_id);
                })->ignore($id),
            ],
        ], [
            'value.required' => 'Tên giá trị không được để trống.',
            'value.unique' => 'Giá trị này đã tồn tại.',
        ]);

        $attributeValue->update(['value' => $request->value]);

        return back()->with('success', 'Cập nhật giá trị thành công.');
    }

    /**
     * Xóa một giá trị thuộc tính (Soft Delete).
     */
    public function destroyValue($id)
    {
        $value = AttributeValue::findOrFail($id);
        // TODO: Kiểm tra xem giá trị có đang được sử dụng trong biến thể nào không trước khi xóa
        $value->delete();

        return back()->with('success', 'Đã xóa giá trị thành công.');
    }
}