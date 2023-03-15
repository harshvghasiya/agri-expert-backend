@extends('layouts.master')
@section('title')
    @if ($title != null && $title != '')
        {{ $title }}
    @else
        {{ trans('message.profile') }}
    @endif | {{ trans('message.app_name') }}
@endsection
@section('style')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ trans('message.admin') }} {{ trans('message.profile') }}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('message.admin') }}
                        {{ trans('message.profile') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ uploadAndDownloadUrl() }}admin/assets/images/avatars/avatar-8.png"
                                    alt="Admin" class=" p-1 bg-primary" width="110">
                                <div class="mt-3">
                                    <h4>{{ Auth::user()->name }}</h4>
                                    <p class="text-secondary mb-1">
                                    </p>
                                </div>
                            </div>
                            <hr class="my-4" />
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    Email::<h6 class="mb-0">{{ \Auth::user()->email }}</h6>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    Username::<h6 class="mb-0"> {{ \Auth::user()->name }}</h6>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        {{ Form::model(Auth::user(), [
                            'id' => 'AddEditAdmin',
                            'class' => 'FromSubmit',
                            'url' => route('admin.profile_update', Crypt::encrypt(Auth::user()->id)),
                            'method' => 'PUT',
                            'enctype' => 'multipart/form-data',
                        ]) }}
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">{{ trans('message.user_name_label') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ Form::text('name', null, ['placeholder' => trans('message.name_placeholder'), 'id' => 'name', 'class' => 'form-control']) }}
                                    <span class="text-danger error_form" id="name_error"></span>

                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">{{ trans('message.email_address_label') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ Form::text('email', null, ['placeholder' => trans('message.email_placeholder'), 'id' => 'email', 'class' => 'form-control']) }}
                                    <span class="text-danger error_form" id="email_error"></span>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-10 text-secondary">
                                    <button type="submit"
                                        class="btn btn-primary px-4">{{ trans('message.save_changes') }}</button>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>

                    <div class="card">
                        {{ Form::model(Auth::user(), [
                            'id' => 'AddEditAdmin2',
                            'class' => 'FromSubmit',
                            'url' => route('admin.password_update', Crypt::encrypt(Auth::user()->id)),
                            'method' => 'PUT',
                            'enctype' => 'multipart/form-data',
                        ]) }}
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">{{ trans('message.current_password') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ Form::text('current_password', null, ['placeholder' => trans('message.current_password_placeholder'), 'id' => 'current_password', 'class' => 'form-control']) }}
                                    <span class="text-danger error_form" id="current_password_error"></span>

                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">{{ trans('message.new_password_label') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ Form::text('password', '', ['placeholder' => trans('message.new_password_label'), 'id' => 'password', 'class' => 'form-control password']) }}
                                    <span class="text-danger error_form" id="password_error"></span>
                                    <div class="form-group mt-2">
                                        <button type="button"
                                            class="btn btn-info  text-light genrate_password">{{ trans('message.generate_password') }}</button>
                                    </div>
                                </div>
                                

                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">{{ trans('message.confirm_password_label') }}</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ Form::text('password_confirmation', null, ['placeholder' => trans('message.confirm_password_label'), 'id' => 'confirm-passsword', 'class' => 'form-control']) }}
                                    <span class="text-danger error_form" id="password_confirmation_error"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-10 text-secondary">
                                    <button type="submit"
                                        class="btn btn-primary px-4">{{ trans('message.update_password') }}</button>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('.genrate_password').on('click', function(event) {
            event.preventDefault();
            cap = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"
            nonal = "$%!#"
            it="1234567890"
            randnum =  Math.ceil(Math.random() * 8)
            non_alpha =  Math.ceil(Math.random() * 2)
            var password = Math.random().toString(36).slice(-6) + cap.toString(2).slice(randnum,
                randnum + 1) + nonal.toString(4).slice(non_alpha,non_alpha+1)+it.toString(1).slice(randnum,randnum+1)
            $('.password').attr('type', 'text');
            $('.password').val(password);
        });
    });
</script>
@endsection