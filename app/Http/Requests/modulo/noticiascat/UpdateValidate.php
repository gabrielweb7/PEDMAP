<?php

namespace App\Http\Requests\modulo\noticiascat;

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
            'categoria'     =>  'required|max:255',
            'visivel'      => 'required'
        ];
    }

    public function messages()
    {
        return [
            'categoria.required' => 'Você precisa informar uma categoria antes de atualizar um registro!',
        ];
    }
}
