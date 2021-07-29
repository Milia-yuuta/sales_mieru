<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProspectActoinLogRequest extends FormRequest
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
            'prospect_id' => 'required',
            'stage_action_master_id' => 'required',
            'status_action_master_id' => 'numeric|min:1',
            'TEL_home' => 'boolean',
            'send_letter' => 'boolean',
            'local_letter' => 'boolean',
            'email' => 'boolean',
            'visit' => 'boolean',
            'pursuit_other' => 'boolean',
            'assessment_report_email' => 'boolean',
            'send_assessment_report' => 'boolean',
            'web_negotiation' => 'boolean',
            'assessment_negotiation' => 'boolean',
            're-negotiation' => 'boolean',
            'visit_caretaker' => 'boolean',
            'TEL_caretaker' => 'boolean',
            'on-site_check' => 'boolean',
            'research_other' => 'boolean',
            're_TEL' => 'boolean',
            're_email' => 'boolean',
            're_letter' => 'boolean',
            're_hp' => 'boolean',
            're_site' => 'boolean',
            're_other' => 'boolean',
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
            '*.boolean' => 'タイプが違います',
            '*.min' => 'ステータスが未選択です',
        ];
    }


    public function attributes()
    {
        return [
            'user_id' => 'ユーザーID',
            'property_id' => '顧客ID',
            'status_action_master_id' => 'ステータス'
        ];
    }
}
