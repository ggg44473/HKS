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
                                <input id="departmentImgUpload" name="avatar" type="file" class="u-hidden" accept="image/*"/>
                                <img id="departmentImg" class="avatar u-hidden u-margin-16" src="{{ $department->getAvatar() }}" alt="">
                                <div id="departmentIcon" class="avatar text-center departmentIcon">
                                    <i class="fas fa-images text-white"></i>
                                    <i class="fas fa-upload text-white"></i>
                                </div>
                                <div class="form-group u-ml-16 w-25" style="display:inline-block">
                                    <label for="department_name">部門名稱<strong class="invalid-feedback"></strong></label>
                                    <input type="text" name="department_name" id="department_name" value="{{ $department->name }}" placeholder="請輸入部門名稱" class="form-control {{ $errors->has('department_name') ? ' is-invalid' : '' }}" required>
                                </div>
                                <div class="form-group u-ml-16 w-25" style="display:inline-block">
                                    <label for="department_parent">隸屬組織<strong class="invalid-feedback"></strong></label>
                                    <select name="department_parent" id="department_parent" class="form-control">
                                        @if ($department->parent)
                                            <option value="department{{ $department->parent->id }}" selected>{{ $department->parent->name }}</option>
                                            @foreach ($department->parent->children as $child)
                                                @if ($child->id != $department->id)
                                                    <option value="department{{ $child->id }}">{{ $child->name }}</option>                                                                                        
                                                @endif
                                            @endforeach
                                        @else
                                            <option value="company{{ $department->company->id }}" selected>{{ $department->company->name }}</option>
                                        @endif
                                    </select>
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
                                <a href="{{ route('company.index') }}" class="btn btn-secondary">取消</a>   
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
