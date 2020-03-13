<?php

namespace App\Http\Requests\modulo\cidades;

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
            'nome'     =>  'required|max:255',
            'estado_id'      => 'required'
        ];
    }

    public function messages()
    {
        return [
            'estado_id.required' => 'O campo estado é obrigatório'
        ];
    }

}
