<?php

namespace App\Http\Requests\Admin\Catalog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('category') ? $this->route('category')->id : null;

        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($id)
            ],
            'parent_id' => [
                'nullable',
                'integer',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($id) {
                    if ($id && $value == $id) {
                        $fail('Danh mục cha không thể là chính nó.');
                    }
                },
            ],
            'position' => 'integer|min:0',
            'is_active' => 'boolean',
            'fa_icon' => 'nullable|string|max:50',
            'fa_icon_back' => 'nullable|string|max:50',
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'slug.unique' => 'Đường dẫn (Slug) đã tồn tại.',
            'parent_id.exists' => 'Danh mục cha không hợp lệ.',
        ];
    }
}
