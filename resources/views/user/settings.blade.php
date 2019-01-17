@extends('layouts.master') 
@section('title','個人綜覽') 
@section('script')
<script src="{{ asset('js/avatar.js') }}" defer></script>
@endsection
 
@section('stylesheet')
@endsection
 
@section('content')
<div class="container">
    <div class="row m-3 justify-content-center">
        <h4 class="col-md-7">帳號設定</h4>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form name="form" method="POST" action="{{ route('user.update', auth()->user()->id) }}" enctype="multipart/form-data">
                @csrf {{ method_field('PATCH') }}

                <div class="u-pl-32 u-pr-32 form-group row">
                    <div class="col-12">
                        <span class="u-pl-8 u-pr-8">帳號</span>
                        <span class="u-pl-8 u-pr-8">{{ $user->email }}</span>
                    </div>
                </div>
                <div class="u-pl-32 u-pr-32 form-group row">
                    <div class="col-12">
                        <span for="name" class="u-pl-8 u-pr-8">姓名</span>
                        <input type="text" class="u-pl-8 u-pr-8" id="name" value="{{ $user->name }}" style="color: #495057; border: 1px solid #ced4da; background-color: #fff;">
                    </div>
                </div>
                <div class="u-pl-32 u-pr-32 u-pt-16 u-pb-16 form-group row">
                    <div class="col-12">
                        <span for="avatar" class="u-pl-8 u-pr-8">頭像</span>
                        <img id="avatar" class="avatar" src="{{ $user->getAvatar() }}">
                        <input type="file" class="u-ml-8 u-mr-8 align-self-bottom" id="input" name="avatar" value="{{ $user->name }}" accept="image/*">
                    </div>
                </div>
                <div class="u-pl-32 u-pr-32 form-group row">
                    <div class="col-12">
                        <span class="u-pl-8 u-pr-8">組織</span>
                        <span class="u-pl-8 u-pr-8">{{ $user->company->name }}</span>
                    </div>
                </div>
                <div class="u-pl-32 u-pr-32 form-group row">
                    <div class="col-12">
                        <span class="u-pl-8 u-pr-8">部門</span>
                        <span class="u-pl-8 u-pr-8">{{ $user->department->name }}</span>
                    </div>
                </div>
                <div class="u-pl-32 u-pr-32 form-group row">
                    <div class="col-12">
                        <span class="u-pl-8 u-pr-8">職稱</span>
                        <span class="u-pl-8 u-pr-8">{{ $user->position }}</span>
                    </div>
                </div>
                <div class="u-pl-32 u-pr-32 form-group row justify-content-end">
                    <div class="col-2">
                        <button type="submit" class="btn btn-primary">變更</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection