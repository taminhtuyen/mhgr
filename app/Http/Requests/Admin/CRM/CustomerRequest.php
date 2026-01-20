<?php

namespace App\Http\Requests\Admin\CRM;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cho phép Admin thực hiện
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // Lấy ID từ route nếu đang ở trang Sửa (Route: admin/crm/customers/{customer})
        // Tham số 'customer' trong route resource trỏ tới ID của user
        $id = $this->route('customer') ? $this->route('customer') : null;

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20|regex:/^[0-9\-\+\s\(\)]*$/',
            'status' => 'required|in:active,inactive,banned',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Các trường thông tin phụ (nếu có trong bảng users hoặc user_profiles)
            'gender' => 'nullable|in:male,female,other',
            'birthday' => 'nullable|date',
        ];

        // Xử lý mật khẩu:
        // - Nếu là Thêm mới (POST): Bắt buộc
        // - Nếu là Cập nhật (PUT/PATCH): Có thể để trống (nghĩa là không đổi pass)
        if ($this->isMethod('post')) {
            $rules['password'] = 'required|string|min:6|confirmed';
        } else {
            $rules['password'] = 'nullable|string|min:6|confirmed';
        }

        return $rules;
    }

    /**
     * Custom message tiếng Việt
     */
    public function attributes()
    {
        return [
            'name' => 'Họ và tên',
            'email' => 'Địa chỉ Email',
            'phone' => 'Số điện thoại',
            'password' => 'Mật khẩu',
            'status' => 'Trạng thái',
            'avatar' => 'Ảnh đại diện',
        ];
    }
}
