<html>
<head>
    <title>Radio</title>
{!! HTML::script('bower_components/jquery/dist/jquery.js') !!}
{!! HTML::script('bower_components/bootstrap/dist/js/bootstrap.js') !!}
{!! HTML::script('bower_components/typeahead.js/dist/typeahead.bundle.min.js') !!}
{!! HTML::script('js/app.js') !!}

{!! HTML::style('bower_components/bootstrap/dist/css/bootstrap.min.css') !!}
{!! HTML::style('css/app.css') !!}
<meta name='csrf-token' content='{{ csrf_token() }}'/>
</head>
<body>
    @include ('layouts/_navbar')
    <div class="container">
        @if (Session::has('message'))
            <div class="flash alert-info">
                {{ Session::get('message') }}
<span class="close-notification glyphicon glyphicon-remove" aria-hidden="true"></span>
            </div>
        @endif
        @if ($errors->any())
            <div class='flash alert-danger'>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div> 
        @endif
        @yield('content')
    </div>
</body>
</html>
