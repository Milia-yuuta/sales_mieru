<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProspectRequest extends FormRequest
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
            'date' => 'required | before:tomorrow',
            'TopGeneratingMedium' => 'min:1',
            'stage_action_master_id' => 'min:1',
            'generating_medium_master_id' => 'required | gte:1'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            '*.required' => ':attributeを入力してください。',
            '*.before' => ':attributeが未来の日付です。',
            '*.required_with' => ':attributeを入力してください。',
            '*.min' => ':attributeを入力してください',
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
            'property_id' => '顧客ID',
            'TopGeneratingMedium' => '発生媒体',
            'stage_action_master_id' => 'ステージ',
            'generating_medium_master_id' => '発生媒体',
            'date' => '日付',
        ];
    }
}
