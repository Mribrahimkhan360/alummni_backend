<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileExperienceRequest extends FormRequest
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
            //
            'job_title' => ['required'],
            'company' => ['required'],
            'start_year' => ['required', 'integer', 'digits:4'],
            'end_year' => ['nullable', 'integer', 'digits:4'],
            'currently_working' => ['required', 'boolean'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'job_title.required' => 'Job title is required.',
            'company.required' => 'Company name is required.',
            'start_year.required' => 'Start year is required.',
            'start_year.integer' => 'Start year must be a valid year.',
            'start_year.digits' => 'Start year must be a 4-digit year.',
            'end_year.integer' => 'End year must be a valid year.',
            'end_year.digits' => 'End year must be a 4-digit year.',
            'currently_working.required' => 'Currently working status is required.',
            'currently_working.boolean' => 'Currently working status must be true or false.',
        ];
    }
}
