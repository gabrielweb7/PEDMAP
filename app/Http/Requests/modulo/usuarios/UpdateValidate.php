<?php

namespace App\Http\Requests\modulo\usuarios;

use Illuminate\Foundation\Http\FormRequest;

class UpdateValidate extends FormRequest
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
            'nome'     =>  'required|min:5|max:255',
            'sobrenome'     =>  'max:255',
            'email'     =>  'required|email|max:255|unique:usuarios,email,'.base64_decode($this->id)
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'Este endereço de email já está sendo usado!'
        ];
    }
}
