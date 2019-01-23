@extends('layouts.master')
@section('title','新增專案')
@section('script')
    <script src="{{ asset('js/avatar.js') }}" defer></script>
@endsection
@section('stylesheet')
    <link href="{{ asset('css/project.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="row justify-content-md-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="row u-margin-16 u-mt-32 u-ml-32">
                    <div class="col-md-12"><h5>新增專案</h5></div>
                </div>
                <form method="POST" action="{{ route('project.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row u-ml-16 u-mr-16">
                        <div class="col align-self-center">
                            <input id="imgUpload" name="avatar" type="file" class="u-hidden" accept="image/*"/>
                            <img id="avatarImg" class="avatar u-hidden u-margin-16" src="" alt="">
                            <img id="avatarImgUpload" class="avatar u-hidden u-margin-16" src="/img/icon/upload/gray.svg" alt="">
                            <div id="departmentIcon" class="avatar text-center uploadIcon">
                                <i class="fas fa-images text-white"></i>
                                <i class="fas fa-upload text-white"></i>
                            </div>
                            <div class="form-group u-ml-16 w-25" style="display:inline-block">
                                <label for="project_name">專案名稱<strong class="invalid-feedback"></strong></label>
                                <input type="text" name="project_name" id="project_name" value="" placeholder="請輸入專案名稱" class="form-control {{ $errors->has('project_name') ? ' is-invalid' : '' }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row u-ml-32 u-mr-32">
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="project_description">專案簡介<strong class="invalid-feedback"></strong></label>
                                    <textarea type="text" name="project_description" id="department_description" value="" placeholder="請輸入專案概述" class="form-control {{ $errors->has('department_description') ? ' is-invalid' : '' }}" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row u-ml-32 u-mr-32 u-mb-32 justify-content-end">
                        <div class="form-group u-pl-16 u-pr-16">
                            <button class="btn btn-primary" type="submit">建立</button>
                            <a href="{{ route('project') }}" class="btn btn-secondary">取消</a>   
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
