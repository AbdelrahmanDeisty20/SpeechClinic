<?php

namespace App\Http\Requests\API\AUTH;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        $rules = [
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string',
        ];

        // Check if the user is a specialist to loosen password length requirements
        $user = \App\Models\User::where('email', $this->email)->first();
        if (!$user || $user->type !== 'specialist') {
            $rules['password'] .= '|min:8';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'email.required' => __('messages.email_required'),
            'email.email' => __('messages.email_invalid'),
            'email.exists' => __('messages.email_not_exists'),
            'password.required' => __('messages.password_required'),
            'password.min' => __('messages.password_min'),
        ];
    }
}
