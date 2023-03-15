<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace' => 'Api','as'=>'api.'], function () {


    Route::post('register-farmer', 'ApiController@registerFarmer')->name('register_farmer');
    Route::get('scheme-data', 'ApiController@schemeData')->name('scheme-data');
    Route::get('crops', 'ApiController@cropData')->name('crop-data');
    Route::get('crop-query', 'ApiController@queryData')->name('query-data');
    Route::post('login-farmer', 'ApiController@farmerLogin')->name('farmer-login');
    Route::post('farmer-data', 'ApiController@farmerData')->name('farmer-data');
    Route::get('question-by-farmer-id', 'ApiController@farmerQuestion')->name('farmer-question');
    Route::post('question-post', 'ApiController@questionPost')->name('question-post');
    Route::post('logout-farmer', 'ApiController@farmerLogout')->name('farmer-logout');
    Route::get('settings', 'ApiController@setting')->name('setting');
	Route::post('expert-login', 'ApiController@expertLogin')->name('expert_login');
    Route::get('get-faq', 'ApiController@faqExpert')->name('faqExpert');


});


Route::group(['namespace' => 'Api', 'middleware' => 'auth:sanctum','as'=>'api.'], function () {

	Route::middleware('auth:api')->get('/', function (Request $request) {
            return $request->user();
        });

	Route::get('upvote-question', 'ApiController@upvoteQuestion')->name('upvoteQuestion');
    Route::get('downvote-question', 'ApiController@downQuestion')->name('downQuestion');
    Route::get('expert-details', 'ApiController@expertData')->name('expertdata');
    Route::post('answer-post', 'ApiController@answerPost')->name('answer-post');
    Route::get('expert-answer', 'ApiController@expertAnswer')->name('answer-answer');
    Route::get('expert-answer-id', 'ApiController@expertAnswerId')->name('answer-answer-id');
	Route::get('expert-logout', 'ApiController@expertLogout')->name('expert_logout');
});
