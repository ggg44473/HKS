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
                    <a class="nav-item ml-1 mr-1 nav-link" href="#customer">推薦文章</a>
                    <a class="nav-item ml-1 mr-1 nav-link" href="#afford">升級方案</a>
                    <a class="nav-item btn btn-login" href="{{ route('login') }}">登 入</a>
                    <a class="nav-item btn btn-login" href="{{ route('register') }}">註 冊</a>
                </div>
            </div>
        </nav>
        <div>
            <div class="container">
                <div class="introduction mt-2" id="about">
                    <div class="card mt-5">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="text-center">
                                    <img src="img/icon/welcome/bgray.svg" class="rounded float-md-left img-fluid " alt="Card image cap">
                                </div>
                            </div>
                            <div class="col-md m-3">
                                <h4 class="card-title pt-3">關於我們</h4>

                                <p class="card-text">#免費 #PMS #目標管理</p>
                                <p class="card-text">現代知識密集型企業越來越多，變化也愈加快速，傳統的KPI指標難以有效管理，OKR管理法源於英特爾和谷歌，以目標導向的方式，上由企業下至個人，抓住工作核心、及衡量和判定抽象的目標。OKR管理法可以說是思考和溝通的工具，促使團隊不斷的深入思考和使用。</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="introduction" id="serve">
                    <div class="card-deck">
                        <div class="card">
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="img/icon/welcome/000.svg" class="rounded d-block w-100" alt="First slide">
                                        <div class="carousel-caption d-none d-md-block alphadark">
                                            <h6>新增目標</h6>
                                            <p class="text-left">從設立目標開始，所由指標與行動源自於此。</p>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <img src="img/icon/welcome/001.svg" class="rounded d-block w-100" alt="Second slide">
                                        <div class="carousel-caption d-none d-md-block alphadark">
                                            <h6>定期更新</h6>
                                            <p class="text-left">定期更新達成狀況與任務執行成果，以利每周回顧檢討。</p>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <img src="img/icon/welcome/002.svg" class="rounded d-block w-100" alt="Third slide">
                                        <div class="carousel-caption d-none d-md-block alphadark">
                                            <h6>具體作為</h6>
                                            <p class="text-left">在個人頁面快速查詢所有當前該做的任務。</p>
                                        </div>
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                    data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                    data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">OKR + Action 目標管理法</h5>
                                <p class="card-text">設定挑戰性的抽象目標(O)、評估目標狀況的量化指標(KR)、以及為了達成指標的具體作為(A)。三層式分類，讓目標更加清楚明確、隨時掌握狀況。</p>
                            </div>
                        </div>
                        <div class="card">
                            <div id="carouselExampleIndicators1" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleIndicators1" data-slide-to="0" class="active"></li>
                                    <li data-target="#carouselExampleIndicators1" data-slide-to="1"></li>
                                    <li data-target="#carouselExampleIndicators1" data-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="img/icon/welcome/100.svg" class="rounded d-block w-100" alt="First slide">
                                        <div class="carousel-caption d-none d-md-block alphadark">
                                            <h6>專案管理</h6>
                                            <p class="text-left">透過專案模式，可以跨部門設定專案的OKR。</p>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <img src="img/icon/welcome/101.svg" class="rounded d-block w-100" alt="Second slide">
                                        <div class="carousel-caption d-none d-md-block alphadark">
                                            <h6>行事曆</h6>
                                            <p class="text-left">自動添入您的目標與行動，提供ical格式下載。</p>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <img src="img/icon/welcome/102.svg" class="rounded d-block w-100" alt="Third slide">
                                        <div class="carousel-caption d-none d-md-block alphadark">
                                            <h6>即時通知</h6>
                                            <p class="text-left">到期、留言、更新提醒。加入追蹤還可訂閱更多消息。</p>
                                        </div>
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators1" role="button"
                                    data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators1" role="button"
                                    data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">PMS 專案管理</h5>
                                <p class="card-text">將OKR結合專案管理，搭配行事曆，讓組織可以更彈性的使用目標管理法。</p>
                            </div>
                        </div>
                        <div class="card">
                            <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleIndicators2" data-slide-to="0" class="active"></li>
                                    <li data-target="#carouselExampleIndicators2" data-slide-to="1"></li>
                                    <li data-target="#carouselExampleIndicators2" data-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="img/icon/welcome/200.svg" class="rounded d-block w-100" alt="First slide">
                                        <div class="carousel-caption d-none d-md-block alphadark">
                                            <h6>組織架構</h6>
                                            <p class="text-left">不限層級。公司、部門皆可設定OKR。</p>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <img src="img/icon/welcome/201.svg" class="rounded d-block w-100" alt="Second slide">
                                        <div class="carousel-caption d-none d-md-block alphadark">
                                            <h6>數據圖表</h6>
                                            <p class="text-left">依填入的數據，計算O的達成率與歷史折線圖。</p>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <img src="img/icon/welcome/202.svg" class="rounded d-block w-100" alt="Third slide">
                                        <div class="carousel-caption d-none d-md-block alphadark">
                                            <h6>追蹤</h6>
                                            <p class="text-left">追蹤人、專案、部門，確保內容有更新時能及時收到通知。</p>
                                        </div>
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button"
                                    data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators2" role="button"
                                    data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Organization 組織架構</h5>
                                <p class="card-text">不限層級，結合達成率數據統計、追蹤與通知功能，清楚掌握目標進展。</p>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="introduction" id="customer">
                    <h4 class="pt-5">推薦文章</h4>
                    <div class="row primarycircle align-items-center justify-content-center mt-2">
                        <h4 class="text-center">
                            <a href="https://drive.google.com/file/d/0Bxa3IMI9mGh9aXdBQkZNcEFaRGs/view">
                                OKR 案例故事
                            </a>
                        </h4>
                    </div>
                </span>
                <div class="introduction" id="afford">
                    <h4 class="pt-5">升級方案(FREE!)</h4>
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
