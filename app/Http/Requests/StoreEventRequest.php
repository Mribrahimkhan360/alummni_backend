<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'title'                 => 'required|string|max:255',
            'description'           => 'nullable|string',
            'venue'                 => 'required|string',
            'entertainment'         => 'nullable',
            'dietary_info'          => 'nullable|string',
            'ticket_prices'         => 'nullable|string',
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'event_date'            => 'nullable|date',
            'event_time'            => 'nullable|string|max:20',
        ];
    }

    public function messages()
    {
        return [
            'title.required'    => 'Event title is required',
            'venue.required'    => 'Venue is required',
            'image.image'       => 'File must be an image.'
        ];
    }
}
