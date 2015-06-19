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
        @yield('content')
    </div>
</body>
</html>
