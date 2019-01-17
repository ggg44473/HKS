@extends('layouts.master')

@section('title','個人綜覽')

@section('script')
@endsection

@section('stylesheet')
@endsection

@section('content')
<div class="container">
    <div class="row m-3">
        <h4 class="col-md-7">帳號設定</h4>
    </div>
    <form name="form" method="POST" action="{{ route('user.update', auth()->user()->id) }}" enctype="multipart/form-data">
        @csrf
        {{ method_field('PATCH') }}
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-12">
                        <span class="u-pl-8 u-pr-8">帳號</span>
                        <span class="u-pl-8 u-pr-8">{{ $user->email }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <span for="name" class="u-pl-8 u-pr-8">姓名</span>
                        <input type="text" class="form-control u-pl-8 u-pr-8" id="name" value="{{ $user->name }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="align-self-center text-right">
                    </div>
                    <div class="align-self-center ">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="align-self-center text-right">
                        <span for="avatar">頭像</span>
                    </div>
                    <div class="col-md-10 align-self-center">
                        <img id="avatar" class="avatar" src="{{ $user->getAvatar() }}">
                        <input type="file" class="u-ml-8 align-self-center" id="input" name="avatar" value="{{ $user->name }}"
                            accept="image/*">
                    </div>
                </div>
                <hr />
            </div>
        </div>
    </form>
</div>
</div>
@endsection
