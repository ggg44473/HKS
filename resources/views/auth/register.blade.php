
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
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="請輸入姓名" name="name" value="{{ old('name') }}" required autofocus>

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
                <input id="registerEmail" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="請輸入信箱" name="email" value="{{ old('email') }}" required>

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
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="請輸入密碼" name="password" required>

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
                <input id="password-confirm" type="password" class="form-control" placeholder="請確認密碼" name="password_confirmation" required>
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
            <a class="text-primary" href="{{ route('login') }}" onclick="showLogin()">登入會員</a>
        </div>
    </form>
</div>