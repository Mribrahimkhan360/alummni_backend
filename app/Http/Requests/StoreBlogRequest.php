<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'          => 'required|string|max:255',
            'excerpt'        => 'nullable|string',
            'full_content'   => 'nullable|string',
            'category'       => 'nullable|string|max:50',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'author'         => 'nullable|string|max:255',
            'published_date' => 'nullable|date',
            'read_time'      => 'nullable|string|max:20',
            'is_active'      => 'nullable|boolean',
            'published_at'   => 'nullable|date',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Blog title is required',
            'image.image'    => 'File must be an image.',
        ];
    }
}
