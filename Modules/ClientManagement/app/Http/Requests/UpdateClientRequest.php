<?php

namespace Modules\ClientManagement\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
        // only phone, address and project budget can be edited
        return [
            'id' => 'required|exists:clients,id',
            'phone' => 'required',
            'address' => 'required',
            'project_budget' => 'required|numeric'
        ];
    }
}
