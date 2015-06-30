@extends ('layouts.app')

@section ('content')
<div id="radio-show">
    <h3>{{ $radio->name }}</h3>
    <div id="radio-show-img">
        <img src="{{ $radio->getImgUrl() }}"></img>
    </div>
    <audio controls src="{{ $radio->stream_url }}"></audio>
    <br/>
    <div id="radio-show-des">
        {{ $radio->description }}
    </div>
    <div id="radio-show-menu">
        <a class="btn btn-info" href="{{ route('radios.edit', $radio->id) }}">Edit</a>
        <a id="radio-delete-btn" class="btn btn-danger" href="{{ route('radios.destroy', $radio->id) }}" data-method="delete" class="radio-delete-btn">Delete</a> 
    </div>
</div>
@endsection
