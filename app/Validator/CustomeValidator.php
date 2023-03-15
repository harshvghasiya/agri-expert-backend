<?php
namespace App\Validator;

use App\Models\Crop;
use App\Models\Query;
use App\Models\User;
use App\Models\Expert;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Farmer;
use Hash;
use Illuminate\Validation\Validator;

class CustomeValidator extends Validator
{

    /**
     * [validatecheckEmailExitAdminUser To check user email exit or not]
     * @param  [type] $attribute  [description]
     * @param  [type] $value      [description]
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    public function validatecheckEmailExitAdminUser($attribute, $value, $parameters)
    {

        if (isset($parameters[0]) && !empty($parameters[0])) {
            $count = User::select('id', 'email', 'status')->where("id", "!=", getDecryptedId($parameters[0]))
                ->where("email", $value)
                ->count();

        } else {

            $count = User::select( 'id', 'email', 'status')->where("email", $value)->count();
        }

        if ($count === 0) {

            return true;

        } else {

            return false;
        }
    }
    
     /**
     * [validatecheckExpertEmailExit To check user email exit or not]
     * @param  [type] $attribute  [description]
     * @param  [type] $value      [description]
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    public function validatecheckExpertEmailExit($attribute, $value, $parameters)
    {

        if (isset($parameters[0]) && !empty($parameters[0])) {
            $count = Expert::select('id', 'email', 'status')->where("id", "!=", getDecryptedId($parameters[0]))
                ->where("email", $value)
                ->count();

        } else {

            $count = Expert::select( 'id', 'email', 'status')->where("email", $value)->count();
        }

        if ($count === 0) {

            return true;

        } else {

            return false;
        }
    }
    
    /**
     * [validatecheckExpertEmailExit To check user email exit or not]
     * @param  [type] $attribute  [description]
     * @param  [type] $value      [description]
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    public function validatecheckQuestionExit($attribute, $value, $parameters)
    {

        if (isset($parameters[0]) && !empty($parameters[0])) {
            $count = Question::select('id', 'question', 'status')->where("id", "!=", getDecryptedId($parameters[0]))
               ->where('question', 'like', '%' . $value . '%')
                ->count();

        } else {

            $count = Question::select( 'id', 'question', 'status')->where('question', 'like', '%' . $value . '%')->count();
        }

        if ($count === 0) {

            return true;

        } else {

            return false;
        }
    }

    /**
     * [validatecheckExpertEmailExit To check user email exit or not]
     * @param  [type] $attribute  [description]
     * @param  [type] $value      [description]
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    public function validatecheckAnswerExit($attribute, $value, $parameters)
    {

        if (isset($parameters[0]) && !empty($parameters[0])) {
            $count = Answer::select('id', 'answer', 'status')->where("id", "!=", getDecryptedId($parameters[0]))
               ->where('answer', 'like', '%' . $value . '%')
                ->count();

        } else {

            $count = Answer::select( 'id', 'answer', 'status')->where('answer', 'like', '%' . $value . '%')->count();
        }

        if ($count === 0) {

            return true;

        } else {

            return false;
        }
    }


    /**
     * [validatecheckExpertEmailExit To check user email exit or not]
     * @param  [type] $attribute  [description]
     * @param  [type] $value      [description]
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    public function validatecheckFarmerMobileExit($attribute, $value, $parameters)
    {

        if (isset($parameters[0]) && !empty($parameters[0])) {
            $count = Farmer::select('id', 'mobile', 'status')->where("id", "!=", getDecryptedId($parameters[0]))
                ->where("mobile", $value)
                ->count();

        } else {

            $count = Farmer::select( 'id', 'mobile', 'status')->where("mobile", $value)->count();
        }

        if ($count === 0) {

            return true;

        } else {

            return false;
        }
    }


    /**
     * [validatecheckCropExit To check user email exit or not]
     * @param  [type] $attribute  [description]
     * @param  [type] $value      [description]
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    public function validatecheckCropExit($attribute, $value, $parameters)
    {

        if (isset($parameters[0]) && !empty($parameters[0])) {
            $count = Crop::select('id', 'title')->where("id", "!=", getDecryptedId($parameters[0]))
                ->where("title", $value)
                ->count();

        } else {

            $count = Crop::select('id', 'title')->where("title", $value)->count();
        }

        if ($count === 0) {

            return true;

        } else {

            return false;
        }
    }

    /**
     * [validatecheckQueryExit To check user email exit or not]
     * @param  [type] $attribute  [description]
     * @param  [type] $value      [description]
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    public function validatecheckQueryExit($attribute, $value, $parameters)
    {

        if (isset($parameters[0]) && !empty($parameters[0])) {
            $count = Query::select('id', 'title')->where("id", "!=", getDecryptedId($parameters[0]))
                ->where("title", $value)
                ->count();

        } else {

            $count = Query::select('id', 'title')->where("title", $value)->count();
        }

        if ($count === 0) {

            return true;

        } else {

            return false;
        }
    }

    public function validatecheckVarifyOtp($attribute, $value, $parameters)
    {
        $user = User::select('is_deleted', 'id', 'otp')->where("id", getDecryptedId($parameters[0]))->where('otp', $value)->first();
        if ($user != null) {
            return true;
        } else {
            return false;
        }
    }

    public function validatecheckExpireOtp($attribute, $value, $parameters)
    {

        $user = User::select('is_deleted', 'id', 'created_at', 'status')->where("id", getDecryptedId($parameters[0]))->first();
        if ($user->created_at->diffInMinutes(\Carbon\Carbon::now(getTimeZone())) <= 5) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * [validatecheckCurrentPassword To check old  password is same or not]
     * @param  [type] $attribute  [description]
     * @param  [type] $value      [description]
     * @param  [type] $parameters [description]
     * @return [type]             [description]
     */
    public function validatecheckCurrentPassword($attribute, $value, $parameters)
    {
        $current_password = User::select('password', 'id')->where('id', \Auth::user()->id)->first();
        if (\Hash::check($value, $current_password->password)) {
            $count = 0;
        } else {
            $count = 1;
        }

        if ($count === 0) {

            return true;

        } else {

            return false;
        }
    }

}
