<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Http\Requests\PasswordupdateRequest;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Crypt;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->Model = new User;
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function profile()
    {
        $title = trans('message.profile');
        return view('admin.profile', compact('title'));
    }

    public function profileUpdate(Request $request, $id)
    {
        $id = Crypt::decrypt($id);
        $res = User::find($id);
        $res->name = $request->name;
        $res->email = $request->email;
        $res->save();
        $msg = trans('message.profile_updated_successfully');
        $url = route('admin.profile');
        flashMessage('success', $msg);
        return response()->json(['msg' => $msg, 'status' => true, 'url' => $url]);
    }

    public function passwordUpdate(PasswordupdateRequest $request, $id)
    {

        $id = Crypt::decrypt($id);
        $res = User::find($id);

        $res->password = \Hash::make($request->password);
        $res->save();
        $msg = trans('message.password_updated_successfully');
        $url = route('admin.profile');
        flashMessage('success', $msg);
        return response()->json(['msg' => $msg, 'status' => true, 'url' => $url]);

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $title = trans("message.admin_title");
        return view('admin.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $title = trans("message.admin_title");
        return view('admin.addedit', compact('title'));
    }

    /**
     * [store used for register admin ]
     * @return [type] [description]
     */
    public function store(AdminRequest $request)
    {
        return $this->Model->store($request);
    }

    /**
     * [edit used for edit admin data ]
     * @return [type] [description]
     */
    public function edit(Request $request, $id)
    {
        $encryptedId = $id;
        $id = getDecryptedId($id);
        $title = trans('message.admin_edit');
        $admin = $this->Model->getSingleData($id);
        return view('admin.addedit', compact('title', 'admin', 'encryptedId'));
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
    public function update(AdminRequest $request, $id)
    {
        return $this->Model->store($request, $id);
    }

    /**
     * [destroy used for destroy admin data ]
     * @return [type] [description]

     */
    public function destroy(Request $request, $id)
    {
        $request['checkbox'] = [$id];
        return $this->Model->deleteAll($request);
    }

    /**
     * [anyData used for get admin ]
     * @return [type] [description]
     */
    public function anyData(Request $request)
    {
        return $this->Model->getListData($request);
    }

}
