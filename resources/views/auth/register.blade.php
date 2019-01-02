@extends('layouts.wmaster')

@section('title','註冊')

@section('modal-content')
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
            <label for="email" class="col-md-12 text-primary">信箱</label>

            <div class="col-md-12">
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

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

        <div class="form-group row mt-5 mb-4 justify-content-center">
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary w-100">
                    註冊
                </button>
            </div>
        </div>

        <div class="text-center mb-2">
            <a class="text-primary" href="{{ route('login') }}">登入會員</a>
        </div>
    </form>
    <script src="{{ asset('js/modal.js') }}" defer></script>
@endsection
