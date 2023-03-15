<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AnswerRequest extends FormRequest
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
            'answer' => 'sometimes|checkAnswerExit:' . $id . '',
            'image' => 'sometimes|mimes:jpeg,jpg,png',
            'video' => 'sometimes|mimes:mp4',
            'audio' => 'sometimes|mimes:mp3',


        ];

        return $data;
    }

    public function messages()
    {
        return [
            'answer.sometimes' => trans('message.answer_required'),
            'answer.check_answer_exit' => trans('message.answer_already_exist'),
            'image.mimes' => trans('message.image_mimes'),
            'video.mimes' => trans('message.video_mimes'),
            'audio.mimes' => trans('message.audio_mimes'),

        ];
    }
}
