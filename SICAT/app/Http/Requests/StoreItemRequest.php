<?php

namespace App\Http\Requests;

use App\Rules\ItemExist;
use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
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
            'name' => ['required', new ItemExist],
            'amount' => 'required|numeric',
            'type_id' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'amount.required' => 'A quantidade é obrigatória.',
            'amount.numeric' => 'Por favor, insira uma quantidade válida.',
            'type_id.required' => 'O tipo é obrigatório.',
        ];
    }
}
