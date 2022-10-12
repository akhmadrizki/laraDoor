<!-- Logo -->
<a href="{{ route('admin.index') }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>T</b>D</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Timedoor</b> Admin</span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="hidden-xs">Hello, {{ Auth::user()->name }} </span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <img src="{{ asset('dashboard/img/user-ico.jpg')}}" class="img-circle" alt="User Image">
                        <p>
                            {{ Auth::user()->name }} as <i></i>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="text-right">
                            <a href="{{ route('logout') }}" class="btn btn-danger btn-flat"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit()">Sign
                                out</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>