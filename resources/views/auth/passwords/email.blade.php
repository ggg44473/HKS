@extends('welcome')

@section('title','忘記密碼')

@section('modal')
<div class="modal-body" id="">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <h5 class="text-dark mb-5">重設密碼</h5>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

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

        <div class="form-group row mt-5 mb-5 justify-content-center">
            <div class="col-md-6">
                <a href="{{ route('login') }}" class="btn btn-secondary w-100">
                    返回
                </a>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary w-100">
                    寄送
                </button>
            </div>
        </div>
    </form>
</div>
<script src="{{ asset('js/modal.js') }}" defer></script>

@endsection
