<?php

namespace App\Http\Requests\Admin\Logistics;

use Illuminate\Foundation\Http\FormRequest;

class ShippingRateRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            // Định nghĩa rules
        ];
    }
}