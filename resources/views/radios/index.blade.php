@extends('layouts.app')

@section ('content')
<div id="radio-index">
    <h2>List of available radio stations</h2>
        <div id="radios-list">
            @foreach ($radios as $radio)
                @include ('radios/_radio', ['radio' => $radio])
            @endforeach
        </div>
</div>
@endsection
