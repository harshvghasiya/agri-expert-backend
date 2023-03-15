<?php

namespace App\Http\Controllers;

use App\Http\Requests\CropRequest;
use App\Models\Crop;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CropController extends Controller
{
    public function __construct()
    {
        $this->Model = new Crop;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $title = trans("message.crop_title");
        return view('crop.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $title = trans("message.crop_title");
        return view('crop.addedit', compact('title'));
    }

    /**
     * [store used for register crop ]
     * @return [type] [description]
     */
    public function store(CropRequest $request)
    {
        return $this->Model->store($request);
    }

    /**
     * [edit used for edit crop data ]
     * @return [type] [description]
     */
    public function edit(Request $request, $id)
    {
        $encryptedId = $id;
        $id = getDecryptedId($id);
        $title = trans('message.crop_edit');
        $crop = $this->Model->getSingleData($id);
        return view('crop.addedit', compact('title', 'crop', 'encryptedId'));
    }

    /**
     * [view used for view crop data ]
     * @return [type] [description]
     */
    public function view(Request $request, $id)
    {
        $id = getDecryptedId($id);
        $title = trans('message.view_crop');
        $crop = $this->Model->getSingleData($id);
        return view('crop.view', compact('title', 'crop'));
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
    public function update(CropRequest $request, $id)
    {
        return $this->Model->store($request, $id);
    }

    /**
     * [destroy used for destroy crop data ]
     * @return [type] [description]

     */
    public function destroy(Request $request, $id)
    {
        $request['checkbox'] = [$id];
        return $this->Model->deleteAll($request);
    }

    /**
     * [anyData used for get crop ]
     * @return [type] [description]
     */
    public function anyData(Request $request)
    {
        return $this->Model->getListData($request);
    }

}
