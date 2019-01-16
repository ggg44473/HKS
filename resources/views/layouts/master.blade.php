<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/sidebar.js') }}" defer></script>
    {{-- <script src="{{ asset('js/scroll.js') }}" defer></script> --}}
    <script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript" defer></script>
    <script src="{{ asset('js/datepicker.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/js/ion.rangeSlider.min.js" defer></script>
    <script src="{{ asset('js/slider.js') }}" defer></script>
    @yield('script')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> --}}

    <!-- Icon -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('css/component.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/ion.rangeSlider.css') }}" rel="stylesheet" />
    @yield('stylesheet')
</head>
<body>
    {{-- <script src="https://unpkg.com/vue"></script>
    <script>
        var app = new Vue({
            el: '#app',
        });
    </script> --}}
    {{-- Chartjs --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
        {{-- Highcharts --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
        {{-- Fusioncharts --}}
        <script src="https://cdn.jsdelivr.net/npm/fusioncharts@3.12.2/fusioncharts.js" charset="utf-8"></script>
        {{-- Echarts --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts-en.min.js" charset="utf-8"></script>
        {{-- Frappe --}}
        <script src="https://cdn.jsdelivr.net/npm/frappe-charts@1.1.0/dist/frappe-charts.min.iife.js"></script>
        {{-- C3 --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.7.0/d3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.6.7/c3.min.js"></script>
    @include('layouts.sidebar')
    <div id="app" class="content">
        @include('layouts.navbar')
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
