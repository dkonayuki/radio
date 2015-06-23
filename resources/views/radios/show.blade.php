@extends ('layouts.app')

@section ('content')
    <audio controls src="{{ $radio->stream_url }}"></audio>
<a href="{{ route('radios.edit', $radio->id) }}">Edit</a> | <a href="{{ route('radios.destroy', $radio->id) }}" data-method="delete" class="radio-delete-btn">Delete</a> 
@endsection
