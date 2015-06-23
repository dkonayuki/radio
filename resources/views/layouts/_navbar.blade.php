<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ route('home') }}">PS Radio</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
<!--
        <li class="{{ Request::is('radios*') ? 'active' : '' }}"><a href="{{ route('radios.index') }}">Radio stations <span class="sr-only">(current)</span></a></li>
        <li class="{{ Request::is('profile') ? 'active' : '' }}"><a href="{{ route('profile') }}">Profile</a></li>
--!>
      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
      </form>
@if (isset($current_user))

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $current_user->name }} <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('profile') }}">Profile</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
          </ul>
        </li>
      </ul>
    <a id="nav-add" href="{{ route('radios.create') }}" class="btn btn-default navbar-right">Add</a>
@else
      <a id="nav-login" class="btn btn-default navbar-right" href="{{ url('/auth/login/') }}">Login</a>
@endif
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
