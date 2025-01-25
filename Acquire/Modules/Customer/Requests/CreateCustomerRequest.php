<?php

namespace Acquire\Modules\Customer\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'string',
                'max:255',
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                Rule::unique('customer', 'email'),
                Rule::email()->rfcCompliant(strict: false)->preventSpoofing(),
            ],
            'dob' => [
                'required',
                'date',
            ],
            'age' => [
                'required',
                'numeric',
                'between:1,120',
            ],
        ];
    }

    /**
     * Get the custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'The email address is mandatory.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'dob.required' => 'Date of birth is required.',
            'dob.date' => 'Date of birth must be a valid date.',
            'age.required' => 'Age is required.',
            'age.numeric' => 'Age must be a number.',
        ];
    }
}
