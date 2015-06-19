@extends ('layouts.app')

@section ('content')
    <h2> Add a new radio station</h2>
    {!! Form::model(new App\Radio, ['route' => ['radios.store']]) !!}
        @include ('radios/_form', ['submit_text' => 'Create'])
    {!! Form::close() !!} 
@endsection
