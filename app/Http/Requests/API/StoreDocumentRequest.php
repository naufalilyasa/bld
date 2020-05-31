<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth('api')->user();
        return $user->hasPermissionTo('create a document', 'api');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'             => 'required|string',
            'author'            => 'required|string',
            'publisher'         => 'required|string',
            'category'          => 'required|string',
            'location'          => 'required|string',
            'items_available'   => 'numeric',
            'published_at'      => 'date'
        ];
    }
}
