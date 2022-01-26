<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8']
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'Inserire un nome',
            'name.unique' => 'Il nickname inserito è stato già preso',
            'email.required' => 'Inserire un indirizzo email',
            'email.unique' => 'L\'email inserita è stata già presa',
            'password.required' => 'Inserire una password',
            'password.min' => 'La password deve contenere almeno :min caratteri',
            'password.confirmed' => 'La password non coincide con la conferma',
        ];
    }
}
