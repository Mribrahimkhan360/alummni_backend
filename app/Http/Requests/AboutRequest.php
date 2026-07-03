<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AboutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [
            'title'                  => 'nullable|string|max:255',
            'sub_title'              => 'nullable|string|max:255',
            'description'            => 'nullable|string',

            'title_secondary'        => 'nullable|string|max:255',
            'sub_title_secondary'    => 'nullable|string|max:255',
            'description_secondary'  => 'nullable|string',

            'image_secondary'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'status'                 => 'nullable|boolean',
        ];
    }

    /**
     * Custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'title.string'                     => 'The title must be text.',
            'title.max'                         => 'The title may not exceed 255 characters.',

            'sub_title.string'                  => 'The sub title must be text.',
            'sub_title.max'                     => 'The sub title may not exceed 255 characters.',

            'description.string'                => 'The description must be text.',

            'title_secondary.string'            => 'The secondary title must be text.',
            'title_secondary.max'               => 'The secondary title may not exceed 255 characters.',

            'sub_title_secondary.string'        => 'The secondary sub title must be text.',
            'sub_title_secondary.max'           => 'The secondary sub title may not exceed 255 characters.',

            'description_secondary.string'      => 'The secondary description must be text.',

            'image_secondary.image'             => 'The file must be an image.',
            'image_secondary.mimes'             => 'The image must be a file of type: jpg, jpeg, png, webp.',
            'image_secondary.max'               => 'The image may not be larger than 2MB.',

            'status.boolean'                    => 'The status field must be true or false.',
        ];
    }

    


}