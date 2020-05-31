<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth('api')->user();

        return $user->hasPermissionTo('update a document', 'api');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'             => 'string',
            'author'            => 'string',
            'publisher'         => 'string',
            'category'          => 'string',
            'location'          => 'string',
            'items_available'   => 'numeric',
            'published_at'      => 'date'
        ];
    }
}
