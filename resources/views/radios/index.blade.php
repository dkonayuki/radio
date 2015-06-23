@extends('layouts.app')

@section ('content')
<div id="radio-index">
    <h2>List of available radio stations</h2>
    @foreach ($radios as $radio)
        @include ('radios/_radio', ['radio' => $radio])
    @endforeach
</div>
@endsection
