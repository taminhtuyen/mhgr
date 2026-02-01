<?php

namespace App\Http\Requests\Admin\Technical;

use Illuminate\Foundation\Http\FormRequest;

class QueueJobRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array { return []; }
}
