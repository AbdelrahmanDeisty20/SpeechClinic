<?php

namespace App\Http\Requests\API\AUTH;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => ['nullable', 'string', 'max:255', 'regex:/^(\+20|0)?1[0125][0-9]{8}$/'],
            'email' => ['nullable', 'string', 'max:255', 'unique:users,email,' . auth()->user()->id,'email'],
        ];
    }
    public function messages(): array
    {
        return [
            'first_name.nullable' => __('messages.first_name_nullable'),
            'first_name.string' => __('messages.first_name_string'),
            'first_name.max' => __('messages.first_name_max'),
            'last_name.nullable' => __('messages.last_name_nullable'),
            'last_name.string' => __('messages.last_name_string'),
            'last_name.max' => __('messages.last_name_max'),
            'phone.nullable' => __('messages.phone_nullable'),
            'phone.string' => __('messages.phone_string'),
            'phone.max' => __('messages.phone_max'),
            'phone.regex' => __('messages.phone_invalid'),
            'email.nullable' => __('messages.email_nullable'),
            'email.string' => __('messages.email_string'),
            'email.max' => __('messages.email_max'),
            'email.unique' => __('messages.email_exists'),
            'email.email' => __('messages.email_invalid'),
        ];
    }
}
