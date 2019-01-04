<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KeyResultRequest extends FormRequest
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
            'krs_title' => 'required',
            'krs_conf' => 'required|numeric|min:0|max:10',
            'krs_init' => 'required',
            'krs_tar' => 'required|different:krs_init',
            'krs_now' => 'required',
            'krs_weight' => 'required|numeric|min:0.1|max:2',
        ];
    }

    public function attributes()
    {
        return [
            'krs_title' => '關鍵指標',
            'krs_conf' => '信心值',
            'krs_init' => '起始值',
            'krs_tar' => '目標值',
            'krs_now' => '當前值',
            'krs_weight' => '權重',
        ];
    }

    public function messages()
    {
        return [
            'krs_title.required' => '不可空白!',
            'krs_conf.required' => '不可空白!',
            'krs_init.required' => '不可空白!',
            'krs_tar.required' => '不可空白!',
            'krs_now.required' => '不可空白!',
            'krs_weight.required' => '不可空白!',
            'krs_tar.different' => '與起始值需不同',
            'krs_conf.min' =>'須大於 0',
            'krs_conf.max' =>'須小於 10',
            'krs_weight.min' =>'須大於 0.1',
            'krs_weight.max' =>'須小於 2',
        ];
    }

}
