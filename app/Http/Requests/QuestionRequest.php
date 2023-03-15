<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class QuestionRequest extends FormRequest
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
            'question' => 'sometimes|checkQuestionExit:' . $id . '',
            'image' => 'sometimes|mimes:jpeg,jpg,png',
            'video' => 'sometimes|mimes:mp4',
            'audio' => 'sometimes|mimes:mp3',


        ];

        return $data;
    }

    public function messages()
    {
        return [
            'question.sometimes' => trans('message.question_required'),
            'question.check_question_exit' => trans('message.question_already_exist'),
            'image.mimes' => trans('message.image_mimes'),
            'video.mimes' => trans('message.video_mimes'),
            'audio.mimes' => trans('message.audio_mimes'),

        ];
    }
}
