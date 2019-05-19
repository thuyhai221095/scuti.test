<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">
            <h1 class="logo">SCUTI TEST</h1>
        </a>
    </div>
    <ul class="nav navbar-right top-nav">
                   
       
    </ul>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li class="@if (Request::is('/')) {{'active'}} @endif">
                <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
            </li>
            <li class="@if (Request::is('member')) {{'active'}} @endif">
                <a href="{{ url('member') }}"><i class="fa fa-fw fa-users"></i> Member</a>
            </li>
            <li class="@if (Request::is('project')) {{'active'}} @endif">
                <a href="{{ url('project') }}"><i class="fa fa-fw fa fa-tasks"></i> Project</a>
            </li>
        </ul>
    </div>
</nav>