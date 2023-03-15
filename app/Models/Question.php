<?php

namespace App\Models;

use App\Models\CropQuery;
use Crypt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Datatables;

class Question extends Model
{
    use HasFactory;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public function question_farmer()
    {
        return $this->belongsTo('\App\Models\Farmer', 'farmer_id', 'id');
    }

    public function question_upvote()
    {
        return $this->hasMany('\App\Models\ExpertUpvote', 'question_id' , 'id');
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
                $msg = trans('message.question_added_successfully');
                $res->status = $request->status;

            } else {
                $id = getDecryptedId($id);
                $res = self::find($id);
                $msg = trans('message.question_updated_successfully');

                if (isset($request->status) && $request->status != null) {
                    $res->status = $request->status;
                } else {
                    $res->status = self::STATUS_ACTIVE;
                }

            }

            if (isset($request->image) && !empty($request->image)) {

                $imageName = uploadFile($request, 'image', questionImageUploadPath());

                if ($imageName != "") {
                    $res->image = $imageName;
                }
            }

            if (isset($request->video) && !empty($request->video)) {

                $videoName = uploadFile($request, 'video', questionVideoUploadPath());

                if ($videoName != "") {
                    $res->video = $videoName;
                }
            }

            if (isset($request->audio) && !empty($request->audio)) {

                $audioName = uploadFile($request, 'audio', questionAudioUploadPath());

                if ($audioName != "") {
                    $res->audio = $audioName;
                }
            }

            $res->question = $request->question;
            $res->farmer_id = $request->farmer_id;
            $res->save();

            $url = route('admin.question.index');

            flashMessage('success', $msg);

        } catch (\Exception $e) {
            $url = route('admin.question.index');
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
        $sql = self::select('id','image' ,'question', 'video', 'farmer_id' , 'audio', 'status', 'created_at');
        return Datatables::of($sql)
            ->addColumn('action', function ($data) {
                $string = "";

                $string = '<a title="' . trans('message.edit_question') . '" href="' . route('admin.question.edit', Crypt::encryptString($data->id . timeFormatString())) . '" class="btn btn-xs btn-primary"><i class="fadeIn animated bx bx-edit-alt"></i> </a>';


                $string .= ' <a href="javascript:void(0)" title="' . trans('message.delete_question_label') . '" data-route="' . route('admin.question.destroy', Crypt::encryptString($data->id . timeFormatString())) . '" class="btn btn-xs btn-danger delete_record"> <i class="fadeIn animated bx bx-trash"></i> </a>';

                return $string;
            })
            ->editColumn('id', function ($data) {
                return '<input type="checkbox" name="checkbox[]" class="select_checkbox_value con_check" value="' . Crypt::encryptString($data->id . timeFormatString()) . '" />';
            })
            ->editColumn('image', function ($data) {
                return view('question.partial.image', compact('data'));
            })
            ->editColumn('audio', function ($data) {
                return view('question.partial.audio', compact('data'));
            })
            ->editColumn('upvoted', function ($data) {
                return view('question.partial.upvoted', compact('data'));
            })
            ->editColumn('video', function ($data) {
                return view('question.partial.video', compact('data'));
            })
            ->editColumn('question', function ($data) {
                return $data->question;
            })
            
            ->editColumn('farmer_id', function ($data) {
                if ($data->question_farmer != null) {
                    
                    return $data->question_farmer->name;
                }
                return \Auth::user()->name;
            })

            ->editColumn('status', function ($data) {
                return getStatusIcon($data);
            })
            ->filter(function ($query) use ($request) {

                if (isset($request['status']) && $request['status'] != "") {
                    $query->where('status', $request['status']);
                }
                if (isset($request['title']) && $request['title'] != "") {
                    $query->where('question', 'like', '%' . $request->title . '%');
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

        return response()->json(['success' => 1, 'msg' => trans('message.question_delete_message_label')]);
    }

    /**
     * [getSingleData This function will return sinlge data of company]
     * @return [type] [description]

     */
    public function getSingleData($id)
    {
        $data = self::select('id', 'farmer_id', 'question', 'audio', 'video', 'status', 'created_at')->find($id);
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
        return response()->json(['success' => 1, 'msg' => trans('message.question_delete_message_label')]);
    }


    /**
     * [Get Image Of Crop]
     */
    public function getQuestionImageUrl()
    {
        $imageUrl_u = noImageUrl();
        $imagePath = questionImageUploadPath() . $this->image;
        $imageUrl = questionImageUploadUrl() . $this->image;
        if (isset($this->image) && !empty($this->image) && file_exists($imagePath)) {
            return $imageUrl;
        } else {
            $imageUrl = $imageUrl_u;
        }
        return $imageUrl;
    }

	/**
     * [Get Video Of Crop]
     */
    public function getQuestionVideoUrl()
    {
        $imageUrl_u = noImageUrl();
        $imagePath = questionVideoUploadPath() . $this->video;
        $imageUrl = questionVideoUploadUrl() . $this->video;
        if (isset($this->video) && !empty($this->video) && file_exists($imagePath)) {
            return $imageUrl;
        } else {
            $imageUrl = $imageUrl_u;
        }
        return $imageUrl;
    }

    /**
     * [Get Audio Of Crop]
     */
    public function getQuestionAudioUrl()
    {
        $imageUrl_u = noImageUrl();
        $imagePath = questionAudioUploadPath() . $this->audio;
        $imageUrl = questionAudioUploadUrl() . $this->audio;
        if (isset($this->audio) && !empty($this->audio) && file_exists($imagePath)) {
            return $imageUrl;
        } else {
            $imageUrl = $imageUrl_u;
        }
        return $imageUrl;
    }



}
