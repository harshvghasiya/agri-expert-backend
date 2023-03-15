<?php

namespace App\Models;

use App\Models\CropQuery;
use Crypt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\Datatables\Datatables;

class Answer extends Model
{
    use HasFactory;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public function answer_expert()
    {
        return $this->belongsTo('\App\Models\Expert', 'expert_id', 'id');
    }

     public function answer_question()
    {
        return $this->belongsTo('\App\Models\Question', 'question_id', 'id');
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
                $msg = trans('message.answer_added_successfully');
                $res->status = $request->status;

            } else {
                $id = getDecryptedId($id);
                $res = self::find($id);
                $msg = trans('message.answer_updated_successfully');

                if (isset($request->status) && $request->status != null) {
                    $res->status = $request->status;
                } else {
                    $res->status = self::STATUS_ACTIVE;
                }

            }

            if (isset($request->image) && !empty($request->image)) {

                $imageName = uploadFile($request, 'image', answerImageUploadPath());

                if ($imageName != "") {
                    $res->image = $imageName;
                }
            }

            if (isset($request->video) && !empty($request->video)) {

                $videoName = uploadFile($request, 'video', answerVideoUploadPath());

                if ($videoName != "") {
                    $res->video = $videoName;
                }
            }

            if (isset($request->audio) && !empty($request->audio)) {

                $audioName = uploadFile($request, 'audio', answerAudioUploadPath());

                if ($audioName != "") {
                    $res->audio = $audioName;
                }
            }

            $res->answer = $request->answer;
            $res->expert_id = $request->expert_id;
            $res->question_id = $request->question_id;
            $res->save();

            $url = route('admin.answer.index');

            flashMessage('success', $msg);

        } catch (\Exception $e) {
            $url = route('admin.answer.index');
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
        $sql = self::select('id','image' ,'answer', 'video', 'expert_id','question_id' , 'audio', 'status', 'created_at');
        return Datatables::of($sql)
            ->addColumn('action', function ($data) {
                $string = "";

                $string = '<a title="' . trans('message.edit_answer') . '" href="' . route('admin.answer.edit', Crypt::encryptString($data->id . timeFormatString())) . '" class="btn btn-xs btn-primary"><i class="fadeIn animated bx bx-edit-alt"></i> </a>';


                $string .= ' <a href="javascript:void(0)" title="' . trans('message.delete_answer_label') . '" data-route="' . route('admin.answer.destroy', Crypt::encryptString($data->id . timeFormatString())) . '" class="btn btn-xs btn-danger delete_record"> <i class="fadeIn animated bx bx-trash"></i> </a>';

                return $string;
            })
            ->editColumn('id', function ($data) {
                return '<input type="checkbox" name="checkbox[]" class="select_checkbox_value con_check" value="' . Crypt::encryptString($data->id . timeFormatString()) . '" />';
            })
            ->editColumn('image', function ($data) {
                return view('answer.partial.image', compact('data'));
            })
            ->editColumn('audio', function ($data) {
                return view('answer.partial.audio', compact('data'));
            })
            ->editColumn('video', function ($data) {
                return view('answer.partial.video', compact('data'));
            })
            ->editColumn('answer', function ($data) {
                return $data->answer;
            })
            
            ->editColumn('expert_id', function ($data) {
                if ($data->answer_expert != null) {
                    
                    return '<a target="_blank" href="' . route('admin.expert.view', Crypt::encryptString($data->expert_id . timeFormatString())) . '">'.$data->answer_expert->name.'</a>';
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
                    $query->where('answer', 'like', '%' . $request->title . '%');
                }
                
            })
            ->rawColumns(['id', 'expert_id' ,'action', 'status'])
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

        return response()->json(['success' => 1, 'msg' => trans('message.answer_delete_message_label')]);
    }

    /**
     * [getSingleData This function will return sinlge data of company]
     * @return [type] [description]

     */
    public function getSingleData($id)
    {
        $data = self::select('id', 'expert_id', 'answer', 'question_id' , 'audio', 'video', 'status', 'created_at')->find($id);
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
        return response()->json(['success' => 1, 'msg' => trans('message.answer_delete_message_label')]);
    }


    /**
     * [Get Image Of Crop]
     */
    public function getAnswerImageUrl()
    {
        $imageUrl_u = noImageUrl();
        $imagePath = answerImageUploadPath() . $this->image;
        $imageUrl = answerImageUploadUrl() . $this->image;
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
    public function getAnswerVideoUrl()
    {
        $imageUrl_u = noImageUrl();
        $imagePath = answerVideoUploadPath() . $this->video;
        $imageUrl = answerVideoUploadUrl() . $this->video;
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
    public function getAnswerAudioUrl()
    {
        $imageUrl_u = noImageUrl();
        $imagePath = answerAudioUploadPath() . $this->audio;
        $imageUrl = answerAudioUploadUrl() . $this->audio;
        if (isset($this->audio) && !empty($this->audio) && file_exists($imagePath)) {
            return $imageUrl;
        } else {
            $imageUrl = $imageUrl_u;
        }
        return $imageUrl;
    }



}
