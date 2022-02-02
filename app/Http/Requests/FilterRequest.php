<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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
            'difficulty' => "array",
            'difficulty.*' => "integer",
            'disability' => "boolean",
            'length' => "numeric|between:0.1,999.99",
            'duration' => "numeric|between:0.01,99.99",
        ];
    }

    public function messages()
    {
        return [
            //TODO: Creare messaggi di validazione
        ];
    }
}