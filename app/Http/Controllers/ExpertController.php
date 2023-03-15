<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpertRequest;
use App\Models\Expert;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ExpertController extends Controller
{
    public function __construct()
    {
        $this->Model = new Expert;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $title = trans("message.expert_title");
        return view('expert.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $title = trans("message.expert_title");
        return view('expert.addedit', compact('title'));
    }

    /**
     * [store used for register expert ]
     * @return [type] [description]
     */
    public function store(ExpertRequest $request)
    {
        return $this->Model->store($request);
    }

    /**
     * [edit used for edit expert data ]
     * @return [type] [description]
     */
    public function edit(Request $request, $id)
    {
        $encryptedId = $id;
        $id = getDecryptedId($id);
        $title = trans('message.expert_edit');
        $expert = $this->Model->getSingleData($id);
        return view('expert.addedit', compact('title', 'expert', 'encryptedId'));
    }

     /**
     * [view used for view expert data ]
     * @return [type] [description]
     */
    public function view(Request $request, $id)
    {
        $id = getDecryptedId($id);
        $title = trans('message.view_expert');
        $expert = $this->Model->getSingleData($id);
        return view('expert.view', compact('title', 'expert'));
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
    public function update(ExpertRequest $request, $id)
    {
        return $this->Model->store($request, $id);
    }

    /**
     * [destroy used for destroy expert data ]
     * @return [type] [description]

     */
    public function destroy(Request $request, $id)
    {
        $request['checkbox'] = [$id];
        return $this->Model->deleteAll($request);
    }

    /**
     * [anyData used for get expert ]
     * @return [type] [description]
     */
    public function anyData(Request $request)
    {
        return $this->Model->getListData($request);
    }

}
