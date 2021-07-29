<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DailyReportActionLogRequst extends FormRequest
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
        $rules = [
            'daily_report_id' => 'required',
            'action_master_id' => 'required',
            'start_time' =>'required',
            'end_time' => 'required'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            '*.required' => ':attributeを入力してください。',
            '*.required_with' => ':attributeを入力してください。',
            '*.email' => ':attributeの形式が正しくありません。',
            '*.unique' => 'この:attributeはすでに登録されています。',
            '*.confirmed' => 'パスワードが一致していません。',
            '*.same' => 'パスワードが一致していません。',
            '*.confirmed' => 'パスワードが一致していません。',
            '*.regex' => ':attributeの形式が無効です。',
            '*.mimes' => ':attributeの形式が無効です。',
            '*.max' => '::attributeのサイズが大きすぎます。',
        ];
    }

    public function attributes()
    {
        return [
            'daily_report_id' => '日報ID',
            'user_id' => 'ユーザーID',
            'start_time' => '開始時間',
            'end_time' => '終了時間',
        ];
    }
}
