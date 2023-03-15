@extends('auth.auth')
@section('title')
    {{ trans('message.login') }}

@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="border p-4 rounded">
                <div class="text-center">
                    <h3 class="">{{ trans('message.login') }}</h3>
                </div>

                <div class="form-body">
                    {{ Form::open([
                        'id' => 'FaviconUpdate',
                        'class' => 'FromSubmit row g-3',
                        'url' => route('admin.postlogin'),
                        'enctype' => 'multipart/form-data',
                    ]) }}
                    <div class="col-12">
                        <label for="inputEmailAddress" class="form-label">{{ trans('message.email_label') }}</label>
                        <input type="email" name="email" class="form-control" id="inputEmailAddress"
                            placeholder="{{ trans('message.email_label') }}">
                        <span class="text-danger error_form" id="email_error"></span>
                    </div>
                    <div class="col-12">
                        <label for="inputChoosePassword" class="form-label">{{ trans('message.password_label') }}</label>
                        <div class="input-group" id="show_hide_password">
                            <input type="password" name="password" class="form-control border-end-0"
                                id="inputChoosePassword" placeholder="{{ trans('message.password_label') }}"> <a
                                href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>

                        </div>
                        <span class="text-danger error_form" id="password_error"></span>
                    </div>
                    @if (isset($setting->is_recaptcha) && $setting->is_recaptcha == 1)
                        {!! RecaptchaV3::field('register') !!}
                    @endif
                    <div class="col-md-12 text-end"> <a
                            href="{{ route('admin.forgot_password_form') }}">{{ trans('message.forgot_password_label') }}</a>
                    </div>
                    <div class="col-12">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary"><i
                                    class="bx bxs-lock-open"></i>{{ trans('message.login_button_text') }}</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
