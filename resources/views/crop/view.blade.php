@extends('layouts.master')
@section('title')
    @if ($title != null && $title != '')
        {{ $title }} |
    @endif {{ trans('message.app_name') }}
@endsection
@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ trans('message.crop_management') }} </div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('message.view_crop') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"><i class="icon-person"></i> {{ $crop->title }} </h4>

                            <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6 mb-2">

                                <ul class="list-group list-group-flush flex-md-row">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span class="float-xs-right"> {{ $crop->description }} </span>
                                        <span class="font-weight-bold"> {{ trans('message.description') }}
                                        </span>
                                    </li>

                                </ul>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <hr class="border-top">
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-3 row-cols-xl-3">
                @if (isset($crop->crop_query) && $crop->crop_query != null)
                    @foreach ($crop->crop_query as $key => $value)
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-text">{{ $value->queries->title }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
@endsection
