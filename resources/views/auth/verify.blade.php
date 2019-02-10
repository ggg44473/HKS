@extends('layouts.master')
@section('title','信箱驗證')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">{{ __('您尚未通過電子郵件驗證') }}</div>

                <div class="card-body ">
                    @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('新的驗證鏈接已發送到您的電子郵件地址。') }}
                    </div>
                    @endif
                    {{ __('在繼續之前，請檢查您的電子郵件進行驗證。') }}
                    {{ __('如果您尚未收到驗證信') }}， <a href="{{ route('verification.resend') }}"><strong>{{ __('點擊此處重新發送') }}</strong></a>。
                    <img src="{{ asset('/img/icon/mail/mail1.svg')}}" class="rounded d-block w-100" alt="First slide">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
