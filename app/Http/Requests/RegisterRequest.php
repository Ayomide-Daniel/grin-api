<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseFormRequest;

class RegisterRequest extends BaseFormRequest
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
            "name" => 'required|string|max:255',
            "email" => "required|string|email:filter|max:255|unique:users",
            "gender" => ["required", "string", Rule::in(["male", "female"])],
            "country" => "required|string|max:255",
            "password" => "required|string|min:6|confirmed",
            "password_confirmation" => "required|string|min:6",
        ];
    }
}
