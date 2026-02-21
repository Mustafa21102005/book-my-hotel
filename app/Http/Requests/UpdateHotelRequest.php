<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHotelRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('hotels', 'name')->ignore($this->hotel->id),
            ],
            'description' => ['nullable', 'string'],
            'region' => ['required', 'in:asia,europe'],
            'country' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'street' => ['required', 'string', 'max:255'],
            // checkboxes
            'breakfast' => ['nullable', 'boolean'],
            'wifi' => ['nullable', 'boolean'],
            'pool' => ['nullable', 'boolean'],
            'gym' => ['nullable', 'boolean'],
            'pets_allowed' => ['nullable', 'boolean'],
            'environment' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert checkboxes to booleans
        $this->merge([
            'breakfast' => $this->has('breakfast'),
            'wifi' => $this->has('wifi'),
            'pool' => $this->has('pool'),
            'gym' => $this->has('gym'),
            'pets_allowed' => $this->has('pets_allowed'),
            'environment' => $this->has('environment'),
        ]);
    }
}
