@extends('layouts.master')
@section('title','組織OKR|新增部門')
@section('script')
    <script src="{{ asset('js/avatar.js') }}" defer></script>
@endsection
@section('content')
<div class="row justify-content-md-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="row u-margin-16 u-mt-32 u-ml-32">
                    <div class="col-md-12"><h5>建立部門</h5></div>
                </div>
                <form method="POST" action="{{ route('department.store') }}" enctype="multipart/form-data">
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
                                <label for="department_name">部門名稱<strong class="invalid-feedback"></strong></label>
                                <input type="text" name="department_name" id="department_name" value="" placeholder="請輸入部門名稱" class="form-control {{ $errors->has('department_name') ? ' is-invalid' : '' }}" required>
                            </div>
                            <div class="form-group u-ml-16 w-25" style="display:inline-block">
                                <label for="department_parent">隸屬組織<strong class="invalid-feedback"></strong></label>
                                <select name="department_parent" id="department_parent" class="form-control">
                                    @if ($parent)
                                        <option value="parent{{ $parent->id }}" selected>{{ $parent->name }}</option>
                                    @endif
                                    @if ($self)
                                        <option value="self{{ $self->id }}" selected>{{ $self->name }}</option>
                                    @endif
                                    @foreach ($children as $child)
                                        <option value="department{{ $child->id }}">{{ $child->name }}</option>                                        
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row u-ml-32 u-mr-32">
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="department_description">部門概述<strong class="invalid-feedback"></strong></label>
                                    <textarea type="text" name="department_description" id="department_description" value="" placeholder="請輸入部門概述" class="form-control {{ $errors->has('department_description') ? ' is-invalid' : '' }}" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row u-ml-32 u-mr-32 u-mb-32 justify-content-end">
                        <div class="form-group u-pl-16 u-pr-16">
                            <button class="btn btn-primary" type="submit">建立</button>
                            <a href="{{ route('company.index') }}" class="btn btn-secondary">返回</a>   
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
