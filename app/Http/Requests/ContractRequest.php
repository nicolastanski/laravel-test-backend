<?php

namespace Accordous\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractRequest extends FormRequest
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
            'property_id' => 'required|numeric',
            'name' => 'required',
            'email' => 'required|email',
            'document_type' => 'required',
            'document_number' => 'required'
        ];
    }
}
