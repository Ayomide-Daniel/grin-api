<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseFormRequest;

class LocationRequest extends BaseFormRequest
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
            "user_id" => "required|integer|unique:locations,user_id",
            "latitude" => "required|numeric",
            "longitude" => "required|numeric",
            "accuracy" => "required|numeric",
            "status" => ["required", "string", Rule::in(["active", "inactive"])],
        ];
    }
}
