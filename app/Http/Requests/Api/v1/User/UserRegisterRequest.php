<?php

namespace App\Http\Requests\Api\v1\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email'     => 'required|string|email|unique:users',
            'password'  => 'required|min:8'
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required'         => 'The first name field is required.',
            'first_name.string'           => 'The first name must be a string.',
            'last_name.required'         => 'The last name field is required.',
            'last_name.string'           => 'The last name must be a string.',
            'email.required'            => 'The email field is required.',
            'email.string'          => 'The email must be a string.',
            'email.email'           => 'Please enter a valid email address.',
            'email.unique'          => 'This email address is already in use.',
            'password.required'     => 'The password field is required.',
            'password.min'          => 'The password must be at least 8 characters long.',
        ];
    }
}
