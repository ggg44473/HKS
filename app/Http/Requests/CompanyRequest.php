<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'company_name' => 'required', 
            'company_description' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'company_name' => '組織名稱',
            'company_description' => '組織概述',
        ];
    }
}
