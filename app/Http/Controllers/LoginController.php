<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\BasicSetting;
use App\Models\User;
use App\Models\EmailTemplate;
use Auth;
use Config;
use Crypt;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    /**
     * [login To get login page view for admin user ]
     * @return [type] [description]
     */
    public function login()
    {

        $basic_setting = getBasicSetting();
        if ($basic_setting != null && $basic_setting->google_recaptcha_site_key != null) {
            Config::set('recaptchav3.sitekey', $basic_setting->google_recaptcha_site_key);
            Config::set('recaptchav3.secret', $basic_setting->google_recaptcha_secret_key);
        }

        return view('auth.login');
    }

    public function register()
    {

        $basic_setting = getBasicSetting();
        if ($basic_setting != null && $basic_setting->google_recaptcha_site_key != null) {
            Config::set('recaptchav3.sitekey', $basic_setting->google_recaptcha_site_key);
            Config::set('recaptchav3.secret', $basic_setting->google_recaptcha_secret_key);
        }

        return view('auth.register');
    }

    /**
     * [postLogin This function is used to check login for admin user]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function postLogin(LoginRequest $request)
    {
        try{
            if (\Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {

                if (\Auth::user()->status != User::STATUS_ACTIVE) {
                    flashMessage('error', trans('message.inactive_login'));
                    $url = route('admin.login');
                } else {
                    flashMessage('success', trans('message.login_success'));
                    $url = route('admin.dashboard');
                }
                return response()->json(['msg' => trans('message.login_success'), 'url' => $url, 'status' => false]);

            } else {
                flashMessage('error', trans('message.valid_pass_email'));
                $error = trans('message.valid_pass_email');
                $url = route('admin.login');
                return response()->json(['error' => $error, 'url' => $url, 'status' => false]);
            }
        }catch(\Exception $e){

            flashMessage('error', $e->getMessage());
            $url = route('admin.login');
            return response()->json(['error' => $error, 'url' => $url, 'status' => false]);
        }
    }


    /**
     * [logout To logout user session this function is used]
     * @return [type] [description]
     */
    public function logout()
    {

        \Auth::logout();
        flashMessage('success', trans('message.logout_msg'));
        return redirect(route('admin.login'));
    }

    /**
     * [forgotPassword This function is used to check forgot password logic]
     * @param  Request $r [description]
     * @return [type]     [description]
     */
    public function forgotPassword(ForgotPasswordRequest $r)
    {

        try{
            $input = $r->all();
            $checkUserExit = User::where("email", $input['email'])->first();
            if ($checkUserExit == null) {

                flashMessage('error', trans('message.this_email_addres_not_exit'));
                $url = route('admin.forgot_password_form');
                return response()->json(['msg' => trans('message.this_email_addres_not_exit'), 'url' => $url]);

            } else {
                $token = generateToken();
                $link = route("admin.reset_password", $token);
                $data = EmailTemplate::where('status',EmailTemplate::STATUS_ACTIVE)->where('title', 'forgot_password_admin_user')->first();
                $template = $data->description;
                $sender = $data->from;

                $email_body = str_replace(array('###LINK###', '###SITE_NAME###'), array($link, route('admin.login')), $template);

                $mail_sended=sendMail($r,$email_body,$data);

                $checkUserExit->forgot_password_token = $token;
                $checkUserExit->save();
                $url = route('admin.login');
                flashMessage('success', trans('message.we_have_sended_link_reset_your_password'));
                return response()->json(['msg' => trans('message.we_have_sended_link_reset_your_password'), 'url' => $url]);

            }
        }catch(\Exception $e){
            
            $url = route('admin.login');
            flashMessage('success', $e->getMessage());
            return response()->json(['msg' => $e->getMessage(), 'url' => $url]);
        }
    }

    public function forgotPasswordForm(Request $request)
    {
        $basic_setting = getBasicSetting();
        if ($basic_setting != null && $basic_setting->google_recaptcha_site_key != null) {
            Config::set('recaptchav3.sitekey', $basic_setting->google_recaptcha_site_key);
            Config::set('recaptchav3.secret', $basic_setting->google_recaptcha_secret_key);
        }

        $title = trans('message.forget_password');
        return view('auth.forgot_password', compact('title'));
    }

    /**
     * [resetPassword To reset password page this function is used]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function resetPassword($id)
    {

        $user = User::where('forgot_password_token', $id)->first();

        if ($user == null) {

            flashMessage('error', trans('message.link_expire_wrong'));
            return redirect()->route('admin.login');

        } else {

            return view("auth.reset_password", compact("user"));
        }

    }

    /**
     * [updatePassword To upddate password after forgot process]
     * @param  Request $r [description]
     * @return [type]     [description]
     */
    public function updatePassword(UpdatePasswordRequest $r, $id)
    {

        try{
            $input = $r->all();

            if (isset($id)) {

                $user = User::where('forgot_password_token', $id)->first();

                if ($user != null) {

                    $user->password = \Hash::make($input['password']);
                    $user->forgot_password_token = null;
                    $user->save();

                    flashMessage('success', trans('message.passowrd_change_done'));
                    $url = route('admin.login');
                    return response()->json(['msg' => trans('message.passowrd_change_done'), 'url' => $url]);

                } else {

                    flashMessage('error', trans('message.link_expire_wrong'));
                    $url = route('admin.login');
                    return response()->json(['msg' => trans('message.link_expire_wrong'), 'url' => $url]);

                }

            } else {
                flashMessage('error', trans('message.link_expire_wrong'));
                $url = route('admin.login');
                return response()->json(['msg' => trans('message.link_expire_wrong'), 'url' => $url]);

            }
        }catch(\Exception $e){

            flashMessage('error', $e->getMessage());
            $url = route('admin.login');
            return response()->json(['msg' => $e->getMessage(), 'url' => $url]);
        }

    }

    public function trans()
    {
        $post = \Auth::user();
        dd($post->translate('en')->name);
    }
}
