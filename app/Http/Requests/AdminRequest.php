<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AdminRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(Request $r)
    {
        $input = $r->all();
        $id = !empty($input['id']) ? $input['id'] : "";
        $data = [
            'email' => 'required|email|checkEmailExitAdminUser:' . $id . '',
            'name' => 'required',
            

        ];

        if (isset($id) && !empty($id)) {

            if (isset($input['change_password']) && $input['change_password'] == 1) {

                $data['password'] = 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|';
            }

        } else {

            $data['password'] = 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|';
        }
        return $data;
    }

    public function messages()
    {
        return [
            'name.required' => trans('message.name_required'),
            'password.required' => trans("message.password_required"),
            'email.required' => trans("message.email_required"),
            'email.email' => trans("message.email_not_valid"),
            'password.regex' => trans('message.password_regex'),
            'email.check_email_exit_admin_user' => trans('message.email_exit_admin_user'),

        ];
    }
}
