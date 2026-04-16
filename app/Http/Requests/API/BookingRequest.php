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
            'child_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'problem_description' => 'required|string|min:10',
        ];
    }
}
