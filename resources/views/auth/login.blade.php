@extends('welcome')

@section('title','登入')

@section('modal')
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
    
            <div class="row form-group mt-5 mb-3 justify-content-center">
                <div class="col-md-6 mb-2">
                    <button type="submit" class="btn btn-primary w-100">登入</button>
                </div>
            </div>
    
            <div class="text-center mb-2">
                <a class="text-primary" href="{{ route('register') }}">註冊會員</a>
            </div>
        </form>
    </div>
    <script src="{{ asset('js/modal.js') }}" defer></script>
@endsection
