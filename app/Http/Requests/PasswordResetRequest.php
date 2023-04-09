<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class PasswordResetRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "email" => "required|string|email:filter",
            "password" => "nullable|string|min:6|confirmed",
            "password_confirmation" => "nullable|string",
        ];
    }
}
