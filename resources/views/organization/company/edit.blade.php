@extends('layouts.master')
@section('script')
    <script src="{{ asset('js/avatar.js') }}" defer></script>
@endsection
@section('title','組織OKR|編輯公司')
@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row u-margin-16 u-mt-32 u-ml-32">
                        <div class="col-md-12"><h5>編輯組織</h5></div>
                    </div>
                    <form method="POST" action="{{ route('company.update') }}" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PATCH') }}
                        <div class="row u-ml-16 u-mr-16">
                            <div class="col-md-12 align-self-center">
                                <input id="imgUpload" name="avatar" type="file" class="u-hidden" accept="image/*"/>
                                @if ($company->avatar)
                                    <img id="avatarImg" class="avatar u-margin-16" src="{{ $company->getAvatar() }}" alt="">
                                    <img id="avatarImgUpload" class="avatar u-margin-16 u-hidden" src="/img/icon/upload/gray.svg" alt="">
                                @else
                                    <div id="companyIcon" class="avatar text-center companyIcon">
                                        <i class="fas fa-building text-white"></i>
                                        <i class="fas fa-upload text-white"></i>
                                    </div>
                                @endif
                                <div class="form-group u-ml-16 w-25" style="display:inline-block">
                                    <label for="company_name">組織名稱<strong class="invalid-feedback"></strong></label>
                                    <input type="text" name="company_name" id="company_name" value="{{ $company->name }}" placeholder="請輸入組織名稱" class="form-control {{ $errors->has('company_name') ? ' is-invalid' : '' }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row u-ml-32 u-mr-32">
                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="company_description">組織概述<strong class="invalid-feedback"></strong></label>
                                        <textarea type="text" name="company_description" id="company_description" placeholder="請輸入組織概述" class="form-control {{ $errors->has('company_description') ? ' is-invalid' : '' }}" required>{{ $company->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row u-ml-32 u-mr-32 u-mb-32 justify-content-end">
                            <div class="form-group u-pl-16 u-pr-16">
                                <button class="btn btn-primary" type="submit">修改</button>   
                                <a href="{{ route('organization') }}" class="btn btn-secondary">取消</a>   
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
