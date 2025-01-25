<?php

namespace Acquire\Modules\Customer\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
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
                Rule::unique('customer', 'email')->ignoreModel($this->customer),
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
}
