<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Timedoor Admin | Dashboard</title>

    @include('dashboard.utils.style')
</head>

<body class="hold-transition skin sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            @include('dashboard.partials.header')
        </header>

        <aside class="main-sidebar">
            @include('dashboard.partials.sidebar')
        </aside>

        @yield('content')

        @yield('modal')

        <footer class="main-footer">
            @include('dashboard.partials.footer')
        </footer>
    </div>

    @include('dashboard.utils.script')
    @stack('js')
</body>

</html>