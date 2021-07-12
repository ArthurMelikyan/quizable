<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>{{ config('quizable.appname') }} dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ config('quizable.favico') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/quizable/css/style.css') }}">
    </link>
    @stack('css')
</head>
<body>
    <main class="d-flex page">
        <div class="wrapper w-100 d-flex flex-column">
            @include('arthurmelikyan::quiz.partials.header')
            <div class="content d-flex flex-column flex-column-fluid" id="app">
                <div id="quizable_some_block"></div>
                    @include('arthurmelikyan::quiz.partials.nav')
                    <div class="content d-flex flex-column flex-column-fluid mt-4">
                        @yield('quizable_content')
                    </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('/vendor/quizable/js/script.js') }}"></script>
    <script>
        window.urlprefix = "{{ config('quizable.urlprefix') }}";
        window.question_options = "{{ config('quizable.enabled_question_options') }}";
        @if (session()->has('success'))
            Swal.fire({
                title: 'Success', text: "{!! session()->get('success') !!}", icon: 'success', timer: 5000
            });
        @endif
    </script>
    <script src="{{ asset('vendor/quizable/js/app.js') }}"></script>
    @stack('quizable_js')
    <script>
        window.trans = <?php
        // copy all translations from /resources/lang/CURRENT_LOCALE/* to global JS variable
        $lang_files = File::files(resource_path() . '/lang/' . App::getLocale());
        $trans = [];
        foreach ($lang_files as $f) {
            $filename = pathinfo($f)['filename'];
            if (pathinfo($f)['filename'] == '__shop__') {
                $trans[$filename] = trans($filename);
            }
        }

        echo json_encode($trans);
        ?>;
    </script>
</body>

</html>
