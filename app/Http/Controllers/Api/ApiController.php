<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FarmerRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\Farmer;
use App\Models\Scheme;
use App\Models\Expert;
use App\Models\Question;
use App\Models\ExpertUpvote;
use App\Models\Query;
use App\Models\Answer;
use App\Models\Crop;
use App\Models\BasicSetting;
use Crypt;
use Stichoza\GoogleTranslate\GoogleTranslate;


class ApiController extends Controller
{
    
    /**
     * [register farmer ]
     * @return [type] [description]
     */

    public function registerFarmer(Request $request)
    {

    	$validator = Validator::make($request->all(), [
            'mobile' => 'required|unique:farmers|regex:/[0-9]{9}/',
            'name' => 'required',
            'village' => 'required',
        ], [
            'mobile.required' => trans('message.mobile_required'),
            'mobile.regex' => trans('message.invalid_mobile_number'),
            'name.required' => trans('message.name_required'),
            'village.required' => trans('message.village_required'),
            'mobile.unique' => trans('message.check_farmer_exist_exit'),
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => errorProcessor($validator)], 422);
           
        }

        
    	try {

            $res = new Farmer;
            $msg = trans('message.farmer_added_successfully');
            $res->status = Farmer::STATUS_ACTIVE;

            $res->name = $request->name;
            $res->taluka = $request->taluka;
            $res->village = $request->village;
            $res->mobile = $request->mobile;
            $res->save();


        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'status' => false],500);

        }

        return response()->json(['msg' => $msg, 'status' => true],200);
    }

    /**
     * [Scheme Data ]
     * @return [type] [description]
     */

    public function schemeData(Request $request)
    {
        $res = Scheme::where('status',Scheme::STATUS_ACTIVE)->get();

        if ($request->lang == 'en' || $request->lang == 'hi' || $request->lang == 'gu') {

            $trans = new GoogleTranslate($request->lang); 

        }else{

            $trans = new GoogleTranslate('en'); 

        }

        $storage = [];
        foreach ($res as $key => $value) {
            $data = [];
            $data['id'] = $value->id;
            $data['title'] = getTransData($value->title,$request->lang);
            $data['description'] = $value->description != "" ? getTransData($value->description,$request->lang) : '';
            $data['created_at'] = $value->created_at;
            $data['document'] = $value->getDocumentUrl();
            $storage[] = $data;
        }

        return response()->json($storage,200);

    }

    /**
     * [Setting Data ]
     * @return [type] [description]
     */

    public function setting(Request $request)
    {
        try{

            $res = BasicSetting::select('logo','favicon')->first();
            $storage['logo'] = $res->getLogoImageUrl();
            $storage['favicon'] = $res->getLogoImageUrl();

        }catch(\Exception $e){

            return response()->json($e->getMessage(),500);

        }
        
        return response()->json($storage,200);

    }

    /**
     * [Login for expert ]
     * @return [type] [description]
     */
    public function expertLogin(Request $request)
    {
        $errors = [];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            
            'email.required' => trans('message.email_required'),
            'email.email' => trans('message.email_valid_form'),
            'password.required' => trans('message.password_required'),
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => errorProcessor($validator)], 422);
        }

        $data = [
            'email' => $request->email,
            'password' => $request->password,

        ];


            $expert = Expert::where('email',$request->email)->first();
            // dd($expert);

            if( $expert != null &&  \Hash::check($request->password,$expert->password) ){

                if ($expert->status == Expert::STATUS_ACTIVE ){
                    
                    $token = $expert->createToken('experttoken')->plainTextToken;
                
                    return response()->json(['token' => $token], 200);    

                }else{

                    array_push($errors, ['code' => 'auth-001', 'message' => trans('message.your_account_is_not_active')]);
                    return response()->json([
                        'errors' => $errors
                    ], 401);
                }

            } else {
                
                return response()->json([
                    'code' => 'login_fail', 'message' => trans('message.invalid_credential')
                ], 401);
            }
    }

    public function expertLogout()
    {
         auth()->user()->currentAccessToken()->delete();
         $msg = trans('message.logout_successfully_done');
        return response()->json([$msg],200);
    }


    public function expertData()
    {
        $storage['id'] = auth()->user()->id;
        $storage['name'] = auth()->user()->name;
        $storage['email'] = auth()->user()->email;
        $storage['created_at'] = auth()->user()->created_at;

        $crop_expert = Crop::with(['crop_query','crop_query.expert_query_crop'])
                        ->whereHas('crop_query',function($query)
                        {
                            $query->has('expert_query_crop');
                        })->get();


        
        // if (auth()->user()->expert_crop_query != null) {

        //     foreach ($crop_expert as $ke => $value ) {

        //         $data['name'] = $value->expert_crop_queries->crops->title;
        //         $datas[] = $value->expert_crop_queries->queries->title;
        //         $data['query'] = $datas;
        //         $str['crop_details'] = $data;

        //     }
        //         $storage['crop'] = $str;
        // }
        
        return response()->json($storage,200);

    }

    public function cropData(Request $request)
    {
        if ( $request->lang == 'hi' || $request->lang == 'gu') {
            $trans = new GoogleTranslate($request->lang); 

        }

        $res = Crop::with(['crop_query'])->where('status',Crop::STATUS_ACTIVE)->get();
        $datas = [];
        foreach ($res as $key => $value) {
            $data['id'] = $value->id;
            $data['title'] = isset($request->lang) && $request->lang != "en" ? getTransData($value->title,$request->lang) : $value->title ;
            // $data['slug'] = $value->slug;
            // $data['description'] = $value->description != "" ? $trans->translate($value->description) : '';
            // $data['created_at'] = $value->created_at;
            $data['image'] = $value->getCropImageUrl();
           
            $datas[] = $data;
        }
        return response()->json($datas,200);
    }

    public function queryData(Request $request)
    {
        if ( $request->lang == 'hi' || $request->lang == 'gu') {
            $trans = new GoogleTranslate($request->lang); 

        }

        $data = [];
        $value = Query::with(['query_crop'])
                        ->whereHas('query_crop',function($query) use($request)
                        {
                            $query->where('crop_id',$request->crop_id);
                        })
                        ->where('status',Query::STATUS_ACTIVE)
                        ->get();

            if ($value != null) {  
                    $query = [];
                foreach ($value as $k => $val) {

                    $resu['id'] = $val->id;
                    $resu['title'] = isset($request->lang) && $request->lang != "en" ? getTransData($val->title,$request->lang) : $val->title ;
                    // $resu['slug'] = $trans->translate($val->queries->slug);
                    // $resu['created_at'] = $val->queries->created_at;
                    // $resu['description'] = $val->description != "" ? $trans->translate($val->description) : '';
                    $query[] = $resu;
                }
            }
        return response()->json($query,200);
    }

    public function farmerLogin(Request $request)
    {
        $errors = [];

        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
        ], [
            
            'email.required' => trans('message.mobile_required'),
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => errorProcessor($validator)], 422);
        }

        
        $farmer = Farmer::where('mobile',$request->mobile)->first();
        if ($farmer == null) {
            return response()->json(['msg'=>trans('message.farmer_not_exist')],400);
        }

        if ($farmer->status == Farmer::STATUS_INACTIVE) {
            return response()->json(['msg'=>trans('message.farmer_status_inactive')],403);
        }

        $farmer->is_login = 1;
        $farmer->save();
            return response()->json(['msg'=>trans('message.farmer_login_success'),'status'=>1],200);

    }

    public function farmerData(Request $request)
    {
        $res = Farmer::where('mobile',$request->mobile)->first();

        if ($res == null || $res->status == Farmer::STATUS_INACTIVE ) {
            
            return response()->json(['msg'=>trans('message.farmer_not_exist')],400);
        }

        if ($res->is_login == 0) {

            return response()->json(['msg'=>trans('message.you_are_not_login')],400);
        }

        $data['id'] = $res->id;
        $data['name'] = $res->name;
        $data['mobile'] = $res->mobile;
        $data['created_at'] = $res->created_at;
        $data['village'] = $res->village;
        $data['taluka'] = $res->taluka;
        $data['is_login'] = 1;

        

        return response()->json($data,200);
    }

    public function farmerLogout(Request $request)
    {
        $res = Farmer::where('mobile',$request->mobile)->first();

        if ($res == null || $res->status == Farmer::STATUS_INACTIVE) {
            
            return response()->json(['msg'=>trans('message.farmer_not_exist')],400);
        }

        $res->is_login = 0;
        $res->save();

            return response()->json(['msg'=>trans('message.farmer_logout_success')],200);
            
    }


    public function questionPost(Request $request)
    {
        $farmer = Farmer::where('status',Farmer::STATUS_ACTIVE)->where('id', $request->farmer_id)->first();

        if ($farmer == null) {
            return response()->json(['msg' => trans('message.farmer_not_exist')],400);
        }

            $res = new Question;
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

            return response()->json(['msg' => trans('message.question_added_successfully')],200);

    }

    public function answerPost(Request $request)
    {
         $expert = Expert::where('status',Expert::STATUS_ACTIVE)->where('id', auth()->user()->id)->first();

        if ($expert == null) {
            return response()->json(['msg' => trans('message.expert_not_exist')],400);
        }

            $res = new Answer;
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
            $res->question_id = $request->question_id;
            $res->expert_id = auth()->user()->id;
            $res->save();

            return response()->json(['msg' => trans('message.answer_added_successfully')],200);
    }

    public function expertAnswer()
    {
        $expert = Answer::where('status',Answer::STATUS_ACTIVE)->where('expert_id',auth()->user()->id)->get();

        if ($expert == null) {

            return response()->json(['msg' => trans('message.expert_not_exist')],400);

        }

        $datas = [];

        foreach ($expert as $key => $value) 
        {
        
            $data['id'] = $value->id;
            $data['answer'] = $value->answer;
            $data['audio'] = $value->getAnswerAudioUrl();
            $data['video'] = $value->getAnswerVideoUrl();
            $data['image'] = $value->getAnswerImageUrl();

            if ($value->answer_question != null) {
                $question = [];
                $question['id'] = $value->answer_question->id; 
                $question['question'] = $value->answer_question->question; 
                $question['audio'] = $value->answer_question->getQuestionAudioUrl(); 
                $question['video'] = $value->answer_question->getQuestionVideoUrl(); 
                $question['image'] = $value->answer_question->getQuestionImageUrl(); 
                $data['question'] = $question;
            }
            $datas[] = $data;
        }

        return response()->json($datas,200);
    }

     public function expertAnswerId(Request $request)
    {
        $value = Answer::where('status',Answer::STATUS_ACTIVE)->where('expert_id',auth()->user()->id)->where('question_id',$request->question_id)->first();

        if ($value == null) {

            return response()->json(['msg' => trans('message.expert_not_exist')],400);

        }

        $datas = [];

        
        
            $data['id'] = $value->id;
            $data['answer'] = $value->answer;
            $data['audio'] = $value->getAnswerAudioUrl();
            $data['video'] = $value->getAnswerVideoUrl();
            $data['image'] = $value->getAnswerImageUrl();

            if ($value->answer_question != null) {
                $question = [];
                $question['id'] = $value->answer_question->id; 
                $question['question'] = $value->answer_question->question; 
                $question['audio'] = $value->answer_question->getQuestionAudioUrl(); 
                $question['video'] = $value->answer_question->getQuestionVideoUrl(); 
                $question['image'] = $value->answer_question->getQuestionImageUrl(); 
            }
            $data['question'] = $question;
            $datas[] = $data;
        

        return response()->json($datas,200);
    }

    public function farmerQuestion(Request $request)
    {
        $question = Question::where('farmer_id',$request->farmer_id)->where('status',Question::STATUS_ACTIVE)->get();

        $datas = [];

        if ($question != null) {
            
            foreach ($question as $key => $value) {
                
                $data['question'] = $value->question;
                $data['created_at'] = $value->created_at;

                if ($value->audio != null) {

                    $data['audio'] = $value->getQuestionAudioUrl();
                }

                if ($value->video != null) {

                    $data['video'] = $value->getQuestionVideoUrl();
                }

                if ($value->image != null) {
                    
                    $data['image'] = $value->getQuestionImageUrl();
                }
                $datas[] = $data;
            }
        }

        return response()->json($datas,200);

    }

    public function upvoteQuestion(Request $request)
    {
        $re = ExpertUpvote::where('expert_id',$request->expert_id)->where('question_id',$request->question_id)->first();

        if ($re == null) {
            
            $res = new ExpertUpvote;
            $res->expert_id = $request->expert_id;
            $res->question_id = $request->question_id;
            $res->save();

            return response()->json(['msg' =>'Upvoted successfully'],200);
        }

            return response()->json(['msg' =>'Already Upvoted'],200);

    }

    public function faqExpert(Request $request)
    {
        $res = ExpertUpvote::select('question_id')->groupBy('question_id')->take(10)->get();

        $datas = [];
        foreach ($res as $key => $value) {
            
            $re = Question::where('status',Question::STATUS_ACTIVE)->where('id',$value->question_id)->first();

                $data['question'] = $re->question;
                $data['created_at'] = $re->created_at;

                if ($re->audio != null) {

                    $data['audio'] = $re->getQuestionAudioUrl();
                }

                if ($re->video != null) {

                    $data['video'] = $re->getQuestionVideoUrl();
                }

                if ($re->image != null) {
                    
                    $data['image'] = $re->getQuestionImageUrl();
                }
                $datas[] = $data;
        }

        return response()->json($datas,200);

    }

    public function downQuestion(Request $request)
    {
        $re = ExpertUpvote::where('expert_id',$request->expert_id)->where('question_id',$request->question_id)->first();

        if ($re != null) {
            
            $re->delete();

            return response()->json(['msg' =>'Downvoted successfully'],200);
        }

            return response()->json(['msg' =>'Already Down Voted'],200);
    }
}
