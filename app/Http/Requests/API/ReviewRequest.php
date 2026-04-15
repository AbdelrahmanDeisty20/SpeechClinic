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
            'comment' => 'required|string|min:8|max:255',
            'rate' => 'required|in:1,2,3,4,5',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => __('messages.name_required'),
            'name.min' => __('messages.name_min'),
            'comment.required' => __('messages.comment_required'),
            'comment.min' => __('messages.comment_min'),
            'rate.required' => __('messages.rate_required'),
            'rate.in' => __('messages.rate_in'),
        ];
    }
}
