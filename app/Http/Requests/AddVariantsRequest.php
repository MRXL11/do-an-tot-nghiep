<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddVariantsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->filled('variants_json')) {
            $decoded = json_decode($this->variants_json, true);
            $this->merge([
                'variants' => $decoded
            ]);
        }
    }

    public function rules()
    {
        return [
            'variants' => 'required|array|min:1',
            'variants.*.color' => 'required|string|max:50',
            'variants.*.size' => 'required|string|max:50',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.quantity' => 'required|integer|min:0', // Đổi từ stock_quantity thành quantity
            'variants.*.sku' => 'nullable|string|max:100',
            'variants.*.status' => 'nullable|in:active,inactive',
        ];
    }

    public function messages()
    {
        return [
            'variants.required' => 'Phải có ít nhất một biến thể.',
            'variants.array' => 'Dữ liệu biến thể phải là một mảng.',
            'variants.*.color.required' => 'Màu sắc của biến thể là bắt buộc.',
            'variants.*.color.string' => 'Màu sắc phải là chuỗi ký tự.',
            'variants.*.color.max' => 'Màu sắc không được vượt quá 50 ký tự.',
            'variants.*.size.required' => 'Kích cỡ của biến thể là bắt buộc.',
            'variants.*.size.string' => 'Kích cỡ phải là chuỗi ký tự.',
            'variants.*.size.max' => 'Kích cỡ không được vượt quá 50 ký tự.',
            'variants.*.price.required' => 'Giá của biến thể là bắt buộc.',
            'variants.*.price.numeric' => 'Giá phải là số.',
            'variants.*.price.min' => 'Giá không được nhỏ hơn 0.',
            'variants.*.quantity.required' => 'Số lượng tồn kho là bắt buộc.', // Đổi từ stock_quantity thành quantity
            'variants.*.quantity.integer' => 'Số lượng tồn kho phải là số nguyên.',
            'variants.*.quantity.min' => 'Số lượng tồn kho không được nhỏ hơn 0.',
            'variants.*.status.in' => 'Trạng thái của biến thể phải là "active" hoặc "inactive".',
        ];
    }
}
