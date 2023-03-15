
 @if (isset($data->image))
     <img src="{{ $data->getCropImageUrl() }}" width="75px" height="75px" alt="{{ $data->title }}">
 @else
     <img src="{{ $data->getCropImageUrl() }}" width="75px" height="75px" alt="{{ $data->title }}">
 @endif
