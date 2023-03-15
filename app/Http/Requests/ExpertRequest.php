<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ExpertRequest extends FormRequest
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
            'name' => 'required|min:4',
            'email' => 'required|email|checkExpertEmailExit:' . $id . '',
        ];

        if (isset($id) && !empty($id)) {

            if (isset($input['change_password']) && $input['change_password'] == 1) {

                $data['password'] = 'required|min:4';
            }

        } else {

            $data['password'] = 'required|min:4';
        }

        return $data;
    }

    public function messages()
    {
        return [
            'name.required' => trans('message.name_required'),
            'password.required' => trans('message.password_required'),
            'email.required' => trans('message.email_required'),
            'email.email' => trans("message.email_not_valid"),
            'email.check_expert_email_exit' => trans('message.email_exit_expert'),

        ];
    }
}
