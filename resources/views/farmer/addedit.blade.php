@extends('layouts.master')
@section('title')
    @if ($title != null && $title != '')
        {{ $title }}
    @else
        {{ trans('message.farmer_title') }}
    @endif | {{ trans('message.app_name') }}
@endsection
@section('style')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ trans('message.farmer_management') }}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        @if (isset($farmer))
                            {{ trans('message.edit') }}
                        @else
                            {{ trans('message.create') }}
                        @endif
                        {{ trans('message.farmer') }}

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
                            @if (isset($farmer))
                                {{ trans('message.edit') }}
                            @else
                                {{ trans('message.create') }}
                            @endif {{ trans('message.farmer') }}
                        </h5>
                    </div>
                    <hr>
                    @if (isset($farmer))
                        {{ Form::model($farmer, [
                            'id' => 'AddEditCompanyCategory',
                            'class' => 'FromSubmit row g-3',
                            'url' => route('admin.farmer.update', $encryptedId),
                            'method' => 'PUT',
                            'enctype' => 'multipart/form-data',
                        ]) }}
                        <input type="hidden" name="id" value="{{ $encryptedId }}">
                    @else
                        {{ Form::open([
                            'id' => 'AddEditCompanyCategory',
                            'class' => 'FromSubmit row g-3',
                            'url' => route('admin.farmer.store'),
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
                        <label for="name" class="form-label">{{ trans('message.mobile_label') }}</label>
                        <span class="text-danger">*</span>
                        {{ Form::text('mobile', null, ['placeholder' => trans('message.mobile_placeholder'), 'id' => 'mobile', 'class' => 'form-control']) }}
                        <span class="text-danger error_form" id="mobile_error"></span>

                    </div>

                    <div class="col-md-8">
                        <label for="name" class="form-label">{{ trans('message.village_label') }}</label>
                        <span class="text-danger">*</span>
                        {{ Form::text('village', null, ['placeholder' => trans('message.village_placeholder'), 'id' => 'village', 'class' => 'form-control']) }}
                        <span class="text-danger error_form" id="village_error"></span>

                    </div>

                    <div class="col-md-8">
                        <label for="name" class="form-label">{{ trans('message.taluka_label') }}</label>
                        
                        {{ Form::text('taluka', null, ['placeholder' => trans('message.taluka_placeholder'), 'id' => 'taluka', 'class' => 'form-control']) }}
                        <span class="text-danger error_form" id="taluka_error"></span>

                    </div>

                    <div class="col-md-8">
                        <label for="email" class="form-label">{{ trans('message.status_label') }}</label><br>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" checked type="radio" name="status" id="inlineRadio1"
                                value="1" {{ isset($farmer) ? ($farmer->status == 1 ? 'checked' : '') : 'checked' }}>
                            <label class="form-check-label" for="inlineRadio1">{{ trans('message.active_label') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="0"
                                {{ isset($farmer) ? ($farmer->status == 0 ? 'checked' : '') : '' }}>
                            <label class="form-check-label"
                                for="inlineRadio1">{{ trans('message.inactive_label') }}</label>
                        </div>
                    </div>


                    <hr>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary px-4">{{ trans('message.save') }}</button>
                        <a href="{{ route('admin.farmer.index') }}"
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
