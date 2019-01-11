<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActionRequest extends FormRequest
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
            'act_title' => 'required',
            'st_date' => 'required|date',
            'fin_date' => 'required|date|after:st_date',
            'act_content' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'act_title' => 'Action 具體作為',
            'st_date' => '起始日',
            'fin_date' => '完成日',
            'act_content' => '內容',
        ];
    }


}
