@if( $data->video != null)
<video width="320" height="240" controls>
  <source src="{{ $data->getAnswerVideoUrl() }}" type="video/mp4">
</video>
@endif