<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BookingMonthlyRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'booking_number' => 'required|string|exists:bookings,booking_number,type,assessment',
            'child_photo' => 'required|image',
        ];
    }
    public function messages(): array
    {
        return [
            'booking_number.required' => __('messages.booking_number_required'),
            'booking_number.string' => __('messages.booking_number_string'),
            'booking_number.max' => __('messages.booking_number_max'),
            'child_photo.required' => __('messages.child_photo_required'),
            'child_photo.image' => __('messages.child_photo_image'),
        ];
    }
}
