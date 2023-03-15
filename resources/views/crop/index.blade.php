@extends('layouts.master')
@section('title')
    @if ($title != null && $title != '')
        {{ $title }} |
    @endif {{ trans('message.app_name') }}
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ uploadAndDownloadUrl() }}admin/assets/css/datatable/datable-jquery.css">
    <link rel="stylesheet" type="text/css" href="{{ uploadAndDownloadUrl() }}admin/assets/css/datatable/fixheader.css">
    <link rel="stylesheet" type="text/css" href="{{ uploadAndDownloadUrl() }}admin/assets/css/datatable/responsive.css">
@endsection
@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ trans('message.crop_management') }} </div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('message.index_crop_breadcrum') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="card">

        <div class="card-body">
            <div class="card-title">
                <h4 class="panel-title"><i class="fadeIn animated bx bx-abacus"></i> {{ trans('message.custome_filter') }}
                    <a href="javascript:void(0);" onclick="RESET_FORM();"><i
                            class="fadeIn animated bx bx-reset float-end"></i></a>
                </h4>
            </div>
            <div class="card-body">
                <form method="POST" id="search-form" class="form-inline" role="form">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" class="form-control search_text" name="title" id="title"
                                placeholder="{{ trans('message.search_title_placeholder') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="crop_query" class="form-control crop_query_filter select2" placeholder="{{ trans('message.select_crop_query_label') }}">
                                <option value="">{{ trans('message.select_crop_query_label') }}</option>
                                @if(\App\Models\Query::getQueryDropDown() != null)
                                @foreach(\App\Models\Query::getQueryDropDown() as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control status_filter">
                                <option value="">{{ trans('message.select_status_label') }}</option>
                                <option value="1">{{ trans('message.active_label') }}</option>
                                <option value="0">{{ trans('message.inactive_label') }}</option>
                            </select>
                        </div>

                    </div>
            </div>
        </div>

    </div>
    <div class="card">
        <div class="card-body">
            <div class="row m-4">
                <div class="col-md-6">
                    <div class="btn-group">
                        <a href="{{ route('admin.crop.create') }}" id="sample_editable_1_new" class="btn btn-primary">
                            <i class="lni lni-circle-plus"></i> {{ trans('message.add_new') }} {{ trans('message.crop') }}
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="btn-group float-end mx-1">
                        <button type="button" class="btn btn-info text-light"
                            onclick="statusAll('con_check','{{ route('admin.crop.status_all') }}',1)">{{ trans('message.acitve_all') }}</button>
                    </div>
                    <div class="btn-group float-end">
                        <button type="button" class="btn btn-warning text-light"
                            onclick="statusAll('con_check','{{ route('admin.crop.status_all') }}',2)">{{ trans('message.inacitve_all') }}</button>
                    </div>
                    <div class="btn-group float-end mx-1">
                        <a class="btn btn-danger "
                            onclick="deleteAll('con_check','{{ route('admin.crop.delete_all') }}')">{{ trans('message.delete_all_label') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                {{ Form::open([
                    'id' => 'table_form',
                    'class' => 'table_form',
                    'name' => 'form_data',
                ]) }}
                <table id="crop-table" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="checkbox[]" class="con_check" value="1" id="select_all" />
                            </th>
                            <th>{{ trans('message.title') }}</th>
                            <th>{{ trans('message.image') }}</th>
                            <th>{{ trans('message.description') }}</th>
                            <th>{{ trans('message.status') }}</th>
                            <th>{{ trans('message.action') }}</th>
                        </tr>
                    </thead>
                </table>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ uploadAndDownloadUrl() }}admin/assets/js/datatable/datatable-jquery.js"></script>
    <script src="{{ uploadAndDownloadUrl() }}admin/assets/js/datatable/datatable-ui-jquery.js"></script>
    <script src="{{ uploadAndDownloadUrl() }}admin/assets/js/datatable/fixheader.js"></script>
    <script src="{{ uploadAndDownloadUrl() }}admin/assets/js/datatable/datatable-responsive.js"></script>
    <script src="{{ uploadAndDownloadUrl() }}admin/assets/js/datatable/responsive-bootstrap.js"></script>
    <script>
        var oTable = $('#crop-table').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            responsive: true,
            ajax: {
                url: '{!! route('admin.crop.any_data') !!}',
                data: function(d) {
                    d.title = $('input[name=title]').val();
                    d.status = $('select[name=status]').val();
                    d.crop_query = $('select[name=crop_query]').val();
                }
            },
            columns: [{
                    data: 'id',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'title',
                    orderable: false
                },
                {
                    data: 'image',
                    orderable: false
                },
                {
                    data: 'description',
                    orderable: false
                },

                {
                    data: 'status',
                    orderable: false
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $(document).ready(function() {
            $(document).on("keyup", ".search_text", function() {
                oTable.draw();
                return false;
            });

            $(document).on("change", ".status_filter", function() {
                oTable.draw();
                return false;
            });

            $(document).on("change", ".crop_query_filter", function() {
                oTable.draw();
                return false;
            });


            function RESET_FORM() {
                $("#search-form").trigger('reset');
                oTable.draw();
                return false;
            }


            $(document).on("click", "#active_inactive", function() {

                swal({
                        title: "{{ trans('message.are_you_sure_want_change_status_label') }}",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var status = $(this).attr('status');
                            var id = $(this).attr('data-id');
                            var cur = $(this);
                            $.ajax({
                                type: "POST",
                                url: "{{ route('admin.crop.single_status_change') }}",
                                data: {
                                    "status": status,
                                    "id": id,
                                    "_token": "{{ csrf_token() }}"
                                },
                                success: function(data) {
                                    if (data.status == 0) {
                                        cur.removeClass('btn-success');
                                        cur.addClass('btn-danger');
                                        cur.text('{{ trans('message.inactive_label') }}');
                                    } else {
                                        cur.removeClass('btn-danger');
                                        cur.addClass('btn-success');
                                        cur.text('{{ trans('message.active_label') }}');
                                    }
                                }
                            })
                            swal("{{ trans('message.status_has_been_successfully_changed_label') }}", {
                                icon: "success",
                            });
                        }
                    });
            })
        });
    </script>
    <script type="text/javascript">
        $('.select2').select2({
          multiple: true,
          width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
          placeholder: $(this).data('placeholder'),
        });
  </script>
@endsection
