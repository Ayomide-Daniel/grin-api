<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class FriendRequestRequest extends BaseFormRequest
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
            "sender_id" => "required|integer",
            "receiver_id" => "required|integer",
            "accepted" => "nullable|boolean"
        ];
    }
}
