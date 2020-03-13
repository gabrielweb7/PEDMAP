<?php

namespace App\Http\Requests\modulo\problemas_bairro;

use Illuminate\Foundation\Http\FormRequest;

class CreateValidate extends FormRequest
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
            'problema'     =>  'required|max:255',
            'visivel'      => 'required'
        ];
    }

    public function messages()
    {
        return [
            'problema.required' => 'Você precisa informar um problema antes de criar um registro!',
        ];
    }

}
