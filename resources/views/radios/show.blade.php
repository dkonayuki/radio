@extends ('layouts.app')

@section ('content')
<div id="radio-show">
    <audio controls src="{{ $radio->stream_url }}"></audio>
    <br/>
    <div id="radio-menu">
        <a class="btn btn-info" href="{{ route('radios.edit', $radio->id) }}">Edit</a><a class="btn btn-danger" href="{{ route('radios.destroy', $radio->id) }}" data-method="delete" class="radio-delete-btn">Delete</a> 
    </div>
</div>
@endsection
