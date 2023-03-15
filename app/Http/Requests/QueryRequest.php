<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class QueryRequest extends FormRequest
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
            'title' => 'required|checkQueryExit:' . $id . '',

        ];

        return $data;
    }

    public function messages()
    {
        return [
            'title.required' => trans('message.title_required'),
            'title.check_query_exit' => trans('message.check_crop_exit'),

        ];
    }
}
