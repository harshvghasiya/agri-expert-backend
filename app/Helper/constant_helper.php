<?php

// Show alert Messages
function flashMessage($type, $message)
{
    \Session::put($type, $message);

}

// for Status Icon and Data in yajara box
function getStatusIcon($data)
{
    if ($data->status == 1) {
        return '<span title="' . trans('message.click_on_button_change_status_label') . '" class="btn btn-sm btn-success" id="active_inactive"
        status="1" data-id="' . \Crypt::encryptString($data->id . timeFormatString()) . '">' . trans('message.active') . '</span>';
    } else {
        return '<span title="' . trans('message.click_on_button_change_status_label') . '" class="btn btn-sm btn-danger" id="active_inactive"
        status="0" data-id="' . \Crypt::encryptString($data->id . timeFormatString()) . '">' . trans('message.inactive') . '</span>';
    }
}

// Upload And Download Server Url
function uploadAndDownloadUrl()
{
    return asset('');
}

// Upload and download path
function uploadAndDownloadPath()
{
    return public_path();
}

// Crop Routes Prefix Keyword
function cropPrefixKeyword()
{
    return "crop";
}

// Farmer Routes Prefix Keyword
function farmerPrefixKeyword()
{
    return "farmer";
}

// admin route  Prefix Keyword
function adminPrefixKeyword()
{
    return "admin-user";
}

//  admin Routes Name
function adminRouteName()
{
    return 'admin_user.';
}

//  farmer Routes Name
function farmerRouteName()
{
    return 'farmer.';
}

//  crop Routes Name
function cropRouteName()
{
    return 'crop.';
}

//  expert Routes Name
function expertRouteName()
{
    return 'expert.';
}

// Common Route Prefix Keyword
function routePrefixKeyword()
{
    return "admin";
}

// Common Route Name
function routeRouteName()
{
    return "admin.";
}

// Basic Setting prefix keyword
function basicSettingPrefixKeyword()
{
    return 'basic-setting';
}

// Basic setting route prefix keyword
function basicSettingRouteName()
{
    return 'basic_setting.';
}

// query  Route prefix
function queryPrefixKeyword()
{
    return 'query';
}

// Question prefix
function questionPrefixKeyword()
{
    return 'question';
}

// Answer prefix
function answerPrefixKeyword()
{
    return 'answer';
}

// expert  Route prefix
function expertPrefixKeyword()
{
    return 'expert';
}

// query Route name
function queryRouteName()
{
    return 'query.';
}

// Question Route name
function questionRouteName()
{
    return 'question.';
}

// Answer Route name
function answerRouteName()
{
    return 'answer.';
}

// scheme  Route prefix
function schemePrefixKeyword()
{
    return 'scheme';
}

// scheme Route name
function schemeRouteName()
{
    return 'scheme.';
}

// Upload  Images
function uploadFile($r, $name, $uploadPath)
{

    $image = $r->$name;
    $name = time() . '' . $image->getClientOriginalName();

    $image->move($uploadPath, time() . '' . $image->getClientOriginalName());

    return $name;
}

// Favicon Upload path
function faviconImageUploadPath()
{
    return uploadAndDownloadPath() . '/upload/basic_setting/favicon/';
}

// Document Upload path
function documentUploadPath()
{
    return uploadAndDownloadPath() . '/upload/scheme/';
}

// Crop Upload path
function cropImageUploadPath()
{
    return uploadAndDownloadPath() . '/upload/crop/';
}

// Question audio Upload path
function questionImageUploadPath()
{
    return uploadAndDownloadPath() . '/upload/question/image/';
}

// Answer audio Upload path
function answerImageUploadPath()
{
    return uploadAndDownloadPath() . '/upload/answer/image/';
}

// Question audio Upload path
function questionAudioUploadPath()
{
    return uploadAndDownloadPath() . '/upload/question/audio/';
}

// Answer audio Upload path
function answerAudioUploadPath()
{
    return uploadAndDownloadPath() . '/upload/answer/audio/';
}

// Question video Upload path
function questionVideoUploadPath()
{
    return uploadAndDownloadPath() . '/upload/question/video/';
}

// Answer video Upload path
function answerVideoUploadPath()
{
    return uploadAndDownloadPath() . '/upload/answer/video/';
}

// Document Upload url
function documentUploadUrl()
{
    return uploadAndDownloadUrl() . '/upload/scheme/';
}


// Crop Upload url
function cropImageUploadUrl()
{
    return uploadAndDownloadUrl() . '/upload/crop/';
}

// Question image Upload url
function questionImageUploadUrl()
{
    return uploadAndDownloadUrl() . '/upload/question/image/';
}

// Answer image Upload url
function answerImageUploadUrl()
{
    return uploadAndDownloadUrl() . '/upload/answer/image/';
}

// Question video Upload url
function questionVideoUploadUrl()
{
    return uploadAndDownloadUrl() . '/upload/question/video/';
}

// Answer video Upload url
function answerVideoUploadUrl()
{
    return uploadAndDownloadUrl() . '/upload/answer/video/';
}

// Question audio Upload url
function questionAudioUploadUrl()
{
    return uploadAndDownloadUrl() . '/upload/question/audio/';
}

// Answer audio Upload url
function answerAudioUploadUrl()
{
    return uploadAndDownloadUrl() . '/upload/answer/audio/';
}

