@extends ('layouts.app')

@section ('content')
    <audio controls src="{{ $radio->stream_url }}"></audio>
@endsection
