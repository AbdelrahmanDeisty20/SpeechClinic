<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'message' => 'required|string|min:8|max:255',
            'rating' => 'required|in:1,2,3,4,5',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => __('messages.name_required'),
            'name.min' => __('messages.name_min'),
            'email.required' => __('messages.email_required'),
            'email.email' => __('messages.email_invalid'),
            'phone.required' => __('messages.phone_required'),
            'message.required' => __('messages.message_required'),
            'message.min' => __('messages.message_min'),
            'rating.required' => __('messages.rating_required'),
            'rating.in' => __('messages.rating_in'),
        ];
    }
}
