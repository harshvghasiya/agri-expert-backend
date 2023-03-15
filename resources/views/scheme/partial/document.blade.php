@if (isset($data) && $data->document != null)
    <a class="btn btn-primary btn-sm" target="_blank" href="{{ $data->getDocumentUrl() }}"><i class="lni lni-download"></i>
        {{ trans('message.document') }}</a>
@endif
