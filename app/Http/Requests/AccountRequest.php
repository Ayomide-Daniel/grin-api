<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class AccountRequest extends BaseFormRequest
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
            "user_id" => "required|integer",
            "type" => "required|string",
            "tag" => "required|string",
            "value" => "required|string",
            "status" => ["required", "string", Rule::in(["active", "inactive"])],
            "meta" => "nullable|string",
        ];
    }
}
