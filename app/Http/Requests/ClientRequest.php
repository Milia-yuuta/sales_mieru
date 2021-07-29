<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'sei' => 'required',
            'mei' => 'required',
            'zip_code' => 'required |max:7',
            'address' => 'required',
            'tel' => 'required',
            'email' => 'required | email',
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
            'sei' => '姓',
            'mei' => '名',
            'zip_code' => '郵便番号',
            'address' => '住所',
            'tel' => '電話番号',
            'email' => 'メールアドレス',
        ];
    }
}
