<?php

namespace App\Http\Controllers;

use App\Http\Requests\FarmerRequest;
use App\Models\Farmer;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FarmerController extends Controller
{
    public function __construct()
    {
        $this->Model = new Farmer;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $title = trans("message.farmer_title");
        return view('farmer.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $title = trans("message.farmer_title");
        return view('farmer.addedit', compact('title'));
    }

    /**
     * [store used for register farmer ]
     * @return [type] [description]
     */
    public function store(FarmerRequest $request)
    {
        return $this->Model->store($request);
    }

    /**
     * [edit used for edit farmer data ]
     * @return [type] [description]
     */
    public function edit(Request $request, $id)
    {
        $encryptedId = $id;
        $id = getDecryptedId($id);
        $title = trans('message.farmer_edit');
        $farmer = $this->Model->getSingleData($id);
        return view('farmer.addedit', compact('title', 'farmer', 'encryptedId'));
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
    public function update(FarmerRequest $request, $id)
    {
        return $this->Model->store($request, $id);
    }

    /**
     * [destroy used for destroy farmer data ]
     * @return [type] [description]

     */
    public function destroy(Request $request, $id)
    {
        $request['checkbox'] = [$id];
        return $this->Model->deleteAll($request);
    }

    /**
     * [anyData used for get farmer ]
     * @return [type] [description]
     */
    public function anyData(Request $request)
    {
        return $this->Model->getListData($request);
    }

}
