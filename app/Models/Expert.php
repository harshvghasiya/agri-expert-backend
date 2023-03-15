<?php

namespace App\Models;

use Crypt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Yajra\Datatables\Datatables;
use Laravel\Sanctum\HasApiTokens;

class Expert extends Authenticatable
{
    use HasApiTokens,HasFactory;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public function expert_crop_query()
    {
        return $this->hasMany('App\Models\ExpertCropQuery', 'expert_id', 'id');
    }

    public function expert_answer()
    {
        return $this->hasMany('\App\Models\Answer', 'expert_id' , 'id');
    }

    /**
     * [store used for register  or  update company ]
     * @return [type] [description]
     */
    public function store($request, $id = null)
    {
        try {
            if ($id == null) {
                $res = new self;
                $msg = trans('message.expert_added_successfully');
                $res->status = $request->status;

            } else {
                $id = getDecryptedId($id);
                $res = self::find($id);
                $msg = trans('message.expert_updated_successfully');

                if (isset($request->status) && $request->status != null) {
                    $res->status = $request->status;
                } else {
                    $res->status = self::STATUS_ACTIVE;
                }

                ExpertCropQuery::where('expert_id',$id)->delete();

            }

            $res->name = $request->name;
            $res->email = $request->email;
            $res->password = \Hash::make($request->password);
            $res->slug = createSlug($request->name);
            $res->save();

            if (isset($request->expertise) && $request->expertise != null) {
                foreach ($request->expertise as $ke => $val) {
                    $re = new ExpertCropQuery;
                    $re->expert_id = $res->id;
                    $re->crop_query_id = $val;
                    $re->save();
                }
            }



            $url = route('admin.expert.index');

            flashMessage('success', $msg);

        } catch (\Exception $e) {
            $url = route('admin.expert.index');
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
        $sql = self::select('id', 'name', 'email', 'status', 'created_at');
        return Datatables::of($sql)
            ->addColumn('action', function ($data) {
                $string = "";

                $string = '<a title="' . trans('message.edit_expert') . '" href="' . route('admin.expert.edit', Crypt::encryptString($data->id . timeFormatString())) . '" class="btn btn-xs btn-primary"><i class="fadeIn animated bx bx-edit-alt"></i></a>';

                $string .= ' <a title="' . trans('message.view_expert') . '" href="' . route('admin.expert.view', Crypt::encryptString($data->id . timeFormatString())) . '" class="btn btn-xs btn-info"> <i class="lni lni-eye"></i> </a>';

                $string .= ' <a href="javascript:void(0)" title="' . trans('message.delete_expert_label') . '" data-route="' . route('admin.expert.destroy', Crypt::encryptString($data->id . timeFormatString())) . '" class="btn btn-xs btn-danger delete_record"> <i class="fadeIn animated bx bx-trash"></i></a>';

                return $string;
            })
            ->editColumn('id', function ($data) {
                return '<input type="checkbox" name="checkbox[]" class="select_checkbox_value con_check" value="' . Crypt::encryptString($data->id . timeFormatString()) . '" />';
            })

            ->editColumn('name', function ($data) {
                return $data->name;
            })

            ->editColumn('status', function ($data) {
                return getStatusIcon($data);
            })
            ->filter(function ($query) use ($request) {

                if (isset($request['status']) && $request['status'] != "") {
                    $query->where('status', $request['status']);
                }
                if (isset($request['title']) && $request['title'] != "") {
                    $query->where('name', 'like', '%' . $request->title . '%')
                    	->orWhere('email', 'like', '%' . $request->title . '%');
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

        return response()->json(['success' => 1, 'msg' => trans('message.expert_delete_message_label')]);
    }

    /**
     * [getSingleData This function will return sinlge data of company]
     * @return [type] [description]

     */
    public function getSingleData($id)
    {
        $data = self::select('id', 'name', 'email', 'status', 'created_at')->find($id);
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
        return response()->json(['success' => 1, 'msg' => trans('message.expert_delete_message_label')]);
    }

}
