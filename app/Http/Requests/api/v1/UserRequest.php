<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'firstname'         => 'required',
            'lastname'          => 'required',
            'password'          => 'required|min:5',
            'email'             => 'required|email|unique:users'
        ];
    }

    public function messages()
    {
        return [
            'firstname.required'            => 'The firstname is required.',
            'lastname.required'             => 'The lastname is required.',
            'password.required'             => 'The password is required',
            'password.min:5'                => 'The password must contain at least 5 characters.',
            'email.required'                => 'The email is required.',
            'email.email'                   => 'The email is not valid.',
            'email.unique:users'            => 'There is already an account associated with the email.'
        ];
    }
}
