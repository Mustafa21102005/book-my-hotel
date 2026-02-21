<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHotelRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:hotels,name'],
            'description' => ['nullable', 'string'],
            'region' => ['required', 'in:asia,europe'],
            'country' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'street' => ['required', 'string', 'max:255'],
            'uploaded_files' => ['nullable', 'string'],
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

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The hotel name is required.',
            'name.string' => 'The hotel name must be a valid string.',
            'name.max' => 'The hotel name may not be greater than 255 characters.',
            'name.unique' => 'The hotel name has already been taken.',

            'description.string' => 'The description must be a valid string.',

            'region.required' => 'Please select a region.',
            'region.in' => 'The selected region is invalid. Valid options are: asia, europe.',

            'country.required' => 'The country is required.',
            'country.string' => 'The country must be a valid string.',
            'country.max' => 'The country may not be greater than 100 characters.',

            'city.required' => 'The city is required.',
            'city.string' => 'The city must be a valid string.',
            'city.max' => 'The city may not be greater than 100 characters.',

            'street.required' => 'The street is required.',
            'street.string' => 'The street must be a valid string.',
            'street.max' => 'The street may not be greater than 255 characters.',

            'uploaded_files.string' => 'Uploaded files must be a valid string.',

            'breakfast.boolean' => 'Breakfast must be true or false.',
            'wifi.boolean' => 'Wi-Fi must be true or false.',
            'pool.boolean' => 'Pool must be true or false.',
            'gym.boolean' => 'Gym must be true or false.',
            'pets_allowed.boolean' => 'Pets Allowed must be true or false.',
            'environment.boolean' => 'Environment must be true or false.',
        ];
    }
}
