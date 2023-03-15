@extends('layouts.master')
@section('title')
    @if ($title != null && $title != '')
        {{ $title }}
    @else
        {{ trans('message.answer_title') }}
    @endif | {{ trans('message.app_name') }}
@endsection
@section('style')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ trans('message.answer_management') }}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        @if (isset($answer))
                            {{ trans('message.edit') }}
                        @else
                            {{ trans('message.create') }}
                        @endif
                        {{ trans('message.answer') }}

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
                            @if (isset($answer))
                                {{ trans('message.edit') }}
                            @else
                                {{ trans('message.create') }}
                            @endif {{ trans('message.answer') }}
                        </h5>
                    </div>
                    <hr>
                    @if (isset($answer))
                        {{ Form::model($answer, [
                            'id' => 'AddEditCompanyCategory',
                            'class' => 'FromSubmit row g-3',
                            'url' => route('admin.answer.update', $encryptedId),
                            'method' => 'PUT',
                            'enctype' => 'multipart/form-data',
                        ]) }}
                        <input type="hidden" name="id" value="{{ $encryptedId }}">
                    @else
                        {{ Form::open([
                            'id' => 'AddEditCompanyCategory',
                            'class' => 'FromSubmit row g-3',
                            'url' => route('admin.answer.store'),
                            'name' => 'socialMedia',
                            'enctype' => 'multipart/form-data',
                        ]) }}
                    @endif

                    <div class="col-md-8">
                        <label for="name" class="form-label">{{ trans('message.answer_label') }}</label>
                        {{ Form::textarea('answer', null, ['placeholder' => trans('message.answer_placeholder'), 'id' => 'answer', 'class' => 'form-control','rows' => 3]) }}
                        <span class="text-danger error_form" id="answer_error"></span>

                    </div>

                    <div class="col-md-8">
                        <label for="formFile" class="form-label">{{ trans('message.image') }}</label> 
                        <input class="form-control" name="image" type="file" id="formFile">
                        <span class="text-danger error_form" id="image_error"></span>
                    </div>

                    @if (isset($answer) )
                        <div class="col-md-3 ">
                                <label for="formFile" class="form-label mt-3"></label> 
                                <button type="button" class="btn btn-danger form-control delete_thum"
                                    data-thum_id={{ \Crypt::encryptString($answer->id . timeFormatString()) }}>{{ trans('message.delete') }}</button>
                        </div>
                    @endif

                    <div class="col-md-8">
                        <label for="formFile" class="form-label">{{ trans('message.video') }}</label> 
                        <input class="form-control" name="video" type="file" id="formFile">
                        <span class="text-danger error_form" id="video_error"></span>

                    </div>

                    @if (isset($answer))
                        <div class="col-md-3 ">

                        <label for="formFile" class="form-label mt-3"></label> 
                                <button type="button" class="btn btn-danger form-control delete_video"  data-answer_id={{ \Crypt::encryptString($answer->id . timeFormatString()) }}>{{ trans('message.delete') }}</button>
                        </div>
                    @endif
                        
                    <div class="col-md-8">
                        <label for="formFile" class="form-label">{{ trans('message.audio') }}</label> 
                        <input class="form-control" name="audio" type="file" id="formFile">
                        <span class="text-danger error_form" id="audio_error"></span>
                    </div>

                    @if (isset($answer) )
                        <div class="col-md-3 ">
                                <label for="formFile" class="form-label mt-3"></label> 
                                <button type="button" class="btn btn-danger form-control delete_audio"
                                    data-audio_id={{ \Crypt::encryptString($answer->id . timeFormatString()) }}>{{ trans('message.delete') }}</button>
                        </div>
                    @endif

                    <div class="col-md-8">
                        <label for="email" class="form-label">{{ trans('message.status_label') }}</label><br>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" checked type="radio" name="status" id="inlineRadio1"
                                value="1" {{ isset($answer) ? ($answer->status == 1 ? 'checked' : '') : 'checked' }}>
                            <label class="form-check-label" for="inlineRadio1">{{ trans('message.active_label') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="0"
                                {{ isset($answer) ? ($answer->status == 0 ? 'checked' : '') : '' }}>
                            <label class="form-check-label"
                                for="inlineRadio1">{{ trans('message.inactive_label') }}</label>
                        </div>
                    </div>

                  

                    <hr>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary px-4">{{ trans('message.save') }}</button>
                        <a href="{{ route('admin.answer.index') }}"
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
    <script type="text/javascript">
        $(document).ready(function() {
            if ($("#checked_all").length > 0) {
                $(document).on("click", "#checked_all", function() {
                    select_all_right();
                });
            }

            function select_all_right() {
                console.log("in");
                if ($("#checked_all").prop("checked")) {
                    $(".right_data").each(function() {
                        $(this).prop("checked", true);
                    });
                } else {
                    $(".right_data").prop("checked", false);
                }
            }

        });

         $(document).on('click', '.delete_video', function(event) {
            event.preventDefault();
            var btntxt = $(this).text()
            var answer_id = $(this).data('answer_id')
            $(this).text('Process..')
            $(this).attr('disabled', 'disabled');
            var op = $(this)
            $.ajax({
                url: '{{ route('admin.answer.video_delete') }}',
                type: 'POST',
                data: {
                    answer_id: answer_id
                },
                success: function(response) {
                    if (response.success == true) {
                        $.notify(response.msg, {
                            type: 'success',
                            allow_dismiss: false,
                            delay: 3000,
                            showProgressbar: false,
                            timer: 300
                        });
                        op.text(btntxt)
                        op.removeAttr('disabled')
                    }
                }
            });

        });

        $(document).on('click', '.delete_thum', function(event) {
            event.preventDefault();
            var btntxt = $(this).text()
            var thum_id = $(this).data('thum_id')
            $(this).text('Process..')
            $(this).attr('disabled', 'disabled');
            var op = $(this)
            $.ajax({
                url: '{{ route('admin.answer.thum_delete') }}',
                type: 'POST',
                data: {
                    thum_id: thum_id
                },
                success: function(response) {
                    if (response.success == true) {
                        $.notify(response.msg, {
                            type: 'success',
                            allow_dismiss: false,
                            delay: 3000,
                            showProgressbar: false,
                            timer: 300
                        });
                        op.text(btntxt)
                        op.removeAttr('disabled')
                    }
                }
            });

        });

         $(document).on('click', '.delete_audio', function(event) {
            event.preventDefault();
            var btntxt = $(this).text()
            var audio_id = $(this).data('audio_id')
            $(this).text('Process..')
            $(this).attr('disabled', 'disabled');
            var op = $(this)
            $.ajax({
                url: '{{ route('admin.answer.audio_delete') }}',
                type: 'POST',
                data: {
                    audio_id: audio_id
                },
                success: function(response) {
                    if (response.success == true) {
                        $.notify(response.msg, {
                            type: 'success',
                            allow_dismiss: false,
                            delay: 3000,
                            showProgressbar: false,
                            timer: 300
                        });
                        op.text(btntxt)
                        op.removeAttr('disabled')
                    }
                }
            });

        });
    </script>
@endsection
