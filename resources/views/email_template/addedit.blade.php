@extends('layouts.master')
@section('title')
    @if ($title != null && $title != '')
        {{ $title }}
    @else
        {{ trans('message.email_template_title') }}
    @endif | {{ trans('message.app_name') }}
@endsection
@section('style')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ trans('message.email_template_management') }}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        @if (isset($email_template))
                            {{ trans('message.edit') }}
                        @else
                            {{ trans('message.create') }}
                        @endif
                        {{ trans('message.email_template') }}

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
                            @if (isset($email_template))
                                {{ trans('message.edit') }}
                            @else
                                {{ trans('message.create') }}
                            @endif {{ trans('message.email_template') }}
                        </h5>
                    </div>
                    <hr>
                    @if (isset($email_template))
                        {{ Form::model($email_template, [
                            'id' => 'AddEditCompanyCategory',
                            'class' => 'FromSubmit row g-3',
                            'url' => route('admin.email_template.update', $encryptedId),
                            'method' => 'PUT',
                            'enctype' => 'multipart/form-data',
                        ]) }}
                        <input type="hidden" name="id" value="{{ $encryptedId }}">
                    @else
                        {{ Form::open([
                            'id' => 'AddEditCompanyCategory',
                            'class' => 'FromSubmit row g-3',
                            'url' => route('admin.email_template.store'),
                            'name' => 'socialMedia',
                            'enctype' => 'multipart/form-data',
                        ]) }}
                    @endif

                    <div class="col-md-8">
                        <label for="name" class="form-label">{{ trans('message.title_label') }}</label>
                        <span class="text-danger">*</span>
                        {{ Form::text('title', null, ['placeholder' => trans('message.title_placeholder'), 'id' => 'title', 'class' => 'form-control']) }}
                        <span class="text-danger error_form" id="title_error"></span>

                    </div>
                    <div class="col-md-8">
                        <label for="name" class="form-label">{{ trans('message.subject_label') }}</label>
                        <span class="text-danger">*</span>
                        {{ Form::text('subject', null, ['placeholder' => trans('message.subject_placeholder'), 'id' => 'subject', 'class' => 'form-control ']) }}
                        <span class="text-danger error_form" id="subject_error"></span>
                    </div>
                    <div class="col-md-8">
                        <label for="name" class="form-label">{{ trans('message.from_label') }}</label>
                        <span class="text-danger">*</span>
                        {{ Form::text('from', null, ['placeholder' => trans('message.from_placeholder'), 'id' => 'from', 'class' => 'form-control ']) }}
                        <span class="text-danger error_form" id="from_error"></span>
                    </div>

                    <div class="col-md-8">
                        <label for="name" class="form-label">{{ trans('message.description_label') }}</label>
                        {{ Form::textarea('description', null, ['placeholder' => trans('message.description_placeholder'), 'id' => 'description', 'class' => 'form-control editor-tinymce', 'rows' => 3]) }}
                        <span class="text-danger error_form" id="description_error"></span>
                    </div>
                    <div class="col-md-8">
                        <label for="email" class="form-label">{{ trans('message.status_label') }}</label><br>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" checked type="radio" name="status" id="inlineRadio1"
                                value="1" {{ isset($email_template) ? ($email_template->status == 1 ? 'checked' : '') : 'checked' }}>
                            <label class="form-check-label" for="inlineRadio1">{{ trans('message.active_label') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="0"
                                {{ isset($email_template) ? ($email_template->status == 0 ? 'checked' : '') : '' }}>
                            <label class="form-check-label"
                                for="inlineRadio1">{{ trans('message.inactive_label') }}</label>
                        </div>
                    </div>


                    <hr>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary px-4">{{ trans('message.save') }}</button>
                        <a href="{{ route('admin.email_template.index') }}"
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
@endsection
