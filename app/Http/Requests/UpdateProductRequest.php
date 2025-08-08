<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Xác định người dùng có quyền thực hiện request này không.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Các quy tắc validate khi cập nhật sản phẩm.
     */
    public function rules(): array
    {
        // Lấy ID sản phẩm từ route để bỏ qua khi kiểm tra unique
        $productId = $this->route('id');

        return [
            // Quy tắc cho thông tin sản phẩm chính
            'name' => 'sometimes|required|string|max:255|unique:products,name,' . $productId,
            'brand_id' => 'sometimes|required|exists:brands,id',
            'category_id' => 'sometimes|required|exists:categories,id',
            'status' => 'sometimes|required|in:active,inactive,out_of_stock',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            // Quy tắc cho việc cập nhật các biến thể đã có
            'variants' => 'sometimes|array',
            'variants.*.id' => 'required|exists:product_variants,id',
            'variants.*.import_price' => 'required|numeric|min:0',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock_quantity' => 'required|integer|min:0',
            'variants.*.status' => 'required|in:active,inactive',
            'variants.*.image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'variants.*.attributes' => 'required|array|min:1',
            'variants.*.attributes.*' => 'required|integer|exists:attribute_values,id',
        ];
    }
}