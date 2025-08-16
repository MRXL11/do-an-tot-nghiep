<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateAccountClientRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có quyền thực hiện yêu cầu này không.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check(); // Chỉ cho phép người dùng đã đăng nhập
    }

    /**
     * Các quy tắc validation áp dụng cho request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Thêm rule cho avatar
            'old_password' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if ($this->filled('new_password') && !$this->filled($attribute)) {
                        $fail('Vui lòng nhập mật khẩu cũ khi thay đổi mật khẩu.');
                    }
                },
            ],
            'new_password' => 'nullable|string|min:6',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi cho các quy tắc validation.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên không được bỏ trống.',
            'name.max' => 'Tên không được vượt quá 100 ký tự.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'old_password.required' => 'Mật khẩu cũ là bắt buộc khi thay đổi mật khẩu mới.',
            'old_password.string' => 'Mật khẩu cũ phải là chuỗi ký tự.',
            'new_password.string' => 'Mật khẩu mới phải là chuỗi ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'phone_number.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
            'phone_number.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'avatar.image' => 'Avatar phải là file ảnh.',
            'avatar.mimes' => 'Avatar phải có định dạng jpeg, png, jpg hoặc gif.',
            'avatar.max' => 'Avatar không được lớn hơn 2MB.',
        ];
    }
}