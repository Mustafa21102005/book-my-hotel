<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscountRequest extends FormRequest
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
            'points_required' => ['required', 'integer', 'min:1'],
            'discount_percent' => ['required', 'integer', 'min:1', 'max:100'],
            'expires_at' => ['nullable', 'date', 'after:today'],
        ];
    }

    public function messages()
    {
        return [
            'points_required.required' => 'The points field is required.',
            'points_required.integer' => 'The points field must be an integer.',
            'points_required.min' => 'The points field must be at least 1.',
            'discount_percent.required' => 'The discount field is required.',
            'discount_percent.integer' => 'The discount field must be an integer.',
            'discount_percent.min' => 'The discount field must be at least 1.',
            'discount_percent.max' => 'The discount field must be at most 100.',
            'expires_at.date' => 'The expiration date must be a valid date.',
            'expires_at.after' => 'The expiration date must be after today.'
        ];
    }
}
