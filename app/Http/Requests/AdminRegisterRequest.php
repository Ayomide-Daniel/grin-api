<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class AdminRegisterRequest extends BaseFormRequest
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
            "name" => "required|string",
            "email" => "required|email:filter|unique:admins,email",
            "password" => "required|string|min:8",
            "status" => ["required", "string", Rule::in(["active", "inactive"])],
        ];
    }
}