<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /* 認証なしに変更（常にリクエストを発行できる） */
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
            'name' => 'required',
            'content' => 'required|min:10'
        ];
    }

    /* 検知されたバリデーションエラーと、表示するメッセージを関連付けする */
    public function messages()
    {
        return [
            'name.required'  => trans('validation.required'),
            'content.required'  => trans('validation.required'),
            'content.min'  => trans('validation.min')
        ];
    }
}
