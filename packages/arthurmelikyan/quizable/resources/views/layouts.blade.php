<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>{{config('quizable.appname')}} dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700">
    <link rel="stylesheet" href="{{asset('vendor/quizable/css/style.css')}}"></link>
</head>
<body>

    <div id="quizable_wrap">
        <div id="quizable_some_block"></div>
        @yield('quizable_content')
    </div>

    <script src="{{asset('vendor/quizable/js/script.js')}}"></script>
    @stack('quizable_js')
</body>

</html>
