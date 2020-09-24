<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderServiceRequest extends FormRequest
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
            'problem' => 'required',
            'problem_type' =>'required',
            'locale_id' => 'required|numeric',
            'workstation_id' => 'required|numeric',
            'realized_date' => 'required|date',
            'status_id' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'problem.required' => 'O campo descrição do problema é obrigatório.',
            'problem_type.required' => 'O tipo do problema é obrigatório.',
            'locale_id.required' => 'O local é obrigatório.',
            'locale_id.numeric' => 'O local deve ser um id',
            'workstation_id.required' => 'O posto de trabalho é obrigatório.',
            'workstation_id.numeric' => 'O posto de trabalho deve ser um id',
            'realized_date.required' => 'O campo data de realização é obrigatório.',
            'realized_date.date' => 'O campo data de realização deve ser válido',
            'status_id.required' => 'O status da ordem de serviço é obrigatório.',
            'status_id.numeric' => 'O status da ordem de serviço deve ser um id',
        ];
    }
}
