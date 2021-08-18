<?php

namespace App\Http\Requests\Administration\Files;

use App\Models\Administration\File;
use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends FormRequest
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
        return File::$rules;
    }

    public function messages()
    {
        return File::$messages;
    }
}
