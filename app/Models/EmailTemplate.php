<?php

namespace App\Models;

use Crypt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Datatables;

class EmailTemplate extends Model
{
    use HasFactory;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * [store used for register or update data of Email Template ]
     * @return [type] [description]
     */
    public function store($request, $id = null)
    {
        try {

            if ($id == null) {
                $res = new self;
                $msg = trans('message.email_template_added_successfully');

            } else {
                $id = getDecryptedId($id);
                $res = self::find($id);
                $msg = trans('message.email_template_updated_successfully');

            }

            $res->title = $request->title;
            $res->subject = $request->subject;
            $res->from = $request->from;
            $res->description = $request->description;
            $res->status = $request->status;

            $res->save();

            $url = route('admin.email_template.index');
            flashMessage('success', $msg);

            return response()->json(['msg' => $msg, 'status' => true, 'url' => $url]);

        } catch (\Exception $e) {

            $url = route('admin.email_template.index');
            return response()->json(['msg' => $e->getMessage(), 'status' => true, 'url' => $url]);

        }
    }

    /**
     * [getListData used for get Email Template list through yajra ]
     * @return [type] [description]
     */
    public function getListData($request)
    {
        $sql = self::select("id", 'title', 'subject', 'from', 'description', 'created_at', 'status');
        return Datatables::of($sql)
            ->addColumn('action', function ($data) {

                $string = "";
                    $string = '<a title="' . trans('message.edit_email_template') . '" href="' . route('admin.email_template.edit', Crypt::encryptString($data->id . timeFormatString())) . '" class="btn btn-xs btn-primary"><i class="fadeIn animated bx bx-edit-alt"></i></a>';

                    $string .= ' <a target="_blank" title="' . trans('lang_data.preview_e_emplate_label') . '" href="' . route('admin.email_template.preview', Crypt::encryptString($data->id . timeFormatString())) . '" class="btn btn-xs btn-info"><i class="lni lni-eye"></i></a>';

                return $string;
            })
            ->editColumn('id', function ($data) {
                return '<input type="checkbox" name="checkbox[]" class="select_checkbox_value con_check" value="' . Crypt::encryptString($data->id . timeFormatString()) . '" />';
            })
            ->editColumn('status', function ($data) {
                    return getStatusIcon($data);
            })
            ->filter(function ($query) use ($request) {

                if (isset($request['status']) && $request['status'] != "") {
                    $query->where('status', $request['status']);
                }

                if (isset($request['title']) && $request['title'] != "") {
                    $query->where('title', 'like', '%' . $request->title . '%')
                        ->orwhere('subject', 'like', '%' . $request->title . '%')
                        ->orwhere('from', 'like', '%' . $request->title . '%');
                }
            })
            ->rawColumns(['id', 'action', 'status'])
            ->make(true);
    }

    /**
     * [getSingleData This function will return sinlge data of Email Template]
     * @return [type] [description]
     */
    public function getSingleData($id)
    {
        $data = self::select("id", 'title', 'subject', 'from', 'description', 'created_at', 'status')->find($id);
        return $data;
    }

    /**
     * [SingleStatusChange This function is used to active in active single status]
     * @param [type] $r [description]
     */
    public function singleStatusChange($r)
    {

        try {

            $l = self::select('id', 'status')->where('id', getDecryptedId($r->id))->first();
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

            return response()->json(['status' => $e->getMessage()]);
        }
    }

    /**
     * [statusAll This function is used to active or inactive sepcifuc resources]
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

            return response()->json(['success' => 1, 'msg' => trans('message.video_delete_message_label')]);

        } catch (\Exception $e) {

            return response()->json(['success' => 2, 'msg' => $e->getMessage()]);

        }
    }
}
