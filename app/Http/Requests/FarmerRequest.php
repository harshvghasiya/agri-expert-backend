<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class FarmerRequest extends FormRequest
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
            'mobile' => 'required|checkFarmerMobileExit:' . $id . '|regex:/[0-9]{9}/',
            'name' => 'required',
            'village' => 'required',

        ];

        return $data;
    }

    public function messages()
    {
        return [
            'mobile.required' => trans('message.mobile_required'),
            'name.required' => trans('message.name_required'),
            'mobile.regex' => trans('message.invalid_mobile_number'),
            'village.required' => trans('message.village_required'),
            'mobile.check_farmer_mobile_exit' => trans('message.check_farmer_exist_exit'),

        ];
    }
}
