<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('img/logo/favicon.ico') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','welcome')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/scroll.js') }}" defer></script>
    @yield('script')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Icon -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
        crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('css/component.css') }}" rel="stylesheet">
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">

</head>

<body onload="moveScol()" onunload="getScrollPosition()">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark navbar-laravel bg-primary">
            <!-- LOGO -->
            <a class="navbar-brand font-weight-bold text-white" href="{{ url('/') }}">
                <img class="d-inline-block align-top mr-1" width="30" height="30" src="{{ asset('/img/logo/white.svg') }}"
                    alt=""> Goal Care
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <!-- Right Side Of Navbar -->
                <div class="navbar-nav nav-pills ml-auto mr-4">
                    <a class="nav-item ml-1 mr-1 nav-link" href="#about">關於我們</a>
                    <a class="nav-item ml-1 mr-1 nav-link" href="#serve">服務項目</a>
                    <a class="nav-item ml-1 mr-1 nav-link" href="#customer">平台客戶</a>
                    <a class="nav-item ml-1 mr-1 nav-link" href="#afford">升級方案</a>
                    <a class="nav-item btn btn-login" href="{{ route('login') }}">登 入</a>
                    <a class="nav-item btn btn-login" href="{{ route('register') }}">註 冊</a>
                </div>
            </div>
        </nav>
        <div>
            <div class="container">
                <div class="introduction" id="about">
                    <h4 class="pt-5">關於我們</h4>
                </div>
                <div class="introduction" id="serve">
                    <h4 class="pt-5">服務項目</h4>
                </div>
                <div class="introduction" id="customer">
                    <h4 class="pt-5">平台客戶</h4>
                </div>
                <div class="introduction" id="afford">
                    <h4 class="pt-5">升級方案</h4>
                    <div class="row mt-5">
                        <div class="col-md-4 mb-5">
                            <ul class="price">
                                <li class="header">Basic</li>
                                <li class="grey">$ 9.99 / year</li>
                                <li>10GB Storage</li>
                                <li>10 Emails</li>
                                <li>10 Domains</li>
                                <li>1GB Bandwidth</li>
                                <li class="grey price-bottom"><a href="{{ route('register') }}" class="btn btn-primary">Sign
                                        Up</a></li>
                            </ul>
                        </div>

                        <div class="col-md-4 mb-5">
                            <ul class="price">
                                <li class="header">Pro</li>
                                <li class="grey">$ 24.99 / year</li>
                                <li>25GB Storage</li>
                                <li>25 Emails</li>
                                <li>25 Domains</li>
                                <li>2GB Bandwidth</li>
                                <li class="grey price-bottom"><a href="{{ route('register') }}" class="btn btn-primary">Sign
                                        Up</a></li>
                            </ul>
                        </div>

                        <div class="col-md-4 mb-5">
                            <ul class="price">
                                <li class="header">Premium</li>
                                <li class="grey">$ 49.99 / year</li>
                                <li>50GB Storage</li>
                                <li>50 Emails</li>
                                <li>50 Domains</li>
                                <li>5GB Bandwidth</li>
                                <li class="grey price-bottom"><a href="{{ route('register') }}" class="btn btn-primary">Sign
                                        Up</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer bg-dark">
            <div class="container">
                <p class="final-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores ea,
                    voluptate accusamus pariatur quidem est odio saepe itaque. Debitis cumque voluptatibus nihil
                    quibusdam nisi, consequatur odit qui ratione excepturi dolore.</p>
                <p class="copyright">Copyright © 2019 HKS</p>
            </div>
        </footer>

        <!-- Modal -->
        <div class="modal {{ count($errors) == 0 ? 'fade' : '' }}" id="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    @yield('modal')
                </div>
            </div>
        </div>
    </div>
</body>

</html>
