<?php

namespace App\Http\Requests\API\AUTH\FORGETPASSWORD;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric|digits:6',
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => __('messages.email_required'),
            'email.email' => __('messages.email_invalid'),
            'email.exists' => __('messages.email_not_exists'),
            'otp.required' => __('messages.otp_required'),
            'otp.numeric' => __('messages.otp_invalid'),
            'otp.digits' => __('messages.otp_invalid'),
        ];
    }
}
