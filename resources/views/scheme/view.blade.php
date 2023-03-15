@extends('layouts.master')
@section('title')
    @if ($title != null && $title != '')
        {{ $title }} |
    @endif {{ trans('message.app_name') }}
@endsection
@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ trans('message.scheme_management') }} </div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('message.view_scheme') }}</li>
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
                            <h4 class="card-title"><i class="icon-person"></i> {{ $scheme->title }} </h4>

                            <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row m-4">
                            <span class="float-xs-right"> {!! $scheme->description !!} </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
