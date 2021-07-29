<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExcavationBehaviorLogRequest extends FormRequest
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
            'user_id' => 'required',
            'action_date' =>'required | before:tomorrow',
            'area_master_id' => 'required',
            'manager_visit_count' => 'required ',
            'personal_visit_count' => 'required ',
            'DM_distribution_count' => 'required ',
            'flyer_distribution_count' => 'required ',
            'letter_distribution_count' => 'required ',
            'random_visit_implementation_count' => 'required ',
            'random_visit_at_home_count' => 'required ',
            'manager_TEL_count' => 'required ',
            'personal_TEL_count' => 'required ',
            'random_TEL_implementation_count' => 'required ',
            'random_TEL_at_home_count' => 'required ' ,
            'flyer_delivery_count' => 'required ',
            'DM_mail_count' => 'required ',
            'check_building_count' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            '*.required' => ':attributeを入力してください。',
            '*.before' => ':attributeが未来の日付です。',
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
            'user_id' => 'ユーザーID',
            'action_date' =>'行動日',
            'manager_visit_count' => '管理人訪問',
            'personal_visit_count' => '個人訪問',
            'check_building_count' => '一棟チェック',
            'DM_distribution_count' => 'DM手まき',
            'flyer_distribution_count' => '売却チラシ手まき',
            'letter_distribution_count' => '手紙・封書手まき',
            'random_visit_implementation_count' => 'ランダム戸別訪問実施数',
            'random_visit_at_home_count' => 'ランダム戸別訪問在宅数',
            'manager_TEL_count' => '管理人TEL',
            'personal_TEL_count' => '個人TEL',
            'random_TEL_implementation_count' => 'ランダムTEL 実施',
            'random_TEL_at_home_count' => 'ランダムTEL 在宅' ,
            'mail_letter_count' => '手紙・封書郵送',
            'flyer_delivery_count' => '売却チラシ宅配依頼',
            'DM_mail_count' => 'DM_mail_count',
        ];
    }
}
