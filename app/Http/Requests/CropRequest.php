<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CropRequest extends FormRequest
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
            'title' => 'required|checkCropExit:' . $id . '',
            'query_id' => 'required',
            // 'image' => 'sometimes|mimes:jpeg,jpg,png,jfif',


        ];

        return $data;
    }

    public function messages()
    {
        return [
            'title.required' => trans('message.title_required'),
            'image.mimes' => trans('message.image_mimes'),
            'query_id.required' => trans('message.query_required'),
            'title.check_crop_exit' => trans('message.check_crop_exit'),

        ];
    }
}
