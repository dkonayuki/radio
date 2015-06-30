@extends ('layouts.app')

@section ('content')
    <h2> Edit radio station </h2>
    {!! Form::model($radio, ['method' => 'PATCH', 'route' => ['radios.update', $radio->id], 'files' => 'true']) !!}
        
    @include ('radios/_form', ['submit_text' => 'Edit Radio station'])

    {!! Form::close() !!}

@endsection
