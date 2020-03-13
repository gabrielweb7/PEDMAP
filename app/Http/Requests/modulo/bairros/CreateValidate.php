<?php

namespace App\Http\Requests\modulo\bairros;

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
            'bairro'     =>  'required|max:100',
            'regiao'     =>  'max:100',
            'cidade_id'      => 'required'
        ];
    }

    public function messages()
    {
        return [
            'cidade_id.required' => 'O campo cidade é obrigatório'
        ];
    }

}
