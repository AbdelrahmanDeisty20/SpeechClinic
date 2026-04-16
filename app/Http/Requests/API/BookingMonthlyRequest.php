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
            'available_time_id' => 'required|exists:available_times,id',
            'child_name' => 'required|string|min:3|max:255',
            'child_age' => 'required|integer|min:0|max:18',
            'type' => 'required|in:monthly',
            'booking_number' => 'required|string|exists:bookings,booking_number,type,assessment',
            'child_photo' => 'required|image',
            'problem_description' => 'required|string|min:10',
        ];
    }
    public function messages(): array
    {
        return [
            'available_time_id.required' => __('messages.available_time_required'),
            'available_time_id.exists' => __('messages.available_time_invalid'),
            'child_name.required' => __('messages.child_name_required'),
            'child_name.string' => __('messages.child_name_string'),
            'child_name.min' => __('messages.child_name_min'),
            'child_name.max' => __('messages.child_name_max'),
            'child_age.required' => __('messages.child_age_required'),
            'child_age.integer' => __('messages.child_age_integer'),
            'child_age.min' => __('messages.child_age_min'),
            'child_age.max' => __('messages.child_age_max'),
            'type.required' => __('messages.type_required'),
            'type.in' => __('messages.type_invalid'),
            'booking_number.required' => __('messages.booking_number_required'),
            'booking_number.string' => __('messages.booking_number_string'),
            'booking_number.max' => __('messages.booking_number_max'),
            'child_photo.required' => __('messages.child_photo_required'),
            'child_photo.image' => __('messages.child_photo_image'),
            'problem_description.required' => __('messages.problem_description_required'),
            'problem_description.string' => __('messages.problem_description_string'),
            'problem_description.min' => __('messages.problem_description_min'),
        ];
    }
}
