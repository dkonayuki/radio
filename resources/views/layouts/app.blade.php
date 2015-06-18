<html>
<head>
    <title>PS Radio</title>
{!! HTML::script('bower_components/jquery/dist/jquery.js') !!}
{!! HTML::script('bower_components/bootstrap/dist/js/bootstrap.js') !!}
{!! HTML::style('bower_components/bootstrap/dist/css/bootstrap.min.css') !!}
</head>
<body>
@include ('layouts/_navbar')
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
