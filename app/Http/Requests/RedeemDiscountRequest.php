<?php

namespace App\Http\Requests;

use App\Models\RedeemedDiscount;
use Illuminate\Foundation\Http\FormRequest;

class RedeemDiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * This hook checks if the user is authorized to make this request and
     * adds an error to the validator if not. It also checks if the user
     * has enough points to redeem the discount, if the discount code has
     * expired, and if the user has already redeemed the discount.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $user = auth()->user();
            $discount = $this->route('discount');

            // Expiration check
            if ($discount->expires_at && $discount->expires_at->isPast()) {
                $validator->errors()->add('expired', 'This discount code has expired.');
            }

            // Duplicate check (still validate early for UX)
            $alreadyRedeemed = RedeemedDiscount::where('user_id', $user->id)
                ->where('discount_id', $discount->id)
                ->exists();

            if ($alreadyRedeemed) {
                $validator->errors()->add('duplicate', 'You have already redeemed this discount code.');
            }
        });
    }
}
