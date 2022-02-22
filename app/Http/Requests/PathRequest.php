<?php

namespace App\Http\Requests;

use App\Models\Coordinate;
use Illuminate\Foundation\Http\FormRequest;

class PathRequest extends FormRequest
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
            //Path data
            'title' => "required|string",
            'description' => "required|string",
            'location' => "required|string",
            //'difficulty_id' => "required|integer|exists:difficulties,id",
            'difficulty' => "required|string",
            'disability' => "required|boolean",
            'length' => "required|numeric|between:0,999.99",
            'duration' => "required|numeric",
            //Coordinates data
            'coordinates' => 'required|array',
            'coordinates.*.latitude' => 'required|numeric|between:-9999.9999999,9999.9999999',
            'coordinates.*.longitude' => 'required|numeric|between:-9999.9999999,9999.9999999',
            //Interest Point Data
            'interest_points' => 'array',
            'interest_points.*.title' => "required|string",
            'interest_points.*.description' => "required|string",
            'interest_points.*.category' => "required|string",
            //'interest_points.*.category_id' => "required|integer|exists:categories,id",
            'interest_points.*.latitude' => "required|numeric|between:-9999.9999999,9999.9999999",
            'interest_points.*.longitude' => "required|numeric|between:-9999.9999999,9999.9999999",
        ];
    }

    public function messages()
    {
        return [
            //TODO: Creare messaggi di validazione
        ];
    }
}
