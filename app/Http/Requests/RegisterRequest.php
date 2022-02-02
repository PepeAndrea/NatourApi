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
            'name.required' => 'Inserire un nickname',
            'name.unique' => 'Il nickname è già esistente',
            'email.required' => 'Inserire un indirizzo email',
            'email.unique' => 'L\'email è già associata ad un account',
            'email.email' => 'Inserisci un\'email valida',
            'password.required' => 'Inserisci una password',
            'password.min' => 'La password deve contenere almeno :min caratteri',
            'password.confirmed' => 'La password non coincide con la conferma',
        ];
    }
}
