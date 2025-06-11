<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Điều chỉnh quyền truy cập nếu cần
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:50', 'unique:coupons,code'],
            'discount_type' => ['required', 'in:percent,fixed'],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'min_order_value' => ['nullable', 'numeric', 'min:0'],
            'max_discount' => ['nullable', 'numeric', 'min:0'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'user_usage_limit' => ['nullable', 'integer', 'min:1'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Mã coupon là bắt buộc.',
            'code.unique' => 'Mã coupon đã tồn tại.',
            'discount_type.required' => 'Loại giảm giá là bắt buộc.',
            'discount_value.required' => 'Giá trị giảm giá là bắt buộc.',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'end_date.required' => 'Ngày kết thúc là bắt buộc.',
            'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
            
        ];
    }
}