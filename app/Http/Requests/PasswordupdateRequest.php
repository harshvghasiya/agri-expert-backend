<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PasswordupdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    {
       
        return [
            'current_password'=>'required|checkCurrentPassword',
            'password' => 'required|confirmed|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|',
            

        ];
    }

    public function messages()
    {
        return [
            'password.required' => trans('message.password_required'),
            'password.confirmed' => trans('message.password_is_not_match'),
            'password.regex' => trans('message.password_regex'),
            'current_password.required' => trans('message.current_password_required'),
            'current_password.check_current_password' => trans('message.check_current_password'),
           
        ];
    }
}
