@extends('welcome')

@section('title','重設密碼')

@section('modal')
<div class="modal-body" id="">
    <h5 class="text-dark mb-5">重設密碼</h5>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group row">
            <label for="email" class="col-md-12 text-primary">信箱</label>

            <div class="col-md-12">
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                    name="email" value="{{ $email ?? old('email') }}" required autofocus>

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
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                    name="password" required>

                @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="password-confirm" class="col-md-12 text-primary">確認密碼</label>

            <div class="col-md-12">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                    required>
            </div>
        </div>

        <div class="form-group row mt-5 mb-5 justify-content-center">
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">重設密碼</button>
            </div>
        </div>
    </form>

</div>
<script src="{{ asset('js/modal.js') }}" defer></script>
@endsection
