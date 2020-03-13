<?php

namespace App\Http\Requests\modulo\blank;

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
            'imagem'     =>  'image|mimes:jpeg,png,jpg,gif|max:3000'
        ];
    }

    public function messages()
    {
        return [
            'imagem.image' => 'Você só pode fazer upload de imagens!',
            'imagem.mimes'  => 'Extensões permitidas: jpeg,png,jpg,gif.',
            'imagem.max.file'  => 'Tamanho máximo permitido para imagem: 3mb'
        ];
    }
}
