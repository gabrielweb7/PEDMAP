<?php

namespace App\Http\Requests\modulo\eventos;

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
            'titulo'     =>  'required|max:255',
            'dataDoEvento'      => 'required|date_format:d/m/Y H:i'
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }
}
