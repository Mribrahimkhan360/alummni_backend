<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileEducationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $currentYear = date('Y');
        return [
            'degree'            => 'required|string|max:255',
            'institution'       => 'required|string|max:255',
            'start_year'        => 'required|integer|digits:4|min:1900|max:' . $currentYear,
            'end_year'          => 'nullable|integer|digits:4|min:1900|max:' . $currentYear . '|after_or_equal:start_year'
        ];
    }

    public function messages(): array
    {
        return [
            'degree.required'        => 'Degree is required',
            'institution.required'   => 'Institution is required',
            'start_year.required'    => 'Start year is required',
            'end_year.required'      => 'End year is required',
        ];
    }
}
