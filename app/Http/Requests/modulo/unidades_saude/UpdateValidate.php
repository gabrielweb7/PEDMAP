<?php

namespace App\Http\Requests\modulo\unidades_saude;

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
            'nome'     =>  'required|max:59',
            'cod'     =>  'max:10',
            'endereco'     =>  'max:40',
            'bairro'     =>  'max:20',
            'cidade'     =>  'max:12',
            'telefone'     =>  'max:14',
            'estrutura_fisica'     =>  'max:48',
            'adap_defic_fisic_idosos'     =>  'max:48',
            'equipamentos'     =>  'max:48',
            'medicamentos'     =>  'max:48'
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'Você precisa informar um nome para o registro!',
            'adap_defic_fisic_idosos.max' => 'O campo Acessibilidade não pode ser superior a 48 caracteres.',
        ];
    }
}
