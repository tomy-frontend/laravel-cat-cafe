<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "title" => ["required", "max:255"],
            "image" => [
                "nullable",
                "file",
                "image",
                "max:5120", // 5MB制限に変更
                "mimes:jpeg,jpg,png",
                "dimensions:min_width=50,min_height=50,max_width=4000,max_height=4000", // より柔軟な解像度制限
            ],
            "body" => ["required", "max:20000"],
        ];
    }
}
