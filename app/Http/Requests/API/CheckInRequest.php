<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class CheckInRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'branch_id' => 'required|exists:branches,id',
            'lat' => 'nullable|string',
            'lng' => 'nullable|string',
        ];
    }

    /**
     * Custom messages for validation.
     */
    public function messages(): array
    {
        return [
            'branch_id.required' => __('messages.branch_id_required'),
            'branch_id.exists' => __('messages.branch_not_found'),
        ];
    }
}
