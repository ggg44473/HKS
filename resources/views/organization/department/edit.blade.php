@extends('layouts.master')
@section('script')
    <script src="{{ asset('js/organization.js') }}" defer></script>
@endsection
@section('title','組織OKR|編輯部門')
@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row u-margin-16 u-mt-32 u-ml-32">
                        <div class="col-md-12"><h5>編輯部門</h5></div>
                    </div>
                    <form method="POST" action="{{ route('department.update', $department->id) }}" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PATCH') }}
                        <div class="row u-ml-16 u-mr-16">
                            <div class="col-md-12 align-self-center">
                                <input id="departmentImgUpload" name="department_img_upload" type="file" class="u-hidden" accept="image/*"/>
                                <img id="departmentImg" class="avatar u-hidden u-margin-16" src="{{ $department->avatar }}" alt="">
                                <div id="departmentIcon" class="avatar text-center departmentIcon">
                                    <i class="fas fa-building text-white"></i>
                                    <i class="fas fa-upload text-white"></i>
                                </div>
                                <div class="form-group u-ml-16 w-25" style="display:inline-block">
                                    <label for="department_name">部門名稱<strong class="invalid-feedback"></strong></label>
                                    <input type="text" name="department_name" id="department_name" value="{{ $department->name }}" placeholder="請輸入部門名稱" class="form-control {{ $errors->has('department_name') ? ' is-invalid' : '' }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row u-ml-32 u-mr-32">
                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="department_description">部門概述<strong class="invalid-feedback"></strong></label>
                                        <textarea type="text" name="department_description" id="department_description" placeholder="請輸入部門概述" class="form-control {{ $errors->has('department_description') ? ' is-invalid' : '' }}" required>{{ $department->description }}</textarea>
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
