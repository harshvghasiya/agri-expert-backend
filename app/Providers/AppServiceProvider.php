<?php

namespace App\Providers;

use App\Validator\CustomeValidator;
use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (\Schema::hasTable('basic_settings')) {
            $setting = getBasicSetting();
            view()->share(['setting' => $setting]);
            $this->app->validator->resolver(function ($translator, $data, $rules, $messages) {
                return new CustomeValidator($translator, $data, $rules, $messages);
            });
        }
    }
}
