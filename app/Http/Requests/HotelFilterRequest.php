<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelFilterRequest extends FormRequest
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
            'region'   => 'nullable|string',
            'rating'   => 'nullable|integer|min:1|max:5',
            'country'  => 'nullable|string',
            'city'     => 'nullable|string',
            'wifi'     => 'nullable|boolean',
            'pool'     => 'nullable|boolean',
            'breakfast' => 'nullable|boolean',
            'gym'      => 'nullable|boolean',
            'pets_allowed' => 'nullable|boolean',
            'environment'  => 'nullable|boolean',
        ];
    }
}
