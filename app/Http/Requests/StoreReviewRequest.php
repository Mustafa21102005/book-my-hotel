<?php

namespace App\Http\Requests;

use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $bookingId = $this->input('booking_id');

        return auth()->check() &&
            Booking::where('id', $bookingId)
            ->where('user_id', auth()->id())
            ->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'booking_id' => ['required', 'exists:bookings,id'],
            'rating'     => ['required', 'integer', 'min:1', 'max:5'],
            'title'      => ['required', 'string', 'max:255'],
            'comment'    => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Return error messages for validation.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'booking_id.required' => 'The booking ID is required.',
            'booking_id.exists' => 'The booking ID does not exist.',
            'rating.required' => 'The rating is required.',
            'rating.integer' => 'The rating must be an integer.',
            'rating.min' => 'The rating must be at least 1.',
            'rating.max' => 'The rating must be at most 5.',
            'title.required' => 'The title is required.',
            'title.string' => 'The title must be a valid string.',
            'title.max' => 'The title must not exceed 255 characters.',
            'comment.string' => 'The comment must be a valid string.',
            'comment.max' => 'The comment must not exceed 1000 characters.',
        ];
    }
}
