<?php

namespace App\Http\Requests\api\v1;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'     => 'required|email',
            'password'  => 'required|min:8'
        ];
    }

    public function messages() : array
    {
        return [
            'email.required'        => 'The e-mail field is required.',
            'email.email'           => 'The e-mail field is not valid e-mail.',
            'password.required'     => 'The password field is requiered.',
            'password.min:8'        => 'The password field must be at least 8 characters'
        ];
    }
}
