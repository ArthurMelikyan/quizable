<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>{{config('quizable.appname')}} dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{asset('vendor/quizable/css/style.css')}}"></link>
</head>
<body>

    <div id="quizable_wrap">
        <div id="quizable_some_block"></div>
        <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-fixed page-header-dark main-content-narrow">
            @include('arthurmelikyan::quiz.partials.header')      
            @include('arthurmelikyan::quiz.partials.nav')      
            @yield('quizable_content')
        </div>
    </div>

    <script src="{{asset('vendor/quizable/js/script.js')}}"></script>
    @stack('quizable_js')
</body>

</html>
