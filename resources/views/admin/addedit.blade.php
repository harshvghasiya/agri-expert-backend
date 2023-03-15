@extends('layouts.master')
@section('title')
    @if ($title != null && $title != '')
        {{ $title }}
    @else
        {{ trans('message.admin_title') }}
    @endif | {{ trans('message.app_name') }}
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ uploadAndDownloadUrl() }}admin/assets/css/toggle.css">

@endsection
@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ trans('message.admin_management') }}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        @if (isset($admin))
                            {{ trans('message.edit') }}
                        @else
                            {{ trans('message.create') }}
                        @endif
                        {{ trans('message.admin') }}

                    </li>
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
                        <h5 class="mb-0 text-primary">
                            @if (isset($admin))
                                {{ trans('message.edit') }}
                            @else
                                {{ trans('message.create') }}
                            @endif {{ trans('message.admin') }}
                        </h5>
                    </div>
                    <hr>
                    @if (isset($admin))
                        {{ Form::model($admin, [
                            'id' => 'AddEditCompanyCategory',
                            'class' => 'FromSubmit row g-3',
                            'url' => route('admin.admin_user.update', $encryptedId),
                            'method' => 'PUT',
                            'enctype' => 'multipart/form-data',
                        ]) }}
                        <input type="hidden" name="id" value="{{ $encryptedId }}">
                    @else
                        {{ Form::open([
                            'id' => 'AddEditCompanyCategory',
                            'class' => 'FromSubmit row g-3',
                            'url' => route('admin.admin_user.store'),
                            'name' => 'socialMedia',
                            'enctype' => 'multipart/form-data',
                        ]) }}
                    @endif

                    <div class="col-md-8">
                        <label for="name" class="form-label">{{ trans('message.name_label') }}</label>
                        <span class="text-danger">*</span>
                        {{ Form::text('name', null, ['placeholder' => trans('message.name_placeholder'), 'id' => 'name', 'class' => 'form-control']) }}
                        <span class="text-danger error_form" id="name_error"></span>

                    </div>

                    <div class="col-md-8">
                        <label for="name" class="form-label">{{ trans('message.email_label') }}</label>
                        <span class="text-danger">*</span>
                        {{ Form::text('email', null, ['placeholder' => trans('message.email_placeholder'), 'id' => 'email', 'class' => 'form-control']) }}
                        <span class="text-danger error_form" id="email_error"></span>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="flexCheckDefault" class="form-label">{{ trans('message.is_super_admin') }}</label>
                            <div class="col-md-4">
                                <input type="checkbox" @if( isset($admin) && $admin->is_super_admin == 1) checked @endif name="is_super_admin" class="form-control" value="1"  data-toggle="toggle" data-on="Yes" data-off="No" data-onstyle="success" data-offstyle="danger" data-width="100">
                            </div>
                        </div>
                    </div>

                    @if(isset($admin))
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="flexCheckDefault" class="form-label">{{ trans('message.change_password') }}</label>
                                <div class="col-md-4">
                                    <input type="checkbox" name="change_password" class="form-control change_password" value="1"  data-toggle="toggle" data-on="Yes" data-off="No" data-onstyle="success" data-offstyle="danger" data-width="100">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="display: none;" id="show_hide_password">
                            <div class="form-group">
                                <label for="projectinput2">{{ trans('message.password') }}</label><span
                                    class="text-danger">*</span>
                                {{ Form::text('password', null, ['placeholder' => 'Password', 'id' => 'password', 'class' => 'form-control password']) }}
                                <span class="text-danger error_form" id="password_error"></span><br>
                            </div>
                            <div class="form-group">
                                <button type="button"
                                    class="btn btn-info  text-light genrate_password">{{ trans('message.generate_password') }}</button>
                            </div>
                        </div>
                    @else
                    
                    <div class="col-md-8">
                        <label for="name" class="form-label">{{ trans('message.password_label') }}</label>
                        <span class="text-danger">*</span>
                        {{ Form::text('password', null, ['placeholder' => trans('message.password_placeholder'), 'id' => 'password', 'class' => 'form-control password']) }}
                        <span class="text-danger error_form" id="password_error"></span>
                        <div class="form-group mt-3">
                            <button type="button"
                                class="btn btn-info text-light genrate_password">{{ trans('message.generate_password') }}</button>
                        </div>

                    </div>
                    @endif

                    <div class="col-md-8">
                        <label for="email" class="form-label">{{ trans('message.status_label') }}</label><br>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" checked type="radio" name="status" id="inlineRadio1"
                                value="1" {{ isset($admin) ? ($admin->status == 1 ? 'checked' : '') : 'checked' }}>
                            <label class="form-check-label" for="inlineRadio1">{{ trans('message.active_label') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="0"
                                {{ isset($admin) ? ($admin->status == 0 ? 'checked' : '') : '' }}>
                            <label class="form-check-label"
                                for="inlineRadio1">{{ trans('message.inactive_label') }}</label>
                        </div>
                    </div>


                    <hr>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary px-4">{{ trans('message.save') }}</button>
                        <a href="{{ route('admin.admin_user.index') }}"
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js" integrity="sha512-F636MAkMAhtTplahL9F6KmTfxTmYcAcjcCkyu0f0voT3N/6vzAuJ4Num55a0gEJ+hRLHhdz3vDvZpf6kqgEa5w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
    $(document).on("change", ".change_password", function() {

        if ($(".change_password").prop("checked")) {
            $("#show_hide_password").show();
        } else {
            $("#show_hide_password").hide();
        }
    });

</script>
@endsection
