<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'child_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'problem_description' => 'required|string|min:10',
            'type' => 'required|in:assessment,monthly',
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
            'child_photo.required' => __('messages.child_photo_required'),
            'child_photo.image' => __('messages.child_photo_image'),
            'child_photo.mimes' => __('messages.child_photo_mimes'),
            'child_photo.max' => __('messages.child_photo_max'),
            'problem_description.required' => __('messages.problem_description_required'),
            'problem_description.string' => __('messages.problem_description_string'),
            'problem_description.min' => __('messages.problem_description_min'),
            'type.required' => __('messages.type_required'),
            'type.in' => __('messages.type_invalid'),
        ];
    }
}
