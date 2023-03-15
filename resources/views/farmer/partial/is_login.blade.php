
 @if (isset($data->is_login) && $data->is_login == 1)
    <p class="text-success"> {{ trans('message.farmer_login') }} </p>
 @else
    <p class="text-danger"> {{ trans('message.farmer_not_login') }} </p>
 @endif
