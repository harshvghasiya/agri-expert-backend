<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->Model = new Question;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $title = trans("message.question_title");
        return view('question.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $title = trans("message.question_title");
        return view('question.addedit', compact('title'));
    }

    /**
     * [store used for register Question ]
     * @return [type] [description]
     */
    public function store(QuestionRequest $request)
    {
        return $this->Model->store($request);
    }

    /**
     * [edit used for edit Question data ]
     * @return [type] [description]
     */
    public function edit(Request $request, $id)
    {
        $encryptedId = $id;
        $id = getDecryptedId($id);
        $title = trans('message.question_edit');
        $question = $this->Model->getSingleData($id);
        return view('question.addedit', compact('title', 'question', 'encryptedId'));
    }

    /**
     * [view used for view Question data ]
     * @return [type] [description]
     */
    public function view(Request $request, $id)
    {
        $id = getDecryptedId($id);
        $title = trans('message.view_question');
        $question = $this->Model->getSingleData($id);
        return view('question.view', compact('title', 'question'));
    }

    /**
     * [SingleStatusChange This function is active inactive single record .]
     * @param Request $request [description]
     */
    public function singleStatusChange(Request $request)
    {

        return $this->Model->singleStatusChange($request);
    }

    /**
     * [deleteAll This function is used to delete specific seletec data]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function deleteAll(Request $request)
    {

        return $this->Model->deleteAll($request);
    }

    /**
     * [statusAll This function is used to active or inactive specific selected  record]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function statusAll(Request $request)
    {

        return $this->Model->statusAll($request);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(QuestionRequest $request, $id)
    {
        return $this->Model->store($request, $id);
    }

    /**
     * [destroy used for destroy Question data ]
     * @return [type] [description]

     */
    public function destroy(Request $request, $id)
    {
        $request['checkbox'] = [$id];
        return $this->Model->deleteAll($request);
    }

    /**
     * [anyData used for get Question ]
     * @return [type] [description]
     */
    public function anyData(Request $request)
    {
        return $this->Model->getListData($request);
    }


     /**
     * Delete the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function deleteVideo(Request $request)
    {
        $video = $this->Model->getSingleData(getDecryptedId($request->question_id));

        $msg = trans('message.video_already_deleted');

        if (\File::exists(questionVideoUploadPath() . $video->video)) {
            \File::delete(questionVideoUploadPath() . $video->video);
            $msg = trans('message.video_deleted');
            $video->video = null;
            $video->save();
        }


        return response()->json(['msg' => $msg, 'success' => true]);
    }

    /**
     * Delete the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function deleteThumbnail(Request $request)
    {
        try {
            $video = $this->Model->getSingleData(getDecryptedId($request->thum_id));

            $msg = trans('message.thumbnail_already_deleted');
            if (\File::exists(questionImageUploadPath() . $video->image)) {
                \File::delete(questionImageUploadPath() . $video->image);
                $video->image = null;
                $video->save();
                $msg = trans('message.thumbnail_deleted');
            }

            return response()->json(['msg' => $msg, 'success' => true]);

        } catch (\Exception $e) {

            return response()->json(['msg' => $e->getMessage(), 'success' => false]);

        }
    }

    /**
     * Delete the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function deleteAudio(Request $request)
    {
        try {
            $video = $this->Model->getSingleData(getDecryptedId($request->audio_id));

            $msg = trans('message.audio_already_deleted');
            if (\File::exists(questionAudioUploadPath() . $video->audio)) {
                \File::delete(questionAudioUploadPath() . $video->audio);
                $video->audio = null;
                $video->save();
                $msg = trans('message.audio_deleted');
            }

            return response()->json(['msg' => $msg, 'success' => true]);

        } catch (\Exception $e) {

            return response()->json(['msg' => $e->getMessage(), 'success' => false]);

        }
    }

}
