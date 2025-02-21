<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
    public function rules()
    {
        return [
            "title" => ["required", "max:255"],
            "image" => [
                "required",
                "file",
                "image",
                "max:2048", // 2MB制限に変更
                "mimes:jpeg,jpg,png",
                "dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000", // より柔軟な解像度制限
            ],
            "body" => ["required", "max:20000"],
        ];
    }
}
