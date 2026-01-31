<?php

namespace App\Http\Requests\Admin\Logistics;

use Illuminate\Foundation\Http\FormRequest;

class ShippingPartnerRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            // Định nghĩa rules
        ];
    }
}