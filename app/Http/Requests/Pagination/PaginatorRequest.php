<?php

namespace App\Http\Requests\Pagination;

use Illuminate\Foundation\Http\FormRequest;

class PaginatorRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'page_size' => 'sometimes|required|integer',
            'orderBy' => 'sometimes',
            'orderType' => 'required_with:orderBy',
            'searchQuery' => 'sometimes|required|string'
        ];
    }
}
