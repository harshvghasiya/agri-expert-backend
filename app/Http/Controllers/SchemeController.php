<?php

namespace App\Http\Controllers;

use App\Http\Requests\SchemeRequest;
use App\Models\Scheme;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SchemeController extends Controller
{
    public function __construct()
    {
        $this->Model = new Scheme;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $title = trans("message.scheme_title");
        return view('scheme.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $title = trans("message.scheme_title");
        return view('scheme.addedit', compact('title'));
    }

    /**
     * [store used for register scheme ]
     * @return [type] [description]
     */
    public function store(SchemeRequest $request)
    {
        return $this->Model->store($request);
    }

    /**
     * [edit used for edit scheme data ]
     * @return [type] [description]
     */
    public function edit(Request $request, $id)
    {
        $encryptedId = $id;
        $id = getDecryptedId($id);
        $title = trans('message.scheme_edit');
        $scheme = $this->Model->getSingleData($id);
        return view('scheme.addedit', compact('title', 'scheme', 'encryptedId'));
    }

    /**
     * [view used for view scheme data ]
     * @return [type] [description]
     */
    public function view(Request $request, $id)
    {
        $id = getDecryptedId($id);
        $title = trans('message.scheme_view');
        $scheme = $this->Model->getSingleData($id);
        return view('scheme.view', compact('title', 'scheme'));
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
    public function update(SchemeRequest $request, $id)
    {
        return $this->Model->store($request, $id);
    }

    /**
     * [destroy used for destroy scheme data ]
     * @return [type] [description]

     */
    public function destroy(Request $request, $id)
    {
        $request['checkbox'] = [$id];
        return $this->Model->deleteAll($request);
    }

    /**
     * [anyData used for get scheme ]
     * @return [type] [description]
     */
    public function anyData(Request $request)
    {
        return $this->Model->getListData($request);
    }

}
