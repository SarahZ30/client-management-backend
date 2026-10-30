<?php

namespace Modules\ClientManagement\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddClientRequest extends FormRequest
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
        // all the details the user enters in the add client form
        return [
            'name' => 'required',
            'email' => 'required|email|unique:clients',
            'phone' => 'required',
            'company' => 'required',
            'address' => 'required',
            'no_of_employees' => 'nullable|integer',
            'project_budget' => 'required|numeric'
        ];
    }
}
