<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\BasicSetting;
use App\Http\Requests\MailConfigRequest;
use Crypt;

class BasicSettingController extends Controller
{
    function __construct()
    {
        $this->Model=new BasicSetting;
    }

     /**
     * [script This function is used to display  scripts settings ]
     * @return [type] [description]
     */
    public function setting(Request $request)
    {
        $title = trans('message.basic_setting_script_title');
        $setting = getBasicSetting();
        $encryptedId = Crypt::encrypt($setting->id);
        return view('basic.setting', compact('title', 'setting', 'encryptedId'));
    }

    /**
     * [updateScript This function is used to Update Scripts Setttings]
     * @return [type] [description]
     */
    public function updateSetting(Request $request, $id)
    {
        return $this->Model->updateSetting($request, $id);
    }

    /**
     * [logo This function is used to display  of logo]
     * @return [type] [description]
     * @author Softtechover [Harsh V].
     */
    public function mailConfig(Request $request)
    {
        $title=trans('message.basic_setting_mail_config_title');
        $mail_config=BasicSetting::select('id','is_smtp','from_mail','to_mail','smtp_host','smtp_port','encryption','smtp_username','smtp_password','smtp_status')->first();
        $encryptedId=Crypt::encrypt($mail_config->id);
        return view('basic.mail_from_admin',compact('title','mail_config','encryptedId'));
    }

     /**
     * [mailConfigUpdate This function is used to Update mail  Setttings]
     * @return [type] [description]
     * @author Softtechover [Harsh V].
     */
    public function mailConfigUpdate(MailConfigRequest $request,$id)
    {
        return $this->Model->mailConfigUpdate($request,$id);
    }

    /**
     * [mailConfigSendMail This function is used to Send Test mail]
     * @return [type] [description]
     * @author Softtechover [Harsh V].
     */
    public function mailConfigSendMail(MailConfigRequest $request,$id)
    {
        return $this->Model->mailConfigSendMail($request,$id);
    }


}
