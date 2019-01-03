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
    <script src="{{ asset('js/scroll.js') }}" defer></script>
    <script src="{{ asset('js/modal.js') }}" defer></script>

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
<body>
    <div id="app" onload="moveScol()" onunload="getScrollPosition()">
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
                    <button type="button" class="btn btn-login" data-toggle="modal" data-target="#modal">
                        會員登入
                    </button>
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
                </div>
            </div>
        </div>
        <footer class="footer bg-dark">
            <div class="container">
                <p class="final-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores ea, voluptate accusamus pariatur quidem est odio saepe itaque. Debitis cumque voluptatibus nihil quibusdam nisi, consequatur odit qui ratione excepturi dolore.</p>
                <p class="copyright">Copyright © 2019 HKS</p>
            </div>
        </footer>
    </div>

    <!-- 若登入/註冊有錯誤，顯示Modal -->
    @if (count($errors) > 0)
    <script>
        window.onload = function(){showModal();};
    </script>
    @endif

    <!-- Modal -->
    <div id='app'>
        <div class="modal fade" id="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <!-- Login -->
                        <div class="modal-body" id="login">
                            <div class="text-center mb-3">
                                <img src="{{ asset('/img/icon/user/green.svg')}}" alt="" style="width: 90px; height: 90px;">
                            </div>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="loginEmail" class="text-md-right text-primary">信箱</label>
                                    <input id="loginEmail" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="請輸入信箱" value="{{ old('email') }}" required autofocus>
                        
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                </div>
                                <div class="form-group">
                                    <label for="loginPassword" class="text-md-right text-primary">密碼</label>
                                    <input id="loginPassword" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="請輸入密碼" required>
                        
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label text-muted" for="remember">Remember Me</label>
                                        </div>
                                    </div>
                                    
                                    @if (Route::has('password.request'))
                                    <div class="col-md-6 text-right">
                                        <a class="text-primary" href="{{ route('password.request') }}">忘記密碼</a>
                                    </div>
                                    @endif
                        
                                </div>
                        
                                <div class="row form-group mt-5 mb-5">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary w-100">登入</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-primary w-100 btn-cmoney">
                                            <span style="color:crimson;">ＣM</span>oney
                                        </button>
                                    </div>
                                </div>
                        
                                <div class="text-center mb-2">
                                    <a class="text-primary" href="#!" onclick="showRegister()">註冊會員</a>
                                </div>
                            </form>
                        </div>

                        <!-- Register -->
                        <div class="modal-body" id="register">
                            <div class="text-center mb-3">
                                <img src="{{ asset('/img/icon/user/green.svg')}}" alt="" style="width: 90px; height: 90px;">
                            </div>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                        
                                <div class="form-group row">
                                    <label for="name" class="col-md-12 text-primary">姓名</label>
                        
                                    <div class="col-md-12">
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                        
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                        
                                <div class="form-group row">
                                    <label for="registerEmail" class="col-md-12 text-primary">信箱</label>
                        
                                    <div class="col-md-12">
                                        <input id="registerEmail" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                        
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                        
                                <div class="form-group row">
                                    <label for="password" class="col-md-12 text-primary">密碼</label>
                        
                                    <div class="col-md-12">
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                        
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                        
                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-12 text-primary">密碼確認</label>
                        
                                    <div class="col-md-12">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>
                        
                                <div class="form-group row mt-4 mb-4 justify-content-center">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary w-100">
                                            註冊
                                        </button>
                                    </div>
                                </div>
                        
                                <div class="text-center mb-2">
                                    <a class="text-primary" href="#!" onclick="showLogin()">登入會員</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>