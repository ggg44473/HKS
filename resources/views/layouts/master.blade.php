<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | Goal Care</title>
    <link rel="shortcut icon" href="{{ asset('img/logo/favicon.ico') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/sidebar.js') }}" defer></script>
    {{-- <script src="{{ asset('js/scroll.js') }}" defer></script> --}}
    <script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript" defer></script>
    <script src="{{ asset('js/datepicker.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/js/ion.rangeSlider.min.js" defer></script>
    <script src="{{ asset('js/slider.js') }}" defer></script>
    {{-- <script src="https://js.pusher.com/3.1/pusher.min.js" defer></script> --}}
    <script src="{{ asset('js/notification.js') }}" defer></script>
    <script src="{{ asset('js/textarea.js') }}" defer></script>
    @yield('script')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{--
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> --}}

    <!-- Icon -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
        crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('css/component.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/ion.rangeSlider.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/bootstrap-notifications.min.css') }}" rel="stylesheet">

    @yield('stylesheet')
</head>

<body>
    <div id="app">
        @include('layouts.navbar')
        @include('layouts.sidebar')
        <main class="py-4 content u-pb-48 {{ isset($_COOKIE['openSideBar']) && $_COOKIE['openSideBar'] == 'true'? 'open':'' }}">
            @yield('content')
        </main>
    </div>
</body>

</html>
