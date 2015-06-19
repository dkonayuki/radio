@extends('layouts.app')

@section ('content')
<h2>List of available radio stations</h2>
<ul>
    @foreach ($radios as $radio)
    <li>
        <a href="{{ route('radios.show', $radio->id) }}">{!! $radio->name !!}</a> | <a href="{{ route('radios.edit', $radio->id) }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a> | <a href="{{ route('radios.destroy', $radio->id) }}" data-method="delete" class="radio-delete-btn"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a> 
    </li>
    @endforeach
</ul>
<a class="btn btn-info" href="{{ route('radios.create') }}">New</a>
@endsection
