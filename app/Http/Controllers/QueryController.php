<?php

namespace App\Http\Controllers;

use App\Http\Requests\QueryRequest;
use App\Models\Query;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class QueryController extends Controller
{
    public function __construct()
    {
        $this->Model = new Query;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $title = trans("message.query_title");
        return view('crop_query.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $title = trans("message.query_title");
        return view('crop_query.addedit', compact('title'));
    }

    /**
     * [store used for register Query ]
     * @return [type] [description]
     */
    public function store(QueryRequest $request)
    {
        return $this->Model->store($request);
    }

    /**
     * [edit used for edit Query data ]
     * @return [type] [description]
     */
    public function edit(Request $request, $id)
    {
        $encryptedId = $id;
        $id = getDecryptedId($id);
        $title = trans('message.query_edit');
        $query = $this->Model->getSingleData($id);
        return view('crop_query.addedit', compact('title', 'query', 'encryptedId'));
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
    public function update(QueryRequest $request, $id)
    {
        return $this->Model->store($request, $id);
    }

    /**
     * [destroy used for destroy Query data ]
     * @return [type] [description]

     */
    public function destroy(Request $request, $id)
    {
        $request['checkbox'] = [$id];
        return $this->Model->deleteAll($request);
    }

    /**
     * [anyData used for get Query ]
     * @return [type] [description]
     */
    public function anyData(Request $request)
    {
        return $this->Model->getListData($request);
    }

}
