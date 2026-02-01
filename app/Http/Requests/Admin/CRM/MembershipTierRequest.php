<?php

namespace App\Http\Requests\Admin\CRM;

use Illuminate\Foundation\Http\FormRequest;

class MembershipTierRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array { return []; }
}
