<?php

namespace App\Http\Requests\API\AUTH;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^(\+|0)[0-9]{7,15}$/', 'unique:users,phone'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => __('messages.first_name_required'),
            'last_name.required' => __('messages.last_name_required'),
            'phone.required' => __('messages.phone_required'),
            'phone.regex' => __('messages.phone_invalid'),
            'phone.unique' => __('messages.phone_exists'),
            'email.required' => __('messages.email_required'),
            'email.email' => __('messages.email_invalid'),
            'email.unique' => __('messages.email_exists'),
            'password.required' => __('messages.password_required'),
            'password.min' => __('messages.password_min'),
            'password.confirmed' => __('messages.password_confirmed'),
        ];
    }
}
