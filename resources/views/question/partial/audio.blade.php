<audio autobuffer autoloop loop controls>
	<source src="{{ $data->getQuestionAudioUrl() }}">
	<source src="{{ $data->getQuestionAudioUrl() }}">
	<object type="audio/x-wav" data="{{ $data->getQuestionAudioUrl() }}" width="290" height="45">
		<param name="src" value="{{ $data->getQuestionAudioUrl() }}">
		<param name="autoplay" value="false">
		<param name="autoStart" value="0">
		<p><a href="{{ $data->getQuestionAudioUrl() }}">Download this audio file.</a></p>
	</object>
</audio>