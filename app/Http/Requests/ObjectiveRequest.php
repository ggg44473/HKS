<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObjectiveRequest extends FormRequest
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
            'obj_title' => 'required',
            'st_date' => 'required',
            'fin_date' => 'required|different:st_date',
        ];
    }

    public function attributes()
    {
        return [
            'obj_title' => '目標',
            'st_date' => '起始日',
            'fin_date' => '完成日',
        ];
    }

    public function messages()
    {
        return [
            'obj_title.required' => ':attribute 不可空白',
            'st_date.required' => ':attribute 不可空白',
            'fin_date.required' => ':attribute 不可空白',
        ];
    }

}
