<?php

namespace App\Http\Requests\modulo\usuarios;

use Illuminate\Foundation\Http\FormRequest;

class ResetSenha extends FormRequest
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
            'novaSenha'     =>  'required|min:5|max:99'
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
