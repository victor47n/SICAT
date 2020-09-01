<?php

namespace App\Http\Requests;

use App\Rules\ItemStock;
use Illuminate\Foundation\Http\FormRequest;

class StoreBorrowingRequest extends FormRequest
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
            'requester' => 'required|string',
            'phone_requester' => 'nullable',
            'email_requester' => 'required|email',
            'office_requester' => 'required|string',
            'acquisition_date' => 'required|date',
            'status_id' => 'required|numeric',
            'items' => ['required', 'array', new ItemStock],
        ];
    }

    public function messages()
    {
        return [
            'requester.required' => 'O campo nome do requisitante é obrigatório.',
            'email_requester.required' => 'O campo email é obrigatório.',
            'email.email' => 'Por favor, insira um email válido.',
            'office_requester.required' => 'O campo cargo é obrigatório.',
            'acquisition_date.required' => 'O campo data de aquisição é obrigatório.',
            'status_id.required' => 'O campo status é obrigatório.',
            'items.required' => 'É obrigatório ter itens.',
        ];
    }
}
