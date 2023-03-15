@if(isset($data->question_upvote) && $data->question_upvote != null && $data->question_upvote->count() != 0)
	<p class="text-success"> {{ $data->question_upvote->count() }} </p>
@else
	<p class="text-danger">0</p>
@endif