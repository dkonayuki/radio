@extends('layouts.app')

@section ('content')
<div id="radio-index">
    <h3>List of available radio stations</h3>
        <div id="radios-list">
            @foreach ($radios as $radio)
                @include ('radios/_radio', ['radio' => $radio])
            @endforeach
        </div>
</div>

<div id="radio-pagination">
    {!! $radios->appends(Request::only('query'))->render() !!}
</div>
@endsection
