@extends('layouts.master')
@section('title')
    @if ($title != null && $title != '')
        {{ $title }}
    @else
        {{ trans('message.crop_title') }}
    @endif | {{ trans('message.app_name') }}
@endsection
@section('style')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ trans('message.crop_management') }}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        @if (isset($crop))
                            {{ trans('message.edit') }}
                        @else
                            {{ trans('message.create') }}
                        @endif
                        {{ trans('message.crop') }}

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
                            @if (isset($crop))
                                {{ trans('message.edit') }}
                            @else
                                {{ trans('message.create') }}
                            @endif {{ trans('message.crop') }}
                        </h5>
                    </div>
                    <hr>
                    @if (isset($crop))
                        {{ Form::model($crop, [
                            'id' => 'AddEditCompanyCategory',
                            'class' => 'FromSubmit row g-3',
                            'url' => route('admin.crop.update', $encryptedId),
                            'method' => 'PUT',
                            'enctype' => 'multipart/form-data',
                        ]) }}
                        <input type="hidden" name="id" value="{{ $encryptedId }}">
                    @else
                        {{ Form::open([
                            'id' => 'AddEditCompanyCategory',
                            'class' => 'FromSubmit row g-3',
                            'url' => route('admin.crop.store'),
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
                        <label for="name" class="form-label">{{ trans('message.description_label') }}</label>
                        {{ Form::textarea('description', null, ['placeholder' => trans('message.description_placeholder'), 'id' => 'description', 'class' => 'form-control', 'rows' => 3]) }}
                        <span class="text-danger error_form" id="description_error"></span>
                    </div>

                    <div class="col-md-8">
                        <label for="formFile" class="form-label">{{ trans('message.image') }}</label> 
                        <input class="form-control" name="image" type="file" id="formFile">
                        <span class="text-danger error_form" id="image_error"></span>
                    </div>

                    <div class="col-md-8">
                        <label for="email" class="form-label">{{ trans('message.status_label') }}</label><br>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" checked type="radio" name="status" id="inlineRadio1"
                                value="1" {{ isset($crop) ? ($crop->status == 1 ? 'checked' : '') : 'checked' }}>
                            <label class="form-check-label" for="inlineRadio1">{{ trans('message.active_label') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="0"
                                {{ isset($crop) ? ($crop->status == 0 ? 'checked' : '') : '' }}>
                            <label class="form-check-label"
                                for="inlineRadio1">{{ trans('message.inactive_label') }}</label>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="card-title d-flex align-items-center mt-2">
                            <h5 class="mb-0 text-primary">{{ trans('message.query') }} {{ trans('message.list') }}</h5>
                            <div class="form-check mx-4 pt-1">
                                <input type="checkbox" name="checke_all" id="checked_all" class="form-check-input">
                                <label class="form-check-label" for="checked_all">{{ trans('message.check_all') }}</label>
                            </div>
                            <span class="text-danger error_form" id="query_id_error"></span>

                        </div>
                        <hr>
                        <div class="row">

                            @if (\App\Models\Query::getQueryDropDown() != null)
                                @foreach (\App\Models\Query::getQueryDropDown() as $key => $value)
                                    <div class="col-md-4">
                                        @php
                                            $checked = '';
                                        @endphp
                                        @if (isset($crop) && $crop->crop_query != null)
                                            @foreach ($crop->crop_query as $k => $val)
                                                @php
                                                    
                                                    if ($val->query_id == $key) {
                                                        $checked = 'checked';
                                                        break;
                                                    }
                                                @endphp
                                            @endforeach
                                            <div class="form-check">
                                                {{ Form::checkbox('query_id[]', $key, $checked, ['class' => 'right_data form-check-input', 'id' => "flexCheckDefault$key"]) }}
                                                <label class="form-check-label"
                                                    for="flexCheckDefault{{ $key }}">{{ $value }}</label>
                                            </div>
                                        @else
                                            <div class="form-check">
                                                {{ Form::checkbox('query_id[]', $key, null, ['class' => 'right_data form-check-input', 'id' => "flexCheckDefault$key"]) }}
                                                <label class="form-check-label"
                                                    for="flexCheckDefault{{ $key }}">{{ $value }}</label>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>


                    <hr>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary px-4">{{ trans('message.save') }}</button>
                        <a href="{{ route('admin.crop.index') }}"
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
    </script>
@endsection
