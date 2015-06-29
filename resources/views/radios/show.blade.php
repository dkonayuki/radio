@extends ('layouts.app')

@section ('content')
<div id="radio-show">
    <h3>{{ $radio->name }}</h3>
    <audio controls src="{{ $radio->stream_url }}"></audio>
    <br/>
    <div id="radio-des">
        {{ $radio->description }}
    </div>
    <div id="radio-menu">
        <a class="btn btn-info" href="{{ route('radios.edit', $radio->id) }}">Edit</a>
        <a id="radio-delete-btn" class="btn btn-danger" href="{{ route('radios.destroy', $radio->id) }}" data-method="delete" class="radio-delete-btn">Delete</a> 
    </div>
</div>
@endsection
