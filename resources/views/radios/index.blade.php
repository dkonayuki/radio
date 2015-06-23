@extends('layouts.app')

@section ('content')
<h2>List of available radio stations</h2>
    @foreach ($radios as $radio)
        @include ('radios/_radio', ['radio' => $radio])
    @endforeach
@endsection
