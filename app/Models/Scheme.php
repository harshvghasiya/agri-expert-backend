<?php

namespace App\Models;

use Crypt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Datatables;

class Scheme extends Model
{
    use HasFactory;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * [store used for register  or  update company ]
     * @return [type] [description]
     */
    public function store($request, $id = null)
    {
        try {
            if ($id == null) {
                $res = new self;
                $msg = trans('message.scheme_added_successfully');
                $res->status = $request->status;

            } else {
                $id = getDecryptedId($id);
                $res = self::find($id);
                $msg = trans('message.scheme_updated_successfully');

                if (isset($request->status) && $request->status != null) {
                    $res->status = $request->status;
                } else {
                    $res->status = self::STATUS_ACTIVE;
                }

            }

            if (isset($request->document) && !empty($request->document)) {

                $docName = uploadFile($request, 'document', documentUploadPath());

                if ($docName != "") {
                    $res->document = $docName;
                }
            }

            $res->title = $request->title;
            $res->slug = createSlug($request->title);
            $res->description = $request->description;
            $res->save();

            $url = route('admin.scheme.index');

            flashMessage('success', $msg);

        } catch (\Exception $e) {
            $url = route('admin.scheme.index');
            return response()->json(['msg' => $e->getMessage(), 'status' => true, 'url' => $url]);

        }

        return response()->json(['msg' => $msg, 'status' => true, 'url' => $url]);
    }

    /**
     * [getListData used for get company data ]
     * @return [type] [description]
     */
    public function getListData($request)
    {
        $sql = self::select('id', 'title', 'document', 'description', 'status', 'user_id', 'created_at');
        return Datatables::of($sql)
            ->addColumn('action', function ($data) {
                $string = "";

                $string = '<a title="' . trans('message.edit_scheme') . '" href="' . route('admin.scheme.edit', Crypt::encryptString($data->id . timeFormatString())) . '" class="btn btn-xs btn-primary"><i class="fadeIn animated bx bx-edit-alt"></i></a>';

                $string .= ' <a title="' . trans('message.view_scheme') . '" href="' . route('admin.scheme.view', Crypt::encryptString($data->id . timeFormatString())) . '" class="btn btn-xs btn-info"> <i class="lni lni-eye"></i> </a>';

                $string .= ' <a href="javascript:void(0)" title="' . trans('message.delete_scheme_label') . '" data-route="' . route('admin.scheme.destroy', Crypt::encryptString($data->id . timeFormatString())) . '" class="btn btn-xs btn-danger delete_record"> <i class="fadeIn animated bx bx-trash"></i></a>';

                return $string;
            })
            ->editColumn('id', function ($data) {
                return '<input type="checkbox" name="checkbox[]" class="select_checkbox_value con_check" value="' . Crypt::encryptString($data->id . timeFormatString()) . '" />';
            })

            ->editColumn('title', function ($data) {
                return $data->title;
            })

            ->editColumn('document', function ($data) {
                return view('scheme.partial.document', compact('data'));
            })

            ->editColumn('status', function ($data) {
                return getStatusIcon($data);
            })
            ->filter(function ($query) use ($request) {

                if (isset($request['status']) && $request['status'] != "") {
                    $query->where('status', $request['status']);
                }
                if (isset($request['title']) && $request['title'] != "") {
                    $query->where('title', 'like', '%' . $request->title . '%');
                }
            })
            ->rawColumns(['id', 'action', 'status'])
            ->make(true);
    }

    /**
     * [deleteAll This funtion is used to delete specific resources]
     * @param  [type] $r [description]
     * @return [type]    [description]
     */
    public function deleteAll($r)
    {
        try {

            $input = $r->all();
            foreach ($input['checkbox'] as $key => $c) {
                $c = getDecryptedId($c);
                $obj = $this->findOrFail($c);
                $obj->delete();
            }
        } catch (\Exception $e) {

            return response()->json(['success' => 1, 'msg' => $e->getMessage()]);

        }

        return response()->json(['success' => 1, 'msg' => trans('message.scheme_delete_message_label')]);
    }

    /**
     * [getSingleData This function will return sinlge data of company]
     * @return [type] [description]

     */
    public function getSingleData($id)
    {
        $data = self::select('id', 'user_id', 'title', 'description', 'document', 'status', 'created_at')->find($id);
        return $data;
    }

    /**
     * [SingleStatusChange This function is used to active in active single status]
     * @param [type] $r [description]
     */
    public function singleStatusChange($r)
    {
        try {

            $id = getDecryptedId($r->id);
            $l = self::select('id', 'status')->where('id', $id)->first();

            if ($l != null) {

                if ($l->status == 1) {
                    $l->status = self::STATUS_INACTIVE;
                } else {
                    $l->status = self::STATUS_ACTIVE;
                }
                $l->save();
                return response()->json(['status' => $l->status]);
            }
        } catch (\Exception $e) {

            return response()->json(['status' => 2]);
        }
    }

    /**
     * [statusAll This function is used to active or inactive sepcific resources]
     * @param  [type] $r [description]
     * @return [type]    [description]
     */
    public function statusAll($r)
    {
        try {

            $input = $r->all();
            foreach ($input['checkbox'] as $key => $c) {
                $l = self::select('id', 'status')->where('id', getDecryptedId($c))->first();
                if ($l != null) {
                    if ($r->all_none == 1) {

                        $l->status = self::STATUS_ACTIVE;
                    } else {

                        $l->status = self::STATUS_INACTIVE;
                    }
                    $l->save();
                }
            }
        } catch (\Exception $e) {

            return response()->json(['success' => 1, 'msg' => $e->getMessage()]);
        }
        return response()->json(['success' => 1, 'msg' => trans('message.scheme_delete_message_label')]);
    }

    public function getDocumentUrl()
    {

        $imageUrl_u = noImageUrl();
        $imagePath = documentUploadPath() . $this->document;
        $imageUrl = documentUploadUrl() . $this->document;
        if (isset($this->document) && !empty($this->document) && file_exists($imagePath)) {
            return $imageUrl;
        } else {
            $imageUrl = $imageUrl_u;
        }
        return $imageUrl;
    }

}
