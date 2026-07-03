<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(auth()->id()),
            ],
            'gender'                => 'nullable|in:male,female,other',

            'organization'          => 'nullable|string|max:2048',

            'student_id'            => 'nullable|string|max:255',
            'passing_year'          => 'nullable|integer|min:1950|max:' . (date('Y') + 10),
            'department'            => 'nullable|string|max:255',

            // IMAGE
            'image'                 =>  'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'bio'                   => 'nullable|string|max:5000',

            //  Job Title
            'job_title'             => 'nullable|string|max:255',
            'company_name'          => 'nullable|string|max:255',
            'employment_type'       => 'nullable|string|max:255',
            'start_date'            => 'nullable|date',
            'currently_working'     => 'nullable|boolean',
            'job_description'       => 'nullable|string',
        ];
    }
}
