<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class BorrowsReturnsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth('api')->user();

        return ($user->hasPermissionTo('return a document', 'api') || $user->hasPermissionTo('return documents', 'api'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ids' => 'regex:/[0-9]+(,[0-9]+)*/'
        ];
    }
}
