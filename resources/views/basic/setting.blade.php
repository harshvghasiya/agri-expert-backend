@extends('layouts.master')
@section('title')
    @if ($title != null && $title != '')
        {{ $title }}
    @else
        {{ trans('message.setting_title') }}
    @endif | {{ trans('message.app_name') }}
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ uploadAndDownloadUrl() }}admin/assets/css/toggle.css">

    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ trans('message.basic_setting_title') }}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ trans('message.basic_setting_title') }}s</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-11 mx-auto">
            <hr />
            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-body p-5">
                    <div class="card-title d-flex align-items-center">
                        <div>
                        </div>
                        <h5 class="mb-0 text-primary">{{ trans('message.update') }} {{ trans('message.basic_setting') }}
                        </h5>
                    </div>
                    <hr>
                    {{ Form::model($setting, [
                        'id' => 'BasicInfo',
                        'class' => 'FromSubmit row g-3',
                        'url' => route('admin.basic_setting.update_setting', $encryptedId),
                        'method' => 'PUT',
                        'enctype' => 'multipart/form-data',
                    ]) }}

                    <div class="col-md-6">
                        <label for="inputFirstName" class="form-label">{{ trans('message.logo') }}</label>

                        <input class="form-control" onchange=loadFile(event) name="logo" type="file">
                    </div>
                    <div class="col-md-6">
                        <label for="inputFirstName" class="form-label">{{ trans('message.favicon') }}</label>
                        <input class="form-control" onchange=loadFav(event) name="favicon" type="file">
                    </div>
                    <div class="col-md-6 mb-3">
                        @if (isset($setting) && $setting->logo != null)
                            <img class="imagePreview" style="width: 150px; height: 150px;" id="output"
                                src="{{ $setting->getLogoImageUrl() }}" />
                        @endif
                        
                    </div>
                    <div class="col-md-6 mb-3">
                        @if (isset($setting) && $setting->favicon != null)

                            <img class="imagePreview" style="width: 150px; height: 150px;" id="output2"
                                src="{{ $setting->getFaviconImageUrl() }}" />
                        @endif
                        
                    </div>

                    <div class="col-md-6">
                        <label for="inputFirstName" class="form-label">{{ trans('message.recaptcha_secret_key') }}</label>
                        {{ Form::text('google_recaptcha_secret_key', null, ['placeholder' => trans('message.recaptcha_secret_key'), 'id' => 'webtitle', 'class' => 'form-control']) }}
                    </div>
                    <div class="col-md-6">
                        <label for="inputLastName" class="form-label">{{ trans('message.recaptcha_site_key') }}</label>
                        {{ Form::text('google_recaptcha_site_key', null, ['placeholder' => trans('message.recaptcha_site_key'), 'id' => 'webtitle', 'class' => 'form-control']) }}
                    </div>
                    <div class="col-md-12">
                        <label for="inputLastName"
                            class="form-label">{{ trans('message.recaptcha_enabled_disabled_label') }}</label>
                        <div class="form-check form-switch">
                            <input type="checkbox" @if (isset($setting) && $setting->is_recaptcha == 1) checked @endif name="is_recaptcha"
                                class="form-control" value="1" data-toggle="toggle" data-on="Yes" data-off="No"
                                data-onstyle="success" data-offstyle="danger" data-width="100">
                        </div>
                    </div>

                    <hr>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary px-4">{{ trans('message.save') }}</button>
                        <a href="{{ route('admin.dashboard') }}"
                            class="btn btn-secondary">{{ trans('message.cancle') }}</a>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
            <hr />

        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"
        integrity="sha512-F636MAkMAhtTplahL9F6KmTfxTmYcAcjcCkyu0f0voT3N/6vzAuJ4Num55a0gEJ+hRLHhdz3vDvZpf6kqgEa5w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            console.log(output.src);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };

        var loadFav = function(event) {
            var output = document.getElementById('output2');
            output.src = URL.createObjectURL(event.target.files[0]);
            console.log(output.src);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>
@endsection
