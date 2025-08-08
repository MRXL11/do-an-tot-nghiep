<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Xác định người dùng có quyền thực hiện request này không.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Chuẩn bị dữ liệu trước khi validate.
     * Chuyển đổi chuỗi JSON 'variants' thành mảng PHP.
     */
    protected function prepareForValidation()
    {
        if ($this->has('variants') && is_string($this->variants)) {
            $this->merge([
                'variants' => json_decode($this->variants, true)
            ]);
        }
    }

    /**
     * Các quy tắc validate khi tạo mới sản phẩm.
     */
    public function rules(): array
    {
        return [
            // Quy tắc cho thông tin sản phẩm chính
            'name' => 'required|string|max:255|unique:products,name',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive,out_of_stock',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png|max:2048',

            // Quy tắc cho các biến thể
            'variants' => [
                'required', 'array', 'min:1',
                // Hàm kiểm tra các tổ hợp thuộc tính có bị trùng lặp không
                function ($attribute, $value, $fail) {
                    $combinations = [];
                    foreach ($value as $index => $variant) {
                        if (!isset($variant['attribute_ids']) || !is_array($variant['attribute_ids'])) {
                            $fail("Dữ liệu thuộc tính không hợp lệ tại vị trí " . ($index + 1) . ".");
                            return;
                        }
                        $ids = $variant['attribute_ids'];
                        sort($ids); // Sắp xếp các ID để đảm bảo tính duy nhất
                        $key = implode('|', $ids);

                        if (in_array($key, $combinations)) {
                            $variantName = $variant['name'] ?? ('vị trí ' . ($index + 1));
                            $fail("Biến thể '{$variantName}' bị trùng lặp.");
                        }
                        $combinations[] = $key;
                    }
                },
            ],
            // Kiểm tra từng biến thể trong mảng
            'variants.*.import_price' => 'required|numeric|min:0',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.quantity' => 'required|integer|min:0',
            'variants.*.sku' => 'required|string',
            'variants.*.attribute_ids' => 'required|array|min:1',
            'variants.*.attribute_ids.*' => 'required|integer|exists:attribute_values,id',
        ];
    }

    /**
     * Thông điệp lỗi tùy chỉnh.
     */
    public function messages(): array
    {
        return [
            'name.unique' => 'Tên sản phẩm đã tồn tại.',
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'brand_id.required' => 'Thương hiệu là bắt buộc.',
            'category_id.required' => 'Danh mục là bắt buộc.',
            'thumbnail.required' => 'Ảnh đại diện là bắt buộc.',
            'variants.required' => 'Vui lòng tạo ít nhất một biến thể.',
            'variants.min' => 'Vui lòng tạo ít nhất một biến thể.',
            'variants.*.price.required' => 'Giá bán của biến thể là bắt buộc.',
            'variants.*.quantity.required' => 'Số lượng của biến thể là bắt buộc.',
            'variants.*.import_price.required' => 'Giá nhập của biến thể là bắt buộc.',
            'variants.*.attribute_ids.required' => 'Thuộc tính của biến thể là bắt buộc.',
        ];
    }
}