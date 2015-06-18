@extends('layouts.app')

@section ('content')
<h2>List of available radio stations</h2>
<ul>
    @foreach ($radios as $radio)
    <li>
        <a href="{{ route('radios.show', $radio->id) }}">{{ $radio->name }}</a>
    </li>
    @endforeach
</ul>
@endsection
