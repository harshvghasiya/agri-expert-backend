<audio autobuffer autoloop loop controls>
	<source src="{{ $data->getAnswerAudioUrl() }}">
	<source src="{{ $data->getAnswerAudioUrl() }}">
	<object type="audio/x-wav" data="{{ $data->getAnswerAudioUrl() }}" width="290" height="45">
		<param name="src" value="{{ $data->getAnswerAudioUrl() }}">
		<param name="autoplay" value="false">
		<param name="autoStart" value="0">
		<p><a href="{{ $data->getAnswerAudioUrl() }}">Download this audio file.</a></p>
	</object>
</audio>