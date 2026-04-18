<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class GetMonthlyBookingDetailsRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'booking_number' => 'required|string|exists:bookings,booking_number',
        ];
    }

    /**
     * Get the validation messages.
     */
    public function messages(): array
    {
        return [
            'booking_number.required' => __('messages.booking_number_required'),
            'booking_number.string' => __('messages.booking_number_string'),
            'booking_number.exists' => __('messages.booking_number_exists'),
        ];
    }
}
