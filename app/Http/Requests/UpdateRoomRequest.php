<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
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
            'uploaded_files' => ['nullable', 'string']
        ];
    }

    /**
     * Returns an array of validation error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The room name is required.',
            'name.string' => 'The room name must be a valid string.',
            'name.max' => 'The room name may not be greater than 255 characters.',

            'type.required' => 'The room type is required.',
            'type.in' => 'The selected room type is invalid. Valid types are standard, deluxe, or suite.',

            'price.required' => 'The room price is required.',
            'price.numeric' => 'The room price must be a number.',
            'price.min' => 'The room price must be at least 1.',

            'capacity.required' => 'The room capacity is required.',
            'capacity.integer' => 'The room capacity must be a whole number.',
            'capacity.min' => 'The room capacity must be at least 1.',

            'uploaded_files.string' => 'Uploaded files input must be a valid string.'
        ];
    }
}
