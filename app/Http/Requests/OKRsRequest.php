<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OKRsRequest extends FormRequest
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
        dd($this);
        return [
            'obj_title' => 'required',
            'st_date' => 'required',
            'fin_date' => 'required|different:st_date',
            'krs_title' => 'required',
            // 'krs_conf' => 'required',
            // 'krs_init' => 'required',
            // 'krs_tar' => 'required|different:krs_init',
            // 'krs_now' => 'required',
            // 'krs_weight' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'obj_title' => '目標',
            'st_date' => '起始日',
            'fin_date' => '完成日',
            'krs_title.$keyresult->id' => '關鍵指標',
            // 'krs_conf' => '信心值',
            // 'krs_init' => '起始值',
            // 'krs_tar' => '目標值',
            // 'krs_now' => '當前值',
            // 'krs_weight' => '權重',
        ];
    }

    public function messages()
    {
        return [
            'obj_title.required' => ':attribute 不可空白',
            'st_date.required' => ':attribute 不可空白',
            'fin_date.required' => ':attribute 不可空白',
            'krs_title.$keyresult->id.required' => ':attribute 不可空白',
            // 'krs_conf.required' => ':attribute 不可空白',
            // 'krs_init.required' => ':attribute 不可空白',
            // 'krs_tar.required' => ':attribute 不可空白',
            // 'krs_now.required' => ':attribute 不可空白',
            // 'krs_weight.required' => ':attribute 不可空白',
        ];
    }

}
