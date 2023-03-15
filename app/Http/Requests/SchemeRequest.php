<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SchemeRequest extends FormRequest
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
            'title' => 'required',
            'document' => 'sometimes|mimes:pdf',

        ];

        return $data;
    }

    public function messages()
    {
        return [
            'title.required' => trans('message.title_required'),
            'document.mimes' => trans('message.document_mimes'),

        ];
    }
}
