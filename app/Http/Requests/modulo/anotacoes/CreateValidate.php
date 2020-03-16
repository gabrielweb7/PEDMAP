<?php

namespace App\Http\Requests\modulo\anotacoes;

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
            'anotacoes'     =>  'required|max:255',
            'bairro_id'      => 'required'
        ];
    }

    public function messages()
    {
        return [
            'bairro_id.required' => 'O campo bairro é obrigatório'
        ];
    }

}
