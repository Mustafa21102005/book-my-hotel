<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:standard,deluxe,suite'],
            'price' => ['required', 'numeric', 'min:1'],
            'capacity' => ['required', 'integer', 'min:1'],
            'uploaded_files' => ['nullable', 'string'],
        ];
    }

    /**
     * Return error messages for validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The room name is required.',
            'name.string' => 'The room name must be a valid string.',
            'name.max' => 'The room name may not exceed 255 characters.',

            'type.required' => 'The room type is required.',
            'type.in' => 'The selected room type is invalid. Valid types are: standard, deluxe, suite.',

            'price.required' => 'The price per night is required.',
            'price.numeric' => 'The price per night must be a valid number.',
            'price.min' => 'The price per night must be at least 1.',

            'capacity.required' => 'The room capacity is required.',
            'capacity.integer' => 'The capacity must be a whole number.',
            'capacity.min' => 'The capacity must be at least 1 person.',

            'uploaded_files.string' => 'Uploaded files data must be a valid string.',
        ];
    }
}
