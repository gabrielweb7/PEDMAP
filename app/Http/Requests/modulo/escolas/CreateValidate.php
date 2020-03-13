<?php

namespace App\Http\Requests\modulo\escolas;

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
            'ano'     =>  'max:10',
            'cod'     =>  'max:10',
            'nome'     =>  'required|max:86',
            'administracao'     =>  'max:9',
            'zona'     =>  'max:6',
            'municipio'     =>  'max:12',
            'endereco'     =>  'max:48',
            'numero'     =>  'max:10',
            'complemento'     =>  'max:20',
            'bairro'     =>  'max:31',
            'cep'     =>  'max:10',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'Você precisa informar um nome para o registro!',
        ];
    }

}
