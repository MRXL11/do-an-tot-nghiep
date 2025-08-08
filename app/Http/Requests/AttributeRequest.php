<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttributeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $attributeId = $this->route('attribute'); // Lấy ID của thuộc tính từ route

        return [
            // Quy tắc cho việc tạo/cập nhật tên thuộc tính (Màu sắc, Kích thước)
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('attributes', 'name')->ignore($attributeId),
            ],
            // Quy tắc cho việc thêm các giá trị mới (Đỏ, Xanh, S, M)
            'values' => 'sometimes|array', // 'values' là một mảng và không bắt buộc
            'values.*' => [
                'required',
                'string',
                'max:100',
                // Mỗi giá trị phải là duy nhất trong bảng attribute_values cho cùng một attribute_id
                Rule::unique('attribute_values', 'value')->where(function ($query) use ($attributeId) {
                    return $query->where('attribute_id', $attributeId);
                }),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên thuộc tính là bắt buộc.',
            'name.unique' => 'Tên thuộc tính này đã tồn tại.',
            'values.*.required' => 'Tên giá trị không được để trống.',
            'values.*.unique' => 'Giá trị này đã tồn tại cho thuộc tính hiện tại.',
        ];
    }
}