// Video thumbnail Upload path
function thumbnailUploadPath($company_name)
{
    return uploadAndDownloadPath() . '/upload/videos/' . $company_name . '/thumb/';
}

// Logo Upload path
function logoImageUploadPath()
{
    return uploadAndDownloadPath() . '/upload/basic_setting/logo/';
}

// Upload and download url
function faviconImageUploadUrl()
{

    return uploadAndDownloadUrl() . 'upload/basic_setting/favicon/';
}

// Video  download url
function videoUploadUrl($company_name)
{

    return uploadAndDownloadUrl() . 'upload/videos/' . $company_name . '/';
}

// Video thumbnail download url
function thumbnailUploadUrl($company_name)
{

    return uploadAndDownloadUrl() . 'upload/videos/' . $company_name . '/thumb/';
}

// Upload and download url
function logoImageUploadUrl()
{

    return uploadAndDownloadUrl() . 'upload/basic_setting/logo/';
}

// If Image not avalaible this image will show
function noImageUrl()
{
    return uploadAndDownloadUrl() . 'admin/no_image.png';
}

// GET Basic setting data
function getBasicSetting()
{
    // $redis = Redis::connection();
    // $setting = Redis::get('basic_setting');

    // if (isset($setting) && $setting != null) {
    //     $setting = json_decode($setting);
    //     return $setting;
    // } else {
        $data = \App\Models\BasicSetting::select('id', 'logo', 'favicon', 'is_recaptcha', 'website_title', 'google_analytics_script', 'is_recaptcha', 'google_recaptcha_site_key', 'google_recaptcha_secret_key', 'is_analytics')->first();
        // $data->logo = $data->getLogoImageUrl();
        // $data->favicon = $data->getFaviconImageUrl();
        // Redis::set('basic_setting', $data);
        return $data;
    // }
}

// Email Template prefix
function emailTemplatePrefixKeyword()
{
    return 'email-template';
}

// EMail Template route name
function emailTemplateRouteName()
{
    return 'email_template.';
}

// Role route prefix
function rolePrefixKeyword()
{
    return 'role';
}

// Role route name
function roleRouteName()
{
    return 'role.';
}

// Genrate Token
function generateToken()
{
    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $token = '';
    for ($i = 0; $i < 6; $i++) {
        $token .= $characters[rand(0, strlen($characters) - 1)];
    }
    $token = time() . $token . time();
    return $token;
}

// Send Mail
function sendMail($user, $email_body, $data)
{
    $mail_config = \App\Models\BasicSetting::select('id', 'is_smtp', 'from_mail', 'to_mail', 'smtp_host', 'smtp_port', 'encryption', 'smtp_username', 'smtp_password', 'smtp_status')->first();
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    $mail->isSendmail();
    $mail->Host = $mail_config->smtp_host;
    $mail->SMTPAuth = true;
    $mail->Username = $mail_config->smtp_username;
    $mail->Password = $mail_config->smtp_password;
    $mail->SMTPSecure = $mail_config->encryption;
    $mail->Port = $mail_config->smtp_port;

    //Recipients
    $mail->setFrom($mail_config->from_mail);

    $mail->addAddress($user->email);

    // Content
    $mail->isHTML(true);
    $mail->Subject = $data->subject;
    $mail->Body = view('emails.mail_template', compact('email_body'));
    $mail->send();
    if (!$mail->send()) {
        return false;
    } else {
        return true;
    }
}


// Get Company name
function companyName($video_id = "")
{
    if ($video_id != null) {
        $company_name = $video_id->video_user->name;
    } else {
        $company_name = \Str::slug(\Auth::user()->name);
    }

    return $company_name;
}

//Admin company name
function adminCompanyName($user_id)
{
    $res = \App\Models\User::select('id', 'name')->where('id', $user_id)->first();
    if ($res != null) {
        $company_name = $res->name;
    } else {
        $company_name = \Auth::user()->id;
    }

    return $company_name;
}

// To get decrypted id
function getDecryptedId($id)
{
    $str = \Crypt::decryptString($id);
    $deid = 0;

    if ($str != null) {
        $str = explode('%sss%', $str);
        $deid = $str[0];
        return $deid;
    } else {

        try {

            $deid = \Crypt::decryptString($id);
            return $id;

        } catch (\Exception $e) {

            return $deid;
        }
    }

    return $deid;
}

// Time Format String
function timeFormatString()
{
    $time = "%sss%" . now()->format('Y-m-d H:i:s');
    return $time;
}

// get Default timezone
function getTimeZone()
{
    return 'UTC';
}


// create slug
function createSlug($str, $delimiter = '-')
{
    $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;
} 

//Api error Proccessor
function errorProcessor($validator)
{
    $err_keeper = [];
    foreach ($validator->errors()->getMessages() as $index => $error) {
        array_push($err_keeper, ['feild_name' => $index, 'message' => $error[0]]);
    }
    return $err_keeper;
}

//get cache data
function getTransData($title,$lang)
{
    
    $redis = Redis::connection();
    $setting = Redis::get($title.'_'.$lang);

    if (isset($setting) && $setting != null) {
        $setting = $setting;
        return $setting;
    } else {

        $trans = new \Stichoza\GoogleTranslate\GoogleTranslate($lang);
        $titles = $trans->translate($title);
        Redis::set($title.'_'.$lang , $titles);
        return $titles;
    }

}
