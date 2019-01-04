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
            'krs_title' => $this->validationData()['krs_owner'],
            'krs_conf' => $this->validationData()['krs_owner'],
            'krs_init' => $this->validationData()['krs_owner'],
            'krs_tar' => $this->validationData()['krs_owner'],
            'krs_now' => $this->validationData()['krs_owner'],
            'krs_weight' => $this->validationData()['krs_owner'],
        ];
    }

    public function messages()
    {
        // dd($this->validationData()['krs_owner']);
        return [
            'krs_title.required' => ':attribute 不可空白!',
            'krs_conf.required' => ':attribute 不可空白!',
            'krs_init.required' => ':attribute 不可空白!',
            'krs_tar.required' => ':attribute 不可空白!',
            'krs_now.required' => ':attribute 不可空白!',
            'krs_weight.required' => ':attribute 不可空白!',
            'krs_tar.different' => ':attribute 與起始值需不同',
            'krs_conf.min' =>':attribute 須大於0',
            'krs_conf.max' =>':attribute 須小於10',
            'krs_weight.min' =>':attribute 須大於0.1',
            'krs_weight.max' =>':attribute 須小於2',
        ];
    }

}
