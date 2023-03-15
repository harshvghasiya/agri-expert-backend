<?php

namespace App\Http\Requests;

use App\Models\BasicSetting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    {
        $captcha = BasicSetting::select('is_recaptcha')->first();
        $data = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        if (isset($captcha->is_recaptcha) && $captcha->is_recaptcha == 1) {
            $data['g-recaptcha-response'] = "required|recaptchav3:register,0.5";
        }

        return $data;
    }

    public function messages()
    {
        return [
            'email.required' => trans('message.email_required'),
            'email.email' => trans('message.email_valid_form'),
            'password.required' => trans('message.password_required'),
            'g-recaptcha-response.required' => trans('message.g_recaptcha_response_required'),
            'g-recaptcha-response.recaptchav3' => trans('message.g_recaptcha_response_captcha'),

        ];
    }
}
