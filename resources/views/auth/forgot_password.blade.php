@extends('auth.auth')
@section('title')
    {{ trans('message.forgot_password') }}
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="border p-4 rounded">
                <div class="text-center">
                    <h3 class="">{{ trans('message.forget_password') }}</h3>

                </div>

                <div class="form-body">
                    {{ Form::open([
                        'id' => 'resetPassword',
                        'class' => 'FromSubmit row g-3',
                        'url' => route('admin.forgot_password'),
                        'enctype' => 'multipart/form-data',
                    ]) }}
                    <div class="col-12">
                        <label for="inputEmailAddress" class="form-label">{{ trans('message.email_address_label') }}</label>
                        <input type="email" name="email" class="form-control" id="inputEmailAddress"
                            placeholder="{{ trans('message.email_address_label') }}">
                        <span class="text-danger error_form" id="email_error"></span>

                    </div>
                    @if (isset($setting->is_recaptcha) && $setting->is_recaptcha == 1)
                        {!! RecaptchaV3::field('register') !!}
                    @endif
                    <div class="col-md-12 text-end"> <a
                            href="{{ route('admin.login') }}">{{ trans('message.login_here') }}</a>
                    </div>
                    <div class="col-12">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary"><i
                                    class="bx bxs-lock-open"></i>{{ trans('message.send_reset_link') }}</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
