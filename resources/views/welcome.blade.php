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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Icon -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('css/component.css') }}" rel="stylesheet">

</head>
<body onload="moveScol()" onunload="getScrollPosition()">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark navbar-laravel bg-primary">
            <!-- LOGO --> 
            <a class="navbar-brand font-weight-bold text-white ml-3" href="{{ url('/') }}">
                <img src="{{ asset('/img/logo/white.svg') }}" alt="">
                Goal Care
            </a>
            <div class="collapse navbar-collapse">
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav nav-pills ml-auto mr-5"> 
                    <li class="nav-item mr-4">
                        <a class="nav-link" href="#about">關於我們</a>
                    </li>
                    <li class="nav-item mr-4">
                        <a class="nav-link" href="#serve">服務項目</a>
                    </li>
                    <li class="nav-item mr-4">
                        <a class="nav-link" href="#customer">平台客戶</a>
                    </li>
                    <li class="nav-item mr-4">
                        <a class="nav-link" href="#afford">升級方案</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @guest
                    <a href="{{ route('login') }}" class="btn btn-login" >會員登入</a>
                    @endguest          
                </ul>
            </div>
        </nav>
        <div>
            <div class="introduction" id="about">
                <div class="container">
                    <h3 class="pt-5">關於我們</h3>
                </div>
            </div>
            <div class="introduction" id="serve">
                <div class="container">
                    <h3 class="pt-5">服務項目</h3>
                </div>
            </div>
            <div class="introduction" id="customer">
                <div class="container">
                    <h3 class="pt-5">平台客戶</h3>
                </div>
            </div>
            <div class="introduction" id="afford">
                <div class="container">
                    <h3 class="pt-5">升級方案</h3>
                    <div class="row mt-5">
                        <div class="col-md-4">
                            <ul class="price">
                                <li class="header">Basic</li>
                                <li class="grey">$ 9.99 / year</li>
                                <li>10GB Storage</li>
                                <li>10 Emails</li>
                                <li>10 Domains</li>
                                <li>1GB Bandwidth</li>
                                <li class="grey"><a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a></li>
                            </ul>
                        </div>
                                      
                        <div class="col-md-4">
                            <ul class="price">
                                <li class="header">Pro</li>
                                <li class="grey">$ 24.99 / year</li>
                                <li>25GB Storage</li>
                                <li>25 Emails</li>
                                <li>25 Domains</li>
                                <li>2GB Bandwidth</li>
                                <li class="grey"><a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a></li>
                            </ul>
                        </div>
                                      
                        <div class="col-md-4">
                            <ul class="price">
                                <li class="header">Premium</li>
                                <li class="grey">$ 49.99 / year</li>
                                <li>50GB Storage</li>
                                <li>50 Emails</li>
                                <li>50 Domains</li>
                                <li>5GB Bandwidth</li>
                                <li class="grey"><a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer bg-dark">
            <div class="container">
                <p class="final-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores ea, voluptate accusamus pariatur quidem est odio saepe itaque. Debitis cumque voluptatibus nihil quibusdam nisi, consequatur odit qui ratione excepturi dolore.</p>
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