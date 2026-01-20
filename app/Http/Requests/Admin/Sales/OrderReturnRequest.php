<?php

namespace App\Http\Requests\Admin\Sales;

use Illuminate\Foundation\Http\FormRequest;

class OrderReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:orders,id',
            'return_reason' => 'required|string|max:500',
            'refund_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,approved,rejected,completed',
            'items' => 'required|array', // Danh sách sản phẩm trả
        ];
    }

    public function attributes()
    {
        return [
            'order_id' => 'Đơn hàng gốc',
            'return_reason' => 'Lý do trả hàng',
            'refund_amount' => 'Số tiền hoàn lại',
        ];
    }
}