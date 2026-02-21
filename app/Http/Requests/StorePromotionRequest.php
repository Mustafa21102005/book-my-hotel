<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePromotionRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'discount_percent' => ['required', 'integer', 'min:1', 'max:100'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ];
    }

    /**
     * Execute the Validator after validation rules have been checked
     *
     * This hook checks if there is already a promotion with
     * overlapping dates and adds an error to the validator if so.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $hotel = auth()->user()->hotel;

            if (!$hotel) return;

            $start = $this->start_date;
            $end = $this->end_date;

            // When updating, exclude the current promotion ID
            $ignoreId = $this->route('promotion')?->id;

            $overlap = $hotel->promotions()
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->where(function ($q) use ($start, $end) {
                    $q->whereBetween('start_date', [$start, $end])
                        ->orWhereBetween('end_date', [$start, $end])
                        ->orWhere(function ($query) use ($start, $end) {
                            $query->where('start_date', '<=', $start)
                                ->where('end_date', '>=', $end);
                        });
                })
                ->exists();

            if ($overlap) {
                $validator->errors()->add(
                    'start_date',
                    'Another promotion already exists during this date range.'
                );
            }
        });
    }

    /**
     * Get the custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The promotion title is required.',
            'title.string' => 'The promotion title must be a valid string.',
            'title.max' => 'The promotion title may not be greater than 255 characters.',

            'description.string' => 'The promotion description must be a valid string.',

            'discount_percent.required' => 'The discount percentage is required.',
            'discount_percent.integer' => 'The discount percentage must be an integer.',
            'discount_percent.min' => 'The discount percentage must be at least :min%.',
            'discount_percent.max' => 'The discount percentage may not be greater than :max%.',

            'start_date.required' => 'The start date is required.',
            'start_date.date' => 'The start date must be a valid date.',
            'start_date.after_or_equal' => 'The start date must be today or later.',

            'end_date.required' => 'The end date is required.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after_or_equal' => 'The end date must be a date after or equal to the start date.',
        ];
    }
}
