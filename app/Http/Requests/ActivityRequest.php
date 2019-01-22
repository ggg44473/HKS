<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityRequest extends FormRequest
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
            'title' => 'required',
            'st_date' => 'required|date',
            'fin_date' => 'required|date',
        ];
    }

    public function attributes()
    {
        return [
            'title' => '行程',
            'st_date' => '起始日',
            'fin_date' => '完成日',
        ];
    }
}
