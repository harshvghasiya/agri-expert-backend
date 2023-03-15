<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::group(['middleware' => 'web', 'as' => routeRouteName()], function () {
    Route::get('login', 'LoginController@login')->name('login');
    Route::post('postlogin', 'LoginController@postLogin')->name('postlogin');
    Route::post('forgot-password-post', 'LoginController@forgotPassword')->name('forgot_password');
    Route::get('forgot-password', 'LoginController@forgotPasswordForm')->name('forgot_password_form');
    Route::get('reset-password/{id}', 'LoginController@resetPassword')->name('reset_password');
    Route::post('update-password/{id}', 'LoginController@updatePassword')->name('update_password');

});

    Route::get('trans', 'LoginController@trans')->name('trans');


Route::group(['middleware' => 'auth', 'as' => routeRouteName()], function () {

    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::get('profile', 'AdminController@profile')->name('profile');
    Route::any('profile-update/{id}', 'AdminController@profileUpdate')->name('profile_update');
    Route::any('password-update/{id}', 'AdminController@passwordUpdate')->name('password_update');
    Route::get('/', 'AdminController@dashboard')->name('dashboard');

    // Basic Settings Routes
    Route::group(['prefix'=>basicSettingPrefixKeyword(),'as'=>basicSettingRouteName()],function()
    {
        Route::get('/', 'BasicSettingController@setting')->name('setting');
        Route::put('update-setting/{id}', 'BasicSettingController@updateSetting')->name('update_setting');
       Route::any('mail-config', 'BasicSettingController@mailConfig')->name('mail_config');
       Route::any('mail-config-update/{id}', 'BasicSettingController@mailConfigUpdate')->name('mail_config_update');
       Route::any('mail-config-sendmail/{id}', 'BasicSettingController@mailConfigSendMail')->name('mail_config_send_mail');
    });

    // Crop Routes
    Route::group(['prefix' => cropPrefixKeyword(), 'as' => cropRouteName()], function () {
        Route::get('create', 'CropController@create')->name('create');
        Route::post('store', 'CropController@store')->name('store');
        Route::get('edit/{id}', 'CropController@edit')->name('edit');
        Route::get('view/{id}', 'CropController@view')->name('view');
        Route::put('update/{id}', 'CropController@update')->name('update');
        Route::delete('destroy/{id}', 'CropController@destroy')->name('destroy');
        Route::get('/', 'CropController@index')->name('index');
        Route::get('any-data', 'CropController@anyData')->name('any_data');
        Route::post('delete-all', 'CropController@deleteAll')->name('delete_all');
        Route::post('status-all', 'CropController@statusAll')->name('status_all');
        Route::post('single-status-change', 'CropController@singleStatusChange')->name('single_status_change');

    });

    // Questions Routes
    Route::group(['prefix' => questionPrefixKeyword(), 'as' => questionRouteName()], function () {
        Route::get('create', 'QuestionController@create')->name('create');
        Route::post('store', 'QuestionController@store')->name('store');
        Route::get('edit/{id}', 'QuestionController@edit')->name('edit');
        Route::get('view/{id}', 'QuestionController@view')->name('view');
        Route::put('update/{id}', 'QuestionController@update')->name('update');
        Route::delete('destroy/{id}', 'QuestionController@destroy')->name('destroy');
        Route::get('/', 'QuestionController@index')->name('index');
        Route::get('any-data', 'QuestionController@anyData')->name('any_data');
        Route::post('delete-all', 'QuestionController@deleteAll')->name('delete_all');
        Route::post('delete-video', 'QuestionController@deleteVideo')->name('video_delete');
        Route::post('delete-thumbnail', 'QuestionController@deleteThumbnail')->name('thum_delete');
        Route::post('delete-audio', 'QuestionController@deleteAudio')->name('audio_delete');
        Route::post('status-all', 'QuestionController@statusAll')->name('status_all');
        Route::post('single-status-change', 'QuestionController@singleStatusChange')->name('single_status_change');

    });

    // Answer Routes
    Route::group(['prefix' => answerPrefixKeyword(), 'as' => answerRouteName()], function () {
        Route::get('create', 'AnswerController@create')->name('create');
        Route::post('store', 'AnswerController@store')->name('store');
        Route::get('edit/{id}', 'AnswerController@edit')->name('edit');
        Route::get('view/{id}', 'AnswerController@view')->name('view');
        Route::put('update/{id}', 'AnswerController@update')->name('update');
        Route::delete('destroy/{id}', 'AnswerController@destroy')->name('destroy');
        Route::get('/', 'AnswerController@index')->name('index');
        Route::get('any-data', 'AnswerController@anyData')->name('any_data');
        Route::post('delete-all', 'AnswerController@deleteAll')->name('delete_all');
        Route::post('delete-video', 'AnswerController@deleteVideo')->name('video_delete');
        Route::post('delete-thumbnail', 'AnswerController@deleteThumbnail')->name('thum_delete');
        Route::post('delete-audio', 'AnswerController@deleteAudio')->name('audio_delete');
        Route::post('status-all', 'AnswerController@statusAll')->name('status_all');
        Route::post('single-status-change', 'AnswerController@singleStatusChange')->name('single_status_change');

    });

    // Epert Routes
    Route::group(['prefix' => expertPrefixKeyword(), 'as' => expertRouteName()], function () {
        Route::get('create', 'ExpertController@create')->name('create');
        Route::post('store', 'ExpertController@store')->name('store');
        Route::get('edit/{id}', 'ExpertController@edit')->name('edit');
        Route::get('view/{id}', 'ExpertController@view')->name('view');
        Route::put('update/{id}', 'ExpertController@update')->name('update');
        Route::delete('destroy/{id}', 'ExpertController@destroy')->name('destroy');
        Route::get('/', 'ExpertController@index')->name('index');
        Route::get('any-data', 'ExpertController@anyData')->name('any_data');
        Route::post('delete-all', 'ExpertController@deleteAll')->name('delete_all');
        Route::post('status-all', 'ExpertController@statusAll')->name('status_all');
        Route::post('single-status-change', 'ExpertController@singleStatusChange')->name('single_status_change');

    });

    // Query Routes
    Route::group(['prefix' => queryPrefixKeyword(), 'as' => queryRouteName()], function () {
        Route::get('create', 'QueryController@create')->name('create');
        Route::post('store', 'QueryController@store')->name('store');
        Route::get('edit/{id}', 'QueryController@edit')->name('edit');
        Route::put('update/{id}', 'QueryController@update')->name('update');
        Route::delete('destroy/{id}', 'QueryController@destroy')->name('destroy');
        Route::get('/', 'QueryController@index')->name('index');
        Route::get('any-data', 'QueryController@anyData')->name('any_data');
        Route::post('delete-all', 'QueryController@deleteAll')->name('delete_all');
        Route::post('status-all', 'QueryController@statusAll')->name('status_all');
        Route::post('single-status-change', 'QueryController@singleStatusChange')->name('single_status_change');

    });

    // Farmer Routes
    Route::group(['prefix' => farmerPrefixKeyword(), 'as' => farmerRouteName()], function () {
        Route::get('create', 'FarmerController@create')->name('create');
        Route::post('store', 'FarmerController@store')->name('store');
        Route::get('edit/{id}', 'FarmerController@edit')->name('edit');
        Route::put('update/{id}', 'FarmerController@update')->name('update');
        Route::delete('destroy/{id}', 'FarmerController@destroy')->name('destroy');
        Route::get('/', 'FarmerController@index')->name('index');
        Route::get('any-data', 'FarmerController@anyData')->name('any_data');
        Route::post('delete-all', 'FarmerController@deleteAll')->name('delete_all');
        Route::post('status-all', 'FarmerController@statusAll')->name('status_all');
        Route::post('single-status-change', 'FarmerController@singleStatusChange')->name('single_status_change');

    });

    // Scheme Routes
    Route::group(['prefix' => schemePrefixKeyword(), 'as' => schemeRouteName()], function () {
        Route::get('create', 'SchemeController@create')->name('create');
        Route::post('store', 'SchemeController@store')->name('store');
        Route::get('edit/{id}', 'SchemeController@edit')->name('edit');
        Route::get('view/{id}', 'SchemeController@view')->name('view');
        Route::put('update/{id}', 'SchemeController@update')->name('update');
        Route::delete('destroy/{id}', 'SchemeController@destroy')->name('destroy');
        Route::get('/', 'SchemeController@index')->name('index');
        Route::get('any-data', 'SchemeController@anyData')->name('any_data');
        Route::post('delete-all', 'SchemeController@deleteAll')->name('delete_all');
        Route::post('status-all', 'SchemeController@statusAll')->name('status_all');
        Route::post('single-status-change', 'SchemeController@singleStatusChange')->name('single_status_change');

    });

    // Admin Routes
    Route::group(['prefix' => adminPrefixKeyword(), 'as' => adminRouteName()], function () {
        Route::get('create', 'AdminController@create')->name('create');
        Route::post('store', 'AdminController@store')->name('store');
        Route::get('edit/{id}', 'AdminController@edit')->name('edit');
        Route::put('update/{id}', 'AdminController@update')->name('update');
        Route::delete('destroy/{id}', 'AdminController@destroy')->name('destroy');
        Route::get('/', 'AdminController@index')->name('index');
        Route::get('any-data', 'AdminController@anyData')->name('any_data');
        Route::post('delete-all', 'AdminController@deleteAll')->name('delete_all');
        Route::post('status-all', 'AdminController@statusAll')->name('status_all');
        Route::post('single-status-change', 'AdminController@singleStatusChange')->name('single_status_change');

    });

    // Email Template Routes
    Route::group(['prefix' => emailTemplatePrefixKeyword(), 'as' => emailTemplateRouteName()], function () {
        Route::get('create', 'EmailTemplateController@create')->name('create');
        Route::post('store', 'EmailTemplateController@store')->name('store');
        Route::get('edit/{id}', 'EmailTemplateController@edit')->name('edit');
        Route::put('update/{id}', 'EmailTemplateController@update')->name('update');
        Route::get('/', 'EmailTemplateController@index')->name('index');
        Route::get('any-data', 'EmailTemplateController@anyData')->name('any_data');
        Route::post('status-all', 'EmailTemplateController@statusAll')->name('status_all');
        Route::get('email-template/preview/{id}', 'EmailTemplateController@preview')->name('preview');
        Route::post('single-status-change', 'EmailTemplateController@singleStatusChange')->name('single_status_change');
    });

});
