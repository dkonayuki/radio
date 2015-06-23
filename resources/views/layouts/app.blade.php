<html>
<head>
    <title>PS Radio</title>
{!! HTML::script('bower_components/jquery/dist/jquery.js') !!}
{!! HTML::script('js/app.js') !!}
{!! HTML::script('bower_components/bootstrap/dist/js/bootstrap.js') !!}
{!! HTML::style('css/app.css') !!}
{!! HTML::style('bower_components/bootstrap/dist/css/bootstrap.min.css') !!}
<meta name='csrf-token' content='{{ csrf_token() }}'/>
</head>
<body>
    @include ('layouts/_navbar')
    <div class="container">
        @if (Session::has('message'))
            <div class="flash alert-info">
                <p>{{ Session::get('message') }}</p>
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
