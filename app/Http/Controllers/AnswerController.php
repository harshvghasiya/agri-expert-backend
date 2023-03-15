<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerRequest;
use App\Models\Answer;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AnswerController extends Controller
{
    public function __construct()
    {
        $this->Model = new Answer;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $title = trans("message.answer_title");
        return view('answer.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $title = trans("message.answer_title");
        return view('answer.addedit', compact('title'));
    }

    /**
     * [store used for register answer ]
     * @return [type] [description]
     */
    public function store(AnswerRequest $request)
    {
        return $this->Model->store($request);
    }

    /**
     * [edit used for edit answer data ]
     * @return [type] [description]
     */
    public function edit(Request $request, $id)
    {
        $encryptedId = $id;
        $id = getDecryptedId($id);
        $title = trans('message.answer_edit');
        $answer = $this->Model->getSingleData($id);
        return view('answer.addedit', compact('title', 'answer', 'encryptedId'));
    }

    /**
     * [view used for view answer data ]
     * @return [type] [description]
     */
    public function view(Request $request, $id)
    {
        $id = getDecryptedId($id);
        $title = trans('message.view_answer');
        $answer = $this->Model->getSingleData($id);
        return view('answer.view', compact('title', 'answer'));
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
    public function update(AnswerRequest $request, $id)
    {
        return $this->Model->store($request, $id);
    }

    /**
     * [destroy used for destroy answer data ]
     * @return [type] [description]

     */
    public function destroy(Request $request, $id)
    {
        $request['checkbox'] = [$id];
        return $this->Model->deleteAll($request);
    }

    /**
     * [anyData used for get answer ]
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
        $video = $this->Model->getSingleData(getDecryptedId($request->answer_id));

        $msg = trans('message.video_already_deleted');

        if (\File::exists(answerVideoUploadPath() . $video->video)) {
            \File::delete(answerVideoUploadPath() . $video->video);
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
            if (\File::exists(answerImageUploadPath() . $video->image)) {
                \File::delete(answerImageUploadPath() . $video->image);
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
            if (\File::exists(answerAudioUploadPath() . $video->audio)) {
                \File::delete(answerAudioUploadPath() . $video->audio);
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